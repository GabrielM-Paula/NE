<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projeto 1 - NE</title>
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
    
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #3498db;
      text-decoration: none;
      font-weight: 500;
    }
    
    .project-header {
      margin-bottom: 30px;
    }
    
    .project-title {
      font-size: 32px;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    
    .project-date {
      color: #7f8c8d;
      font-size: 16px;
      margin-bottom: 20px;
    }
    
    .divider {
      height: 1px;
      background-color: #e0e0e0;
      margin: 25px 0;
    }
    
    .section-title {
      font-size: 24px;
      color: #2c3e50;
      margin-bottom: 20px;
    }
    
    .project-description {
      background-color: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
      line-height: 1.8;
    }
    
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    
    .stat-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      text-align: center;
    }
    
    .stat-number {
      font-size: 36px;
      font-weight: bold;
      color: #3498db;
      margin-bottom: 5px;
    }
    
    .stat-label {
      color: #7f8c8d;
      font-size: 16px;
    }
    
    .tools-section {
      margin-bottom: 40px;
    }
    
    .tools-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }
    
    .tool-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s;
    }
    
    .tool-card:hover {
      transform: translateY(-5px);
    }
    
    .tool-card h3 {
      font-size: 18px;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    
    .tool-description {
      color: #7f8c8d;
      margin-bottom: 15px;
    }
    
    .add-tool-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background-color: #3498db;
      color: white;
      padding: 12px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      margin-top: 15px;
    }
    
    /* Modal para adicionar ferramentas */
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
      overflow-y: auto;
      padding: 20px;
    }
    
    .modal-content {
      background-color: white;
      width: 90%;
      max-width: 800px;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      max-height: 90vh;
      overflow-y: auto;
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
    
    .tools-modal-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    
    .modal-tool-card {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      cursor: pointer;
      transition: all 0.3s;
      border: 2px solid transparent;
    }
    
    .modal-tool-card:hover {
      background-color: #e9ecef;
      border-color: #3498db;
    }
    
    .modal-tool-card h3 {
      font-size: 18px;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    
    .modal-tool-card p {
      color: #7f8c8d;
      font-size: 14px;
    }
    
    .dev-mode-badge {
      display: inline-block;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 15px;
    }
    
    .mode-guided {
      background-color: #d5f5e3;
      color: #27ae60;
    }
    
    .mode-free {
      background-color: #fdebd0;
      color: #d35400;
    }
    
    @media (max-width: 768px) {
      .tools-grid,
      .tools-modal-grid {
        grid-template-columns: 1fr;
      }
      
      .stats-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <a href="projetos.html" class="back-btn">
        <i class="fas fa-arrow-left"></i> Voltar para Meus Projetos
      </a>
      <div class="logo">NÉ</div>
    </header>
    
    <div class="project-header">
      <h1 class="project-title">Projeto 1</h1>
      <p class="project-date">Criado em 10 de Agosto</p>
      <span class="dev-mode-badge mode-guided">Desenvolvimento Guiado</span>
    </div>
    
    <div class="divider"></div>
    
    <section class="project-description">
      <h2 class="section-title">Descrição</h2>
      <p>dsadsadsan njks dasjoda dsadsada<br>
      dsajdoiasjda dsadas dsadasdasdsa<br>
      dsadsadsa dsadsadsadsa ss<br>
      dsahodsahod djsoladjsoai idjsaoijdsao<br>
      jdosaijdas dsajodasi doisajoidas diosajoid<br>
      diosajoo idsja doisaj jdasoi</p>
    </section>
    
    <div class="stats-container">
      <div class="stat-card">
        <div class="stat-number">5</div>
        <div class="stat-label">Tarefas</div>
      </div>
      
      <div class="stat-card">
        <div class="stat-number">3</div>
        <div class="stat-label">Concluídas</div>
      </div>
    </div>
    
    <div class="divider"></div>
    
    <section class="tools-section">
      <h2 class="section-title">Ferramentas</h2>
      <div class="tools-grid">
        <div class="tool-card">
          <h3>Canva</h3>
          <p class="tool-description">Criar designs</p>
        </div>
        
        <div class="tool-card">
          <h3>Pitch</h3>
          <p class="tool-description">Apresentações</p>
        </div>
      </div>
      
      <a href="#" class="add-tool-btn" id="addToolBtn">
        <i class="fas fa-plus"></i> Adicionar Ferramenta
      </a>
    </section>
  </div>
  
  <!-- Modal para adicionar ferramentas -->
  <div class="modal" id="toolsModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Adicionar Ferramentas</h2>
        <button class="close-modal">&times;</button>
      </div>
      
      <p>Selecione uma ferramenta para adicionar ao seu projeto:</p>
      
      <div class="tools-modal-grid">
        <div class="modal-tool-card" data-tool="business-model-canva">
          <h3>Business Model Canvas</h3>
          <p>Modelo editável para planejamento de negócios</p>
        </div>
        
        <div class="modal-tool-card" data-tool="canva">
          <h3>Canva</h3>
          <p>Crie designs profissionais</p>
        </div>
        
        <div class="modal-tool-card" data-tool="pitch">
          <h3>Pitch</h3>
          <p>Crie apresentações impactantes</p>
        </div>
        
        <div class="modal-tool-card" data-tool="financial-plan">
          <h3>Planejamento Financeiro</h3>
          <p>Modelo para projeções financeiras</p>
        </div>
        
        <div class="modal-tool-card" data-tool="swot">
          <h3>Análise SWOT</h3>
          <p>Ferramenta de análise estratégica</p>
        </div>
        
        <div class="modal-tool-card" data-tool="marketing-plan">
          <h3>Plano de Marketing</h3>
          <p>Estruture suas estratégias de marketing</p>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Elementos do modal
    const modal = document.getElementById('toolsModal');
    const addToolBtn = document.getElementById('addToolBtn');
    const closeModalBtn = document.querySelector('.close-modal');
    const toolCards = document.querySelectorAll('.modal-tool-card');
    
    // Abrir modal
    addToolBtn.addEventListener('click', function(e) {
      e.preventDefault();
      modal.style.display = 'flex';
    });
    
    // Fechar modal
    function closeModal() {
      modal.style.display = 'none';
    }
    
    closeModalBtn.addEventListener('click', closeModal);
    
    // Fechar modal clicando fora dele
    window.addEventListener('click', function(e) {
      if (e.target === modal) {
        closeModal();
      }
    });
    
    // Selecionar ferramenta
    toolCards.forEach(card => {
      card.addEventListener('click', function() {
        const toolName = this.querySelector('h3').textContent;
        const toolId = this.getAttribute('data-tool');
        
        // Adicionar ferramenta ao projeto (aqui você faria uma requisição AJAX)
        addToolToProject(toolId, toolName);
        
        // Fechar o modal
        closeModal();
      });
    });
    
    // Função para adicionar ferramenta ao projeto
    function addToolToProject(toolId, toolName) {
      // Aqui você faria uma requisição para o backend
      // Por enquanto, vamos apenas adicionar visualmente
      
      const toolsGrid = document.querySelector('.tools-grid');
      const newTool = document.createElement('div');
      newTool.className = 'tool-card';
      newTool.innerHTML = `
        <h3>${toolName}</h3>
        <p class="tool-description">${getToolDescription(toolId)}</p>
      `;
      
      toolsGrid.appendChild(newTool);
      
      // Mensagem de sucesso
      alert(`Ferramenta "${toolName}" adicionada com sucesso!`);
    }
    
    // Obter descrição da ferramenta
    function getToolDescription(toolId) {
      const descriptions = {
        'business-model-canva': 'Modelo editável de Business Model Canvas',
        'canva': 'Criar designs profissionais',
        'pitch': 'Criar apresentações impactantes',
        'financial-plan': 'Modelo para projeções financeiras',
        'swot': 'Ferramenta de análise estratégica',
        'marketing-plan': 'Plano de marketing estruturado'
      };
      
      return descriptions[toolId] || 'Ferramenta de apoio ao projeto';
    }
  </script>
</body>
</html>