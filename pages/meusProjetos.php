<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

require_once '../includes/db_connection.php';

$id_usuario = $_SESSION['user_id'];

// Buscar ideias do usuário
$sql = "SELECT * FROM Ideia WHERE id_usuario = ? ORDER BY tempo_hora DESC";
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

    <!-- Abas Ativos/Arquivados -->
    <div class="abas-projetos">
      <button class="aba aba-ativa" data-aba="ativos">Ativos</button>
      <button class="aba" data-aba="arquivados">Arquivados</button>
    </div>

    <!-- Importa os ícones do Phosphor -->
    <script src="https://unpkg.com/phosphor-icons"></script>

    <!-- Conteúdo da aba Ativos -->
    <div id="conteudo-ativos" class="conteudo-aba conteudo-ativo">
      <!-- Cabeçalho de Projetos Recentes com botão de filtro -->
      <div class="header-filtro">
        <h3>Projetos Recentes</h3>
        <button id="filtroBtn" class="filtro-icone" title="Filtrar projetos">
          <i class="ph ph-funnel-simple"></i>
        </button>
      </div>

      <!-- Painel de Filtro -->
      <div id="painelFiltro" class="painel-filtro">
        <h4>Filtros</h4>

        <label>Status</label>
        <div class="opcoes">
          <button class="opcao" id="filtro-andamento" value="false">Em andamento</button>
          <button class="opcao" id="filtro-concluido">Concluído</button>
        </div>

        <label>Data</label>
        <div class="opcoes">
          <button class="opcao" id="filtro-recente">↓ Mais Recente</button>
          <button class="opcao" id="filtro-antigo">↑ Mais Antigo </button>
        </div>

        <div class="acoes-filtro">
          <button class="limpar">Limpar Filtros</button>
          <button class="aplicar">Aplicar</button>
        </div>
      </div>
      <br>

      <!-- Lista de Projetos Ativos -->
      <div class="lista">
        <?php if (empty($ideias)): ?>
          <p>Você ainda não criou nenhum projeto.</p>
        <?php else: ?>
          <?php foreach ($ideias as $ideia): ?>
            <a href="Descricao.php?id=<?= $ideia['id_ideia'] ?>" style="text-decoration:none; color:inherit;">
              <div class="card">
                <div>
                  <p class="titulo"><?= htmlspecialchars($ideia['nome']) ?></p>
                  <div class="data-linha">
                    <p class="data"><?= date("d/m/Y H:i", strtotime($ideia['tempo_hora'])) ?></p>
                  </div>
                </div>
                <span class="status em_progresso">Em andamento</span>
                <div class="seta">›</div>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Conteúdo da aba Arquivados -->
    <div id="conteudo-arquivados" class="conteudo-aba">
      <!-- Lista de Projetos Arquivados -->
      <div class="lista">
        <p>Projetos arquivados aparecerão aqui</p>
      </div>
    </div>
  </main>

  <!-- Script do filtro (SEU AMIGO VAI MODIFICAR) -->
  <script>
/* ===========================
      MODAL DO MENU
=========================== */
var modal = document.getElementById("myModal");
var btn = document.getElementById("openModal");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function () {
  modal.style.display = "block";
};

span.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};


/* ===========================
      FILTRO
=========================== */

const filtroBtn = document.getElementById("filtroBtn");
const painelFiltro = document.getElementById("painelFiltro");

filtroBtn.addEventListener("click", () => {
  painelFiltro.style.display =
    painelFiltro.style.display === "flex" ? "none" : "flex";
});

const filtroAndamento = document.getElementById("filtro-andamento");
const filtroConcluido = document.getElementById("filtro-concluido");
const filtroRecente = document.getElementById("filtro-recente");
const filtroAntigo = document.getElementById("filtro-antigo");
const limparBtn = document.querySelector(".limpar");
const aplicarBtn = document.querySelector(".aplicar");

// IMPORTANTE: seleciona o <a> que contém o card
const lista = Array.from(document.querySelectorAll(".lista a"));

function aplicarFiltros() {
  let statusFiltro = null;
  if (filtroAndamento.classList.contains("ativo")) statusFiltro = "Em andamento";
  if (filtroConcluido.classList.contains("ativo")) statusFiltro = "Concluído";

  let ordem = "desc"; // padrão
  if (filtroRecente.classList.contains("ativo")) ordem = "desc";
  if (filtroAntigo.classList.contains("ativo")) ordem = "asc";

  // Filtrar por status
  lista.forEach(link => {
    const status = link.querySelector(".status").innerText;
    if (statusFiltro && status !== statusFiltro) {
      link.style.display = "none";
    } else {
      link.style.display = "block";
    }
  });

  // Ordenar por data
  const ordenados = [...lista].sort((a, b) => {
    const dataA = new Date(a.querySelector(".data").innerText.split("/").reverse().join("-"));
    const dataB = new Date(b.querySelector(".data").innerText.split("/").reverse().join("-"));
    return ordem === "desc" ? dataB - dataA : dataA - dataB;
  });

  // Reposicionar os links SEM quebrar o layout
  const listaContainer = document.querySelector(".lista");
  ordenados.forEach(link => listaContainer.appendChild(link));

  // Fechar painel após aplicar
  painelFiltro.style.display = "none";
}

// Ativar botões ao clicar
document.querySelectorAll(".opcoes .opcao").forEach(btn => {
  btn.addEventListener("click", () => {
    btn.parentElement.querySelectorAll(".opcao").forEach(b => b.classList.remove("ativo"));
    btn.classList.add("ativo");
  });
});

// Limpar filtros
limparBtn.addEventListener("click", () => {
  document.querySelectorAll(".opcoes .opcao").forEach(b => b.classList.remove("ativo"));
  lista.forEach(link => (link.style.display = "block"));
});

// Aplicar filtros
aplicarBtn.addEventListener("click", aplicarFiltros);
</script>

</body>
</html>