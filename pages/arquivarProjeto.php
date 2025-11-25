<?php
session_start();
if (!isset($_SESSION['user_id'])) exit("unauthorized");

require_once '../includes/db_connection.php';

$id_usuario = $_SESSION['user_id'];
$id_ideia = $_POST['id'] ?? null;

if (!$id_ideia) exit("invalid");

$sql = "UPDATE ideia SET arquivado = 1 WHERE id_ideia = ? AND id_usuario = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_ideia, $id_usuario]);

header("Location: meusProjetos.php");
exit();
