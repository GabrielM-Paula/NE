<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

require_once '../includes/db_connection.php'; // mantém seu include
$id_usuario = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza input simples — você pode melhorar as validações
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $modo = ($_POST['modo_desenvolvimento'] === 'livre') ? 'livre' : 'guiado';
    $data = date('Y-m-d');

    if ($nome === '') {
        $erro = "Preencha o nome do projeto.";
    } else {
        // Insere a ideia
        $sql = "INSERT INTO Ideia (id_usuario, nome, descricao, data_criacao, modo_desenvolvimento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario, $nome, $descricao, $data, $modo]);
        $id_ideia = $pdo->lastInsertId();

        // Se guiado, vincula ferramentas padrão (opcional: ajustar lista se quiser subset)
        if ($modo === 'guiado') {
            $pdo->query("INSERT INTO Ideia_Ferramenta (id_ideia, id_ferramenta)
                         SELECT $id_ideia, id_ferramenta FROM Ferramenta");
        }

        header("Location: Descricao.php?id=" . $id_ideia);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Novo Projeto - NE</title>
  <link rel="stylesheet" href="../assets/css/Projetos.css">
  <style>
    .form-box { max-width:520px; margin:20px auto; background:#fff; padding:18px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
    label { font-weight:700; margin-top:8px; display:block; }
    input[type="text"], textarea, select { width:100%; padding:10px; border-radius:8px; border:1px solid #e5e7eb; margin-top:6px; font-size:14px; }
    textarea { min-height:120px; resize:vertical; }
    .error { color:#b91c1c; margin-bottom:10px; }
  </style>
</head>
<body>
  <header class="topo">
    <a href="meusProjetos.php" style="text-decoration:none; color:#111;">←</a>
    <center><img src="../assets/images/neAzul.png" alt="NE" class="logo" style="height:36px;"></center>
    <div></div>
  </header>

  <main class="conteudo">
    <div class="form-box">
      <h2>Novo Projeto</h2>
      <?php if (!empty($erro)): ?><div class="error"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
      <form method="POST" action="novo.php">
        <label for="nome">Nome do Projeto</label>
        <input id="nome" name="nome" type="text" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao"></textarea>

        <label for="modo">Modo de Desenvolvimento</label>
        <select id="modo" name="modo_desenvolvimento" required>
          <option value="guiado">Guiado (tarefas e ferramentas prontas)</option>
          <option value="livre">Livre (adicionar ferramentas manualmente)</option>
        </select>

        <div style="margin-top:12px;">
          <button type="submit" class="btn">Salvar</button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
