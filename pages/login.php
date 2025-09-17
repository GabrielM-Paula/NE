<?php
session_start();
require_once '../includes/db_connection.php';

$error = '';

// Processar login tradicional
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
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "E-mail ou senha incorretos.";
        }
    }
}

// Login com Google
// $auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
//   'client_id' => GOOGLE_CLIENT_ID,
//   'redirect_uri' => GOOGLE_REDIRECT_URI,
//   'response_type' => 'code',
//   'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
//   'access_type' => 'offline',
//   'prompt' => 'consent'
// ]);

$page_title = "Login";
require_once '../includes/header.php';
?>

<div class="auth-container">
  <div class="auth-form">
    <h2>Bem-Vindo</h2>
    <p>Faça login para continuar</p>
    
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
    
      <button type="submit" class="btn btn-primary btn-full">ENTRAR</button>
    </form>

    <div class="separator">ou</div>
    
    <a href="<?= $auth_url ?>" class="btn btn-google btn-full">
      <i class="fab fa-google"></i> Entrar com Google
    </a>
    
    <div class="auth-link">
      Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>
    </div>
  </div>
</div>

<?php require_once '../includes/footer.php'; ?>