<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - NE</title>
  <link rel="stylesheet" href="../css/Cadastro.css">
</head>
<body>
  <div class="container">
    <center>
        <img src="../Tela/logo.png" alt="Logo NE" class="logo-img">
    </cente>
    <div class="welcome">
      <h2>Bem-Vindo</h2>
      <h4>Faça login para continuar</h4>
    </div>
    
    <form>
      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" id="name" class="custom-input" placeholder="Digite seu nome">
      </div>
      
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" class="custom-input" placeholder="Digite seu e-mail">
      </div>
      
      <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" class="custom-input" placeholder="Digite sua senha">
      </div>
      
      <div class="form-group">
        <label for="confirmPassword">Confirmar Senha</label>
        <input type="password" id="confirmPassword" class="custom-input" placeholder="Confirme sua senha">
      </div>
      
      <button type="submit" class="btn">CADASTRAR</button>
    </form>
    
    <div class="login-link">
      Já tem uma conta? <a href="Login.php">Faça login</a>
      <br>
      Faça Login com o Google
      
    </div>
  </div>
</body>
</html>