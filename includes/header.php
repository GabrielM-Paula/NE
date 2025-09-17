<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="container">
      <a href="../pages/home.php" class="logo">NÉ</a>
      <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="../pages/dashboard.php">Meus Projetos</a>
          <a href="../pages/perfil.php">Meu Perfil</a>
          <a href="../pages/logout.php">Sair</a>
          <span class="user-welcome">Olá, <?php echo $_SESSION['user_name']; ?></span>
        <?php else: ?>
          <a href="../pages/login.php">Entrar</a>
          <a href="../pages/cadastro.php">Cadastrar</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
  <main class="container">