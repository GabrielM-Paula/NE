
<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['projectName'];
    $descricao = $_POST['projectDescription'];
    $progresso = $_POST['projectStatus'];
    $id_usuario = $_SESSION['user_id'];
    $data_criacao = date('Y-m-d');
    
    $stmt = $pdo->prepare("INSERT INTO Ideia (id_usuario, nome, descricao, data_criacao, progresso) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_usuario, $nome, $descricao, $data_criacao, $progresso]);
    
    echo json_encode(['success' => true, 'message' => 'Projeto criado com sucesso']);
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meus Projetos - NE</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f5f7fa;
      color: #333;
      line-height: 1.6;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 0;
      margin-bottom: 30px;
    }
    
    .logo {
      font-size: 28px;
      font-weight: bold;
      color: #2c3e50;
    }
    
    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #3498db;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }
    
    .welcome-section {
      margin-bottom: 40px;
    }
    
    .welcome-section h1 {
      font-size: 32px;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    
    .welcome-section p {
      font-size: 18px;
      color: #7f8c8d;
    }
    
    .new-project-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background-color: #3498db;
      color: white;
      padding: 15px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 30px;
      transition: background-color 0.3s;
    }
    
    .new-project-btn:hover {
      background-color: #2980b9;
    }
    
    .projects-section {
      margin-bottom: 40px;
    }
    
    .section-title {
      font-size: 24px;
      color: #2c3e50;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #eaeaea;
    }
    
    .project-cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }
    
    .project-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }
    
    .project-card:hover {
      transform: translateY(-5px);
    }
    
    .project-card h3 {
      font-size: 18px;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    
    .project-date {
      color: #7f8c8d;
      font-size: 14px;
      margin-bottom: 15px;
    }
    
    .project-status {
      display: inline-block;
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: bold;
    }
    
    .status-in-progress {
      background-color: #ffeaa7;
      color: #d35400;
    }
    
    .status-completed {
      background-color: #d5f5e3;
      color: #27ae60;
    }
    
    /* Modal para criar novo projeto */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }
    
    .modal-content {
      background-color: white;
      width: 90%;
      max-width: 600px;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .modal-header h2 {
      color: #2c3e50;
    }
    
    .close-modal {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #7f8c8d;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #2c3e50;
    }
    
    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 16px;
    }
    
    .form-group textarea {
      min-height: 120px;
      resize: vertical;
    }
    
    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 20px;
    }
    
    .btn {
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }
    
    .btn-primary {
      background-color: #3498db;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #2980b9;
    }
    
    .btn-secondary {
      background-color: #e7e7e7;
      color: #333;
    }
    
    .btn-secondary:hover {
      background-color: #ddd;
    }
    
    @media (max-width: 768px) {
      .project-cards {
        grid-template-columns: 1fr;
      }
      
      .user-info span {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="logo">NE</div>
      <div class="user-info">
        <span>Olá, Usuário</span>
        <div class="user-avatar">U</div>
      </div>
    </header>
    
    <section class="welcome-section">
      <h1>Meus Projetos</h1>
      <p>Gerencie seus projetos facilmente</p>
    </section>
    
    <a href="#" class="new-project-btn" id="newProjectBtn">
      <i class="fas fa-plus"></i> Novo Projeto
    </a>
    
    <section class="projects-section">
      <h2 class="section-title">Projetos Recentes</h2>
      <div class="project-cards">
        <div class="project-card">
          <h3>Projeto 1</h3>
          <p class="project-date">10 de Agosto</p>
          <span class="project-status status-in-progress">Em andamento</span>
        </div>
      </div>
    </section>
    
    <section class="projects-section">
      <h2 class="section-title">Em andamento</h2>
      <div class="project-cards">
        <div class="project-card">
          <h3>Projeto 1</h3>
          <p class="project-date">10 de Agosto</p>
          <span class="project-status status-in-progress">Em andamento</span>
        </div>
        <div class="project-card">
          <h3>Projeto 2</h3>
          <p class="project-date">15 de Agosto</p>
          <span class="project-status status-in-progress">Em andamento</span>
        </div>
      </div>
    </section>
    
    <section class="projects-section">
      <h2 class="section-title">Concluídos</h2>
      <div class="project-cards">
        <div class="project-card">
          <h3>Projeto 1</h3>
          <p class="project-date">10 de Agosto</p>
          <span class="project-status status-completed">Concluído</span>
        </div>
        <div class="project-card">
          <h3>Projeto 3</h3>
          <p class="project-date">20 de Agosto</p>
          <span class="project-status status-completed">Concluído</span>
        </div>
      </div>
    </section>
  </div>
  
  <!-- Modal para criar novo projeto -->
  <div class="modal" id="projectModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Criar Novo Projeto</h2>
        <button class="close-modal">&times;</button>
      </div>
      
      <form id="projectForm">
        <div class="form-group">
          <label for="projectName">Nome do Projeto</label>
          <input type="text" id="projectName" required placeholder="Digite o nome do projeto">
        </div>
        
        <div class="form-group">
          <label for="projectDescription">Descrição</label>
          <textarea id="projectDescription" placeholder="Descreva seu projeto..."></textarea>
        </div>
        
        <div class="form-group">
          <label for="projectStatus">Status</label>
          <select id="projectStatus">
            <option value="em_progresso">Em andamento</option>
            <option value="concluida">Concluído</option>
          </select>
        </div>
        
        <div class="form-actions">
          <button type="button" class="btn btn-secondary" id="cancelProject">Cancelar</button>
          <button type="submit" class="btn btn-primary">Criar Projeto</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Elementos do modal
    const modal = document.getElementById('projectModal');
    const newProjectBtn = document.getElementById('newProjectBtn');
    const closeModalBtn = document.querySelector('.close-modal');
    const cancelProjectBtn = document.getElementById('cancelProject');
    const projectForm = document.getElementById('projectForm');
    
    // Abrir modal
    newProjectBtn.addEventListener('click', function(e) {
      e.preventDefault();
      modal.style.display = 'flex';
    });
    
    // Fechar modal
    function closeModal() {
      modal.style.display = 'none';
    }
    
    closeModalBtn.addEventListener('click', closeModal);
    cancelProjectBtn.addEventListener('click', closeModal);
    
    // Fechar modal clicando fora dele
    window.addEventListener('click', function(e) {
      if (e.target === modal) {
        closeModal();
      }
    });
    
    // Processar formulário
    projectForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const projectName = document.getElementById('projectName').value;
      const projectDescription = document.getElementById('projectDescription').value;
      const projectStatus = document.getElementById('projectStatus').value;
      
      // Aqui você normalmente enviaria os dados para o servidor
      // Vamos simular a adição de um novo projeto
      
      // Criar elemento do projeto
      const newProject = {
        name: projectName,
        description: projectDescription,
        status: projectStatus,
        date: new Date().toLocaleDateString('pt-BR')
      };
      
      // Adicionar à lista (apenas para demonstração)
      addProjectToUI(newProject);
      
      // Fechar modal e limpar formulário
      closeModal();
      projectForm.reset();
      
      // Mostrar mensagem de sucesso
      alert('Projeto criado com sucesso!');
    });
    
    // Função para adicionar projeto à interface
    function addProjectToUI(project) {
      const statusClass = project.status === 'em_progresso' ? 'status-in-progress' : 'status-completed';
      const statusText = project.status === 'em_progresso' ? 'Em andamento' : 'Concluído';
      
      const projectCard = document.createElement('div');
      projectCard.className = 'project-card';
      projectCard.innerHTML = `
        <h3>${project.name}</h3>
        <p class="project-date">${project.date}</p>
        <span class="project-status ${statusClass}">${statusText}</span>
      `;
      
      // Adicionar à seção correspondente
      const sectionId = project.status === 'em_progresso' ? 'Em andamento' : 'Concluídos';
      const sections = document.querySelectorAll('.projects-section');
      
      for (let section of sections) {
        if (section.querySelector('.section-title').textContent === sectionId) {
          section.querySelector('.project-cards').appendChild(projectCard);
          break;
        }
      }
    }
  </script>
</body>
</html>