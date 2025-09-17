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
                $success = "Cadastro realizado com sucesso!";
                // Redirecionar para login após 2 segundos
                header("refresh:2;url=login.php");
            } else {
                $error = "Erro ao cadastrar. Tente novamente.";
            }
        }
    }
}

$page_title = "Cadastro";
require_once '../includes/header.php';
?>

<div class="auth-container">
  <div class="auth-form">
    <h2>Criar Conta</h2>
    <p>Preencha os dados para se cadastrar</p>
    
    <?php if (!empty($error)): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
      <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" id="name" name="name" class="custom-input" placeholder="Digite seu nome" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" class="custom-input" placeholder="Digite seu e-mail" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password" class="custom-input" placeholder="Digite sua senha" required>
      </div>
      
      <div class="form-group">
        <label for="confirmPassword">Confirmar Senha</label>
        <input type="password" id="confirmPassword" name="confirmPassword" class="custom-input" placeholder="Confirme sua senha" required>
      </div>
      
      <button type="submit" class="btn btn-primary btn-full">CADASTRAR</button>
    </form>
    
    <div class="auth-link">
      Já tem uma conta? <a href="login.php">Faça login</a>
    </div>
  </div>
</div>

<?php require_once '../includes/footer.php'; ?>