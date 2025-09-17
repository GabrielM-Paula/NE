<?php
require_once '../includes/auth_check.php';
require_once '../includes/db_connection.php';

// Verificar se o ID do projeto foi passado
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id_ideia = $_GET['id'];

// Buscar informações do projeto
$stmt = $pdo->prepare("
    SELECT i.*, u.nome as autor 
    FROM Ideia i 
    JOIN Usuario u ON i.id_usuario = u.id_usuario 
    WHERE i.id_ideia = ? AND i.id_usuario = ?
");
$stmt->execute([$id_ideia, $user_id]);
$projeto = $stmt->fetch();

if (!$projeto) {
    header("Location: dashboard.php");
    exit();
}

// Buscar tarefas do projeto (se for modo guiado)
$tarefas = [];
if ($projeto['modo_desenvolvimento'] == 'guiado') {
    $stmt = $pdo->prepare("SELECT * FROM Tarefa WHERE id_ideia = ? ORDER BY data_criacao");
    $stmt->execute([$id_ideia]);
    $tarefas = $stmt->fetchAll();
}

// Buscar ferramentas do projeto
$stmt = $pdo->prepare("
    SELECT f.* 
    FROM Ferramenta f 
    JOIN Ideia_Ferramenta if ON f.id_ferramenta = if.id_ferramenta 
    WHERE if.id_ideia = ?
");
$stmt->execute([$id_ideia]);
$ferramentas = $stmt->fetchAll();

$page_title = $projeto['nome'];
require_once '../includes/header.php';
?>

<div class="project-header">
  <a href="dashboard.php" class="back-btn">
    <i class="fas fa-arrow-left"></i> Voltar para Meus Projetos
  </a>
  <h1><?php echo htmlspecialchars($projeto['nome']); ?></h1>
  <p class="project-date">Criado em <?php echo date('d/m/Y', strtotime($projeto['data_criacao'])); ?></p>
  <span class="dev-mode-badge mode-<?php echo $projeto['modo_desenvolvimento']; ?>">
    <?php echo $projeto['modo_desenvolvimento'] == 'guiado' ? 'Desenvolvimento Guiado' : 'Desenvolvimento Livre'; ?>
  </span>
</div>

<div class="divider"></div>

<section class="project-description">
  <h2>Descrição</h2>
  <p><?php echo nl2br(htmlspecialchars($projeto['descricao'])); ?></p>
</section>

<?php if ($projeto['modo_desenvolvimento'] == 'guiado'): ?>
  <div class="stats-container">
    <div class="stat-card">
      <div class="stat-number"><?php echo count($tarefas); ?></div>
      <div class="stat-label">Tarefas</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-number">
        <?php 
          $concluidas = array_filter($tarefas, function($t) { return $t['concluida']; });
          echo count($concluidas); 
        ?>
      </div>
      <div class="stat-label">Concluídas</div>
    </div>
  </div>
  
  <div class="divider"></div>
  
  <section class="tasks-section">
    <h2>Tarefas</h2>
    <div class="tasks-list">
      <?php foreach ($tarefas as $tarefa): ?>
        <div class="task-item <?php echo $tarefa['concluida'] ? 'completed' : ''; ?>">
          <label>
            <input type="checkbox" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?> disabled>
            <span><?php echo htmlspecialchars($tarefa['descricao']); ?></span>
          </label>
          <?php if ($tarefa['concluida'] && $tarefa['data_conclusao']): ?>
            <span class="task-date">Concluída em <?php echo date('d/m/Y', strtotime($tarefa['data_conclusao'])); ?></span>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<div class="divider"></div>

<section class="tools-section">
  <h2>Ferramentas</h2>
  <div class="tools-grid">
    <?php foreach ($ferramentas as $ferramenta): ?>
      <div class="tool-card">
        <h3><?php echo htmlspecialchars($ferramenta['nome']); ?></h3>
        <p class="tool-description"><?php echo htmlspecialchars($ferramenta['descricao']); ?></p>
        <a href="#" class="btn btn-secondary">Acessar Ferramenta</a>
      </div>
    <?php endforeach; ?>
  </div>
  
  <a href="#" class="add-tool-btn" id="addToolBtn">
    <i class="fas fa-plus"></i> Adicionar Ferramenta
  </a>
</section>

<!-- Modal para adicionar ferramentas -->
<div class="modal" id="toolsModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Adicionar Ferramentas</h2>
      <button class="close-modal">&times;</button>
    </div>
    
    <p>Selecione uma ferramenta para adicionar ao seu projeto:</p>
    
    <div class="tools-modal-grid">
      <?php
      // Buscar todas as ferramentas disponíveis
      $stmt = $pdo->prepare("SELECT * FROM Ferramenta WHERE id_ferramenta NOT IN (
          SELECT id_ferramenta FROM Ideia_Ferramenta WHERE id_ideia = ?
      )");
      $stmt->execute([$id_ideia]);
      $ferramentas_disponiveis = $stmt->fetchAll();
      
      foreach ($ferramentas_disponiveis as $ferramenta):
      ?>
        <div class="modal-tool-card" data-tool-id="<?php echo $ferramenta['id_ferramenta']; ?>">
          <h3><?php echo htmlspecialchars($ferramenta['nome']); ?></h3>
          <p><?php echo htmlspecialchars($ferramenta['descricao']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
// JavaScript para o modal de ferramentas
document.getElementById('addToolBtn').addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('toolsModal').style.display = 'flex';
});

document.querySelector('.close-modal').addEventListener('click', function() {
  document.getElementById('toolsModal').style.display = 'none';
});

// Adicionar ferramenta ao projeto
document.querySelectorAll('.modal-tool-card').forEach(card => {
  card.addEventListener('click', function() {
    const toolId = this.getAttribute('data-tool-id');
    
    // Enviar requisição AJAX para adicionar ferramenta
    fetch('adicionar_ferramenta.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id_ideia=<?php echo $id_ideia; ?>&id_ferramenta=${toolId}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      } else {
        alert('Erro ao adicionar ferramenta: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
});
</script>

<?php require_once '../includes/footer.php'; ?>