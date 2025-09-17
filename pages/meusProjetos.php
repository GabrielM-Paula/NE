<?php
require_once '../includes/auth_check.php';
require_once '../includes/db_connection.php';

// Buscar projetos do usuário
$stmt = $pdo->prepare("
    SELECT i.*, 
           COUNT(t.id_tarefa) as total_tarefas,
           SUM(CASE WHEN t.concluida = 1 THEN 1 ELSE 0 END) as tarefas_concluidas
    FROM Ideia i
    LEFT JOIN Tarefa t ON i.id_ideia = t.id_ideia
    WHERE i.id_usuario = ?
    GROUP BY i.id_ideia
    ORDER BY i.data_criacao DESC
");
$stmt->execute([$user_id]);
$projetos = $stmt->fetchAll();

$page_title = "Meus Projetos";
require_once '../includes/header.php';
?>

<div class="dashboard-header">
  <h1>Meus Projetos</h1>
  <p>Gerencie seus projetos facilmente</p>
  <a href="criar_projeto.php" class="btn btn-primary">
    <i class="fas fa-plus"></i> Novo Projeto
  </a>
</div>

<?php if (count($projetos) > 0): ?>
  <div class="projects-grid">
    <?php foreach ($projetos as $projeto): ?>
      <div class="project-card">
        <h3><?php echo htmlspecialchars($projeto['nome']); ?></h3>
        <p class="project-date">Criado em <?php echo date('d/m/Y', strtotime($projeto['data_criacao'])); ?></p>
        <p class="project-description"><?php echo htmlspecialchars(substr($projeto['descricao'], 0, 100)); ?>...</p>
        
        <?php if ($projeto['modo_desenvolvimento'] == 'guiado'): ?>
          <div class="project-stats">
            <span class="stat">
              <strong><?php echo $projeto['total_tarefas']; ?></strong> Tarefas
            </span>
            <span class="stat">
              <strong><?php echo $projeto['tarefas_concluidas']; ?></strong> Concluídas
            </span>
          </div>
        <?php endif; ?>
        
        <span class="project-status status-<?php echo $projeto['progresso'] == 'concluida' ? 'completed' : 'in-progress'; ?>">
          <?php echo $projeto['progresso'] == 'concluida' ? 'Concluído' : 'Em andamento'; ?>
        </span>
        
        <div class="project-actions">
          <a href="projeto.php?id=<?php echo $projeto['id_ideia']; ?>" class="btn btn-secondary">Ver Detalhes</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="empty-state">
    <i class="fas fa-lightbulb"></i>
    <h3>Você ainda não tem projetos</h3>
    <p>Crie seu primeiro projeto para começar</p>
    <a href="criar_projeto.php" class="btn btn-primary">Criar Primeiro Projeto</a>
  </div>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>