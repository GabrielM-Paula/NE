<?php
session_start();
if (!isset($_SESSION['user_id'])) exit("unauthorized");

require_once '../includes/db_connection.php';

$id_usuario = $_SESSION['user_id'];
$id_ideia = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$id_ideia || !$status) exit("invalid");

$sql = "UPDATE ideia SET progresso = ? WHERE id_ideia = ? AND id_usuario = ?";
$stmt = $pdo->prepare($sql);
$ok = $stmt->execute([$status, $id_ideia, $id_usuario]);

echo $ok ? "ok" : "error";
