<?php
session_start();
require_once 'db_connection.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validações
    if (empty($email) || empty($password)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        // Buscar usuário no banco de dados
        $stmt = $pdo->prepare("SELECT id_usuario, nome, email, senha FROM Usuario WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['senha'])) {
            // Login bem-sucedido
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_email'] = $user['email'];
            
            // Redirecionar para a página principal
            header("Location: meusProjetos.php");
            exit();
        } else {
            $error = "E-mail ou senha incorretos.";
        }
    }
}

// Login com Google
$client_id = "315485308526-c6g22elcoge3eukt5b8bb42vf47gmsjc.apps.googleusercontent.com"; // substitua aqui
$redirect_uri = "http://localhost/Ne/Tela/dashboard.php";

$scope = "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email";

$auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
  'client_id' => $client_id,
  'redirect_uri' => $redirect_uri,
  'response_type' => 'code',
  'scope' => $scope,
  'access_type' => 'offline',
  'prompt' => 'consent'
]);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - NE</title>
  <link rel="stylesheet" href="../css/Login.css">
  <style>
    .error { color: red; margin-bottom: 15px; }
  </style>
</head>
<body>
  <div class="container">
    <center>
      <a href="Home.php">
        <img src="../Tela/logo.png" alt="Logo NE" class="logo-img" >
      </a>
    </center>

    <div class="welcome">
      <h2>Bem-Vindo</h2>
      <h4>Faça login para continuar</h4>
    </div>
    
    <?php if (!empty($error)): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">   
      <div class="form-group">
        <label for="email">E-mail</label>
        <input autocomplete="off" type="email" id="email" name="email" class="custom-input" placeholder="Digite seu e-mail" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="password">Senha</label>
        <input autocomplete="off" type="password" id="password" name="password" class="custom-input" placeholder="Digite sua senha" required>
      </div>
    
      <button type="submit" class="btn">ENTRAR</button>
    </form>
    
    <div class="login-link">
      Não tem uma conta? <a href="Cadastro.php"> Cadastre-se</a>
      <br>
      Faça Login com o  <a href="<?= $auth_url ?>">Google</a>
    </div>
  </div>
</body>
</html>