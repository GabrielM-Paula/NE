<?php
session_start();
require_once '../includes/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];
$id_ideia = $_POST['id'] ?? null;

if (!$id_ideia) {
    die("ID inválido.");
}

// Verifica se o projeto pertence ao usuário
$sql = "DELETE FROM Ideia WHERE id_ideia = ? AND id_usuario = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_ideia, $id_usuario]);

// Redirecionar para a lista depois de excluir
header("Location: meusProjetos.php?deleted=1");
exit();
