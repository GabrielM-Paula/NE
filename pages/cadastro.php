<?php
session_start();
require_once '../includes/db_connection.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    // Validações
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de e-mail inválido.";
    } elseif ($password !== $confirmPassword) {
        $error = "As senhas não coincidem.";
    } elseif (strlen($password) < 6) {
        $error = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        // Verificar se o e-mail já existe
        $stmt = $pdo->prepare("SELECT id_usuario FROM Usuario WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Este e-mail já está cadastrado.";
        } else {
            // Hash da senha
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Inserir no banco de dados
            $stmt = $pdo->prepare("INSERT INTO Usuario (nome, email, senha) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashedPassword])) {
                $success = "<center>Cadastro realizado com sucesso!</center>";
                // Redirecionar para login após 2 segundos
                header("refresh:2;url=Login.php");
            } else {
                $error = "<center>Erro ao cadastrar. Tente novamente.</center>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - NE</title>
  <link rel="stylesheet" href="../assets/css/Cadastro.css">
  <style>
    .error { color: red; margin-bottom: 15px; }
    .success { color: green; margin-bottom: 15px; }
  </style>
</head>
<body>
  <div class="container">
    <center>
      <a href="Home.php">
        <img src="../assets/images/logo.png" alt="Logo NE" class="logo-img" >
      </a>
    </center>
    <div class="welcome">
      <h2>Bem-Vindo</h2>
      <h4>Crie sua conta para continuar</h4>
    </div>
    
    <?php if (!empty($error)): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
      <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="name">Nome</label>
        <input autocomplete="off" type="text" id="name" name="name" class="custom-input" placeholder="Digite seu nome" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="email">E-mail</label>
        <input autocomplete="off" type="email" id="email" name="email" class="custom-input" placeholder="Digite seu e-mail" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="password">Senha</label>
        <input autocomplete="off" type="password" id="password" name="password" class="custom-input" placeholder="Digite sua senha" required>
      </div>
      
      <div class="form-group">
        <label for="confirmPassword">Confirmar Senha</label>
        <input autocomplete="off" type="password" id="confirmPassword" name="confirmPassword" class="custom-input" placeholder="Confirme sua senha" required>
      </div>
      
      <button type="submit" class="btn">CADASTRAR</button>
    </form>
    
    <div class="login-link">
      Já tem uma conta? <a href="Login.php">Faça login</a>
      
    </div>
  </div>
</body>
</html>