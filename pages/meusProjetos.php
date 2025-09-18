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
    <style>
        /* Modal básico */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 20% auto; 
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
        .modal button {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="topo">
        <!-- Menu ☰ abre o modal -->
        <div class="menu" id="openModal" style="cursor:pointer;">☰</div>
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

        <br><br>

        <!-- Projetos Recentes -->
        <h3>Projetos Recentes</h3>
        <div class="lista">
            <?php if ($ideias): ?>
                <?php foreach ($ideias as $i): ?>
                  
                    <div class="card">
                        <div>
                            <p class="titulo"><?= htmlspecialchars($i['nome']) ?></p>
                            <p class="data"><?= date("d \d\e F", strtotime($i['data_criacao'])) ?></p>
                        </div>
                        <span class="status <?= $i['progresso'] ?>">
                            <?= $i['progresso'] == "em_progresso" ? "Em andamento" : "Concluído" ?>
                        </span>
                        <div class="seta">›</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum projeto cadastrado ainda.</p>
            <?php endif; ?>
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
