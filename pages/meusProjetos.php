<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

require_once '../includes/db_connection.php';

$id_usuario = $_SESSION['user_id'];

// Buscar ideias do usuário
$sql = "SELECT * FROM Ideia WHERE id_usuario = ? ORDER BY data_criacao DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$ideias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Projetos - NE</title>
    <link rel="stylesheet" href="../assets/css/Projetos.css">
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    
</head>
<body>
   <!-- Header -->
  <header class="topo">
    <div class="menu" id="openModal">☰</div>
    <center>
      <img src="../assets/images/neAzul.png" alt="Logo NE" class="logo">
    </center>
    <div></div>
  </header>

  <!-- Modal -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Menu</h2>
      <p>Deseja sair da sua conta?</p>
      <a href="logout.php"><button>Logout</button></a>
    </div>
  </div>

  <!-- Conteúdo -->
  <main class="conteudo">
    <h2>Meus Projetos</h2>
    <p class="sub">Gerencie seus projetos facilmente</p>

    <!-- Botão Novo Projeto -->
    <form action="novo.php" method="get" style="margin:0 0 18px 0;">
      <button type="submit" class="btn" id="novoBtn">+ Novo Projeto</button>
    </form>

    <!-- Projetos Recentes -->
    <h3>Projetos Recentes</h3>
    <div class="lista">
      <!-- Exemplo 1 -->
      <div class="card">
        <div>
          <p class="titulo">Projeto 1</p>
          <p class="data">10 de Agosto</p>
        </div>
        <span class="status em_progresso">Em andamento</span>
        <div class="seta">›</div>
      </div>

      <!-- Exemplo 2 -->
      <div class="card">
        <div>
          <p class="titulo">Projeto 1</p>
          <p class="data">10 de Agosto</p>
        </div>
        <span class="status concluida">Concluído</span>
        <div class="seta">›</div>
      </div>

      <!-- Exemplo 3 -->
      <div class="card" style="border: 2px solid #38BDF8;">
        <div>
          <p class="titulo">Projeto 1</p>
          <p class="data">10 de Agosto</p>
        </div>
        <span class="status concluida">Concluído</span>
        <div class="seta">›</div>
      </div>
    </div>
  </main>


    <script>
        // Modal JS
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModal");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Botão novo projeto
        document.addEventListener('DOMContentLoaded', function(){
            var btnNovo = document.getElementById('novoBtn');
            if(btnNovo){
                btnNovo.addEventListener('click', function(e){
                    // comportamento padrão do form já envia para novo.php
                });
            }
        });
    </script>
</body>
</html>
