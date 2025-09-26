<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit("unauthorized");
}

require_once '../includes/db_connection.php';

$id_usuario = $_SESSION['user_id'];
$id_ideia = $_POST['id'] ?? null;
$nome = $_POST['nome'] ?? null;
$descricao = $_POST['descricao'] ?? null;

if (!$id_ideia || !$nome || !$descricao) {
    exit("invalid");
}

// Atualiza a ideia
$sql = "UPDATE Ideia 
        SET nome = ?, descricao = ?
        WHERE id_ideia = ? AND id_usuario = ?";
$stmt = $pdo->prepare($sql);
$ok = $stmt->execute([$nome, $descricao, $id_ideia, $id_usuario]);

// Limpar qualquer saída anterior e retornar apenas "ok" ou "error"
ob_clean();
echo $ok ? "ok" : "error";
exit;

