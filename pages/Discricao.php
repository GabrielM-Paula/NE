<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projeto 1</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
      background: #f8fafc;
      color: #1e293b;
      line-height: 1.5;
      padding: 16px;
      min-height: 100vh;
    }

    .container {
      max-width: 100%;
      margin: 0 auto;
    }

    .header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 20px;
    }

    .back-btn {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      font-size: 18px;
      cursor: pointer;
    }

    .logo {
      flex: 1;
      text-align: center;
    }

    .logo-placeholder {
      height: 36px;
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 18px;
    }

    .status {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .status h2 {
      font-size: 22px;
      font-weight: 700;
    }

    .tag {
      background: #dbeafe;
      color: #1d4ed8;
      font-weight: 600;
      font-size: 14px;
      padding: 6px 12px;
      border-radius: 20px;
    }

    .date {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #64748b;
      margin-bottom: 20px;
    }

    .card {
      background: #fff;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }

    .card h3 {
      font-weight: 700;
      margin-bottom: 12px;
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .card h3 i {
      color: #3b82f6;
    }

    .card textarea {
      width: 100%;
      border: none;
      outline: none;
      background: transparent;
      resize: none;
      font-size: 16px;
      color: #334155;
      min-height: 140px;
    }

    .section-title {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 16px;
    }

    .tool {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-radius: 12px;
      padding: 14px;
      margin-bottom: 12px;
      cursor: pointer;
      background: #fff;
    }

    .tool .info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .tool-icon {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }

    /* Canva */
    .tool.canva {
      border: 1.5px solid #bfdbfe;
    }
    .tool.canva .tool-icon {
      background: #dbeafe;
      color: #1d4ed8;
    }

    /* Pitch */
    .tool.pitch {
      border: 1.5px solid #e9d5ff;
    }
    .tool.pitch .tool-icon {
      background: #f3e8ff;
      color: #7c3aed;
    }

    .tool-text h4 {
      font-size: 16px;
      font-weight: 600;
    }

    .tool-text span {
      font-size: 14px;
      color: #64748b;
    }

    .tool-arrow {
      color: #94a3b8;
      font-size: 16px;
    }

    .add-btn {
      width: 100%;
      background: #475569;
      color: #fff;
      border: none;
      border-radius: 14px;
      padding: 16px;
      font-size: 20px;
      margin-top: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .add-btn i {
      font-size: 22px;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Topo -->
    <div class="header">
      <div class="back-btn">
        <i class="fas fa-arrow-left"></i>
      </div>
      <div class="logo">
        <div class="logo-placeholder">NE</div>
      </div>
    </div>

    <!-- Título + status -->
    <div class="status">
      <h2 contenteditable="true">Projeto 1</h2>
      <span class="tag">Em andamento</span>
    </div>

    <!-- Data -->
    <div class="date">
      <i class="far fa-calendar"></i>
      <span>Criado 10 de Agosto</span>
    </div>

    <!-- Card Descrição -->
    <div class="card">
      <h3><i class="fas fa-align-left"></i> Descrição</h3>
      <textarea placeholder="Digite a descrição do projeto...">dsadsadsan niks dasjoda dsadsada
dsajdoiasjda dsadas dasdasdasdsa
dsadsadsa dsadsadsadsa ss
dsahodsahod djsoiadjsoai idjsaoijdsao
jdosaijdas dsajodasi doisajoidas diosajoid
diosajoo idsja doisaj jdasoi</textarea>
    </div>

    <!-- Ferramentas -->
    <div>
      <div class="section-title">Ferramentas</div>

      <div class="tool canva">
        <div class="info">
          <div class="tool-icon">
            <i class="fas fa-palette"></i>
          </div>
          <div class="tool-text">
            <h4>Canva</h4>
            <span>Criar designs</span>
          </div>
        </div>
        <div class="tool-arrow">
          <i class="fas fa-chevron-right"></i>
        </div>
      </div>

      <div class="tool pitch">
        <div class="info">
          <div class="tool-icon">
            <i class="fas fa-chalkboard"></i>
          </div>
          <div class="tool-text">
            <h4>Pitch</h4>
            <span>Apresentações</span>
          </div>
        </div>
        <div class="tool-arrow">
          <i class="fas fa-chevron-right"></i>
        </div>
      </div>
    </div>

    <!-- Botão adicionar -->
    <button class="add-btn">
      <i class="fas fa-plus"></i>
    </button>
  </div>
</body>
</html>
