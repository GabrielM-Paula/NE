<?php
require_once '../includes/auth_check.php';
require_once '../includes/db_connection.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['projectName']);
    $descricao = trim($_POST['projectDescription']);
    $modo = $_POST['projectMode'];
    
    if (empty($nome) || empty($descricao) || empty($modo)) {
        $error = "Todos os campos são obrigatórios.";
    } else {
        try {
            $pdo->beginTransaction();
            
            // Inserir a ideia/projeto
            $stmt = $pdo->prepare("INSERT INTO Ideia (id_usuario, nome, descricao, data_criacao, progresso, modo_desenvolvimento) VALUES (?, ?, ?, CURDATE(), 'em_progresso', ?)");
            $stmt->execute([$user_id, $nome, $descricao, $modo]);
            
            $id_ideia = $pdo->lastInsertId();
            
            // Se for modo guiado, adicionar tarefas padrão
            if ($modo === 'guiado') {
                $tarefas_guiadas = [
                    "Definir objetivo principal",
                    "Identificar público-alvo",
                    "Criar esboço inicial",
                    "Desenvolver protótipo",
                    "Testar e validar"
                ];
                
                foreach ($tarefas_guiadas as $tarefa) {
                    $stmt = $pdo->prepare("INSERT INTO Tarefa (id_ideia, descricao, data_criacao) VALUES (?, ?, CURDATE())");
                    $stmt->execute([$id_ideia, $tarefa]);
                }
                
                // Adicionar ferramentas padrão para modo guiado
                $ferramentas_guiadas = [1, 2]; // IDs do Canvas e Pitch
                
                foreach ($ferramentas_guiadas as $id_ferramenta) {
                    $stmt = $pdo->prepare("INSERT INTO Ideia_Ferramenta (id_ideia, id_ferramenta) VALUES (?, ?)");
                    $stmt->execute([$id_ideia, $id_ferramenta]);
                }
            }
            
            $pdo->commit();
            
            // Redirecionar para a página do projeto
            header("Location: projeto.php?id=" . $id_ideia);
            exit();
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erro ao criar projeto: " . $e->getMessage();
        }
    }
}

$page_title = "Criar Novo Projeto";
require_once '../includes/header.php';
?>

<div class="form-container">
  <h1>Criar Novo Projeto</h1>
  
  <?php if (!empty($error)): ?>
    <div class="error"><?php echo $error; ?></div>
  <?php endif; ?>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
      <label for="projectName">Nome do Projeto</label>
      <input type="text" id="projectName" name="projectName" required placeholder="Digite o nome do projeto">
    </div>
    
    <div class="form-group">
      <label for="projectDescription">Descrição</label>
      <textarea id="projectDescription" name="projectDescription" required placeholder="Descreva seu projeto..."></textarea>
    </div>
    
    <div class="form-group">
      <label for="projectMode">Modo de Desenvolvimento</label>
      <select id="projectMode" name="projectMode" required>
        <option value="">Selecione o modo</option>
        <option value="guiado">Desenvolvimento Guiado (com tarefas e ferramentas)</option>
        <option value="livre">Desenvolvimento Livre (personalizável)</option>
      </select>
    </div>
    
    <div class="form-actions">
      <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
      <button type="submit" class="btn btn-primary">Criar Projeto</button>
    </div>
  </form>
</div>

<?php require_once '../includes/footer.php'; ?>