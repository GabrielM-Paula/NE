<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - NE</title>
  <link rel="stylesheet" href="../css/Login.css">
</head>
<body>
  <div class="container">
    <h1 class="logo">NE</h1>

    <div class="welcome">
      <h2>Bem-Vindo</h2>
      <h4>Faça login para continuar</h4>
    </div>
    
    <form>   
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" class="custom-input" placeholder="Digite seu e-mail">
      </div>
      
      <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" class="custom-input" placeholder="Digite sua senha">
      </div>
    
      <button type="submit" class="btn">CADASTRAR</button>
    </form>
    
    <div class="login-link">
      Não tem uma conta? <a href="Cadastro.php"> Cadastra-se</a>
    </div>
  </div>
</body>
</html>