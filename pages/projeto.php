<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

require_once '../includes/db_connection.php';

$id_usuario = $_SESSION['user_id'];
$id_ideia = $_GET['id'] ?? null;

if (!$id_ideia) {
    header("Location: meusProjetos.php");
    exit();
}

// Buscar dados do projeto
$sql = "SELECT * FROM Ideia WHERE id_ideia = ? AND id_usuario = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_ideia, $id_usuario]);
$projeto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projeto) {
    echo "Projeto não encontrado!";
    exit();
}

// ---------------- GUIADO ----------------
$tarefas = [];
$concluidas = [];
$ferramentas = [];

if ($projeto['modo_desenvolvimento'] === 'guiado') {
    // Buscar tarefas
    $sql = "SELECT * FROM Tarefa WHERE id_ideia = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_ideia]);
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Separar concluídas
    foreach ($tarefas as $t) {
        if ($t['status'] === 'concluida') {
            $concluidas[] = $t;
        }
    }

    // Buscar ferramentas vinculadas (corrigido: alias não reservado)
    $sql = "SELECT f.*
            FROM Ferramenta f
            JOIN Ideia_Ferramenta i_f ON f.id_ferramenta = i_f.id_ferramenta
            WHERE i_f.id_ideia = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_ideia]);
    $ferramentas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($projeto['nome']) ?> - Projeto</title>
    <link rel="stylesheet" href="../assets/css/Projetos.css">
    <style>
        .card { border:1px solid #ddd; border-radius:10px; padding:14px; margin-bottom:10px; background:#fff; }
        .titulo { font-weight:700; }
        .status { padding:4px 10px; border-radius:6px; font-size:12px; }
        .status.em_progresso { background:#2563EB; color:#fff; }
        .status.concluido { background:#16a34a; color:#fff; }
        .btn { display:inline-block; padding:10px 16px; border-radius:8px; background:#2563EB; color:#fff; font-weight:700; text-decoration:none; margin:8px 0; }
    </style>
</head>
<body>
<header class="topo">
    <a href="meusProjetos.php" style="text-decoration:none;color:#111;">←</a>
    <center><img src="../assets/images/neAzul.png" alt="Logo" class="logo" style="height:36px;"></center>
    <div></div>
</header>

<main class="conteudo">
    <h2><?= htmlspecialchars($projeto['nome']) ?></h2>
    <p><?= htmlspecialchars($projeto['descricao']) ?></p>
    <p><strong>Criado em:</strong> <?= date("d/m/Y", strtotime($projeto['data_criacao'])) ?></p>
    <p><strong>Status:</strong> 
        <span class="status <?= $projeto['progresso'] ?>">
            <?= $projeto['progresso'] === "em_progresso" ? "Em andamento" : "Concluído" ?>
        </span>
    </p>

    <?php if ($projeto['modo_desenvolvimento'] === 'guiado'): ?>
        <h3>Tarefas</h3>
        <?php if ($tarefas): ?>
            <?php foreach ($tarefas as $t): ?>
                <div class="card">
                    <p class="titulo"><?= htmlspecialchars($t['titulo']) ?></p>
                    <p>Status: <?= $t['status'] === 'concluida' ? "✅ Concluída" : "⏳ Em andamento" ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma tarefa cadastrada.</p>
        <?php endif; ?>

        <h3>Ferramentas</h3>
        <?php if ($ferramentas): ?>
            <?php foreach ($ferramentas as $f): ?>
                <div class="card">
                    <p class="titulo"><?= htmlspecialchars($f['nome']) ?></p>
                    <a style="width:30%;"href="ferramenta_<?= strtolower($f['nome']) ?>.php?id=<?= $id_ideia ?>" class="btn">Abrir</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma ferramenta vinculada.</p>
        <?php endif; ?>

    <?php else: ?>
        <h3>Ferramentas</h3>
        <p>Este projeto está em modo livre.</p>
        <a href="projeto_add_ferramenta.php?id=<?= $id_ideia ?>" class="btn">+ Adicionar Ferramenta</a>
    <?php endif; ?>
</main>
</body>
</html>
