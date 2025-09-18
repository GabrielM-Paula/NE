<?php
session_start();
require_once '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_ideia = $_POST['id_ideia'];
    $id_ferramenta = $_POST['id_ferramenta'];

    $stmt = $pdo->prepare("INSERT IGNORE INTO Ideia_Ferramenta (id_ideia, id_ferramenta) VALUES (?, ?)");
    $stmt->execute([$id_ideia, $id_ferramenta]);

    header("Location: projeto.php?id=$id_ideia");
    exit();
}
