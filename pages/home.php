<?php
$page_title = "Página Inicial";
require_once '../includes/header.php';
?>

<section class="hero">
  <h1>Transforme suas ideias em realidade</h1>
  <p>Plataforma completa para gerenciamento e desenvolvimento de projetos empreendedores</p>
  <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="cta-buttons">
      <a href="cadastro.php" class="btn btn-primary">Começar Agora</a>
      <a href="login.php" class="btn btn-secondary">Fazer Login</a>
    </div>
  <?php else: ?>
    <div class="cta-buttons">
      <a href="dashboard.php" class="btn btn-primary">Ver Meus Projetos</a>
      <a href="criar_projeto.php" class="btn btn-secondary">Novo Projeto</a>
    </div>
  <?php endif; ?>
</section>

<section class="features">
  <h2>Por que escolher o NE?</h2>
  <div class="features-grid">
    <div class="feature">
      <i class="fas fa-lightbulb"></i>
      <h3>Ideias Organizadas</h3>
      <p>Desenvolva e organize todas as suas ideias em um único lugar</p>
    </div>
    <div class="feature">
      <i class="fas fa-tasks"></i>
      <h3>Gestão de Tarefas</h3>
      <p>Acompanhe o progresso do seu projeto com tarefas e metas</p>
    </div>
    <div class="feature">
      <i class="fas fa-tools"></i>
      <h3>Ferramentas Integradas</h3>
      <p>Acesse ferramentas úteis como Canvas, Pitch e muito mais</p>
    </div>
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>