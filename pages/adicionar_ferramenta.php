<?php
require_once '../includes/auth_check.php';
require_once '../includes/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit();
}

if (!isset($_POST['id_ideia']) || !isset($_POST['id_ferramenta'])) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
    exit();
}

$id_ideia = $_POST['id_ideia'];
$id_ferramenta = $_POST['id_ferramenta'];

// Verificar se o usuário é dono da ideia
$stmt = $pdo->prepare("SELECT id_ideia FROM Ideia WHERE id_ideia = ? AND id_usuario = ?");
$stmt->execute([$id_ideia, $user_id]);
$ideia = $stmt->fetch();

if (!$ideia) {
    echo json_encode(['success' => false, 'message' => 'Projeto não encontrado']);
    exit();
}

// Verificar se a ferramenta já foi adicionada
$stmt = $pdo->prepare("SELECT * FROM Ideia_Ferramenta WHERE id_ideia = ? AND id_ferramenta = ?");
$stmt->execute([$id_ideia, $id_ferramenta]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Ferramenta já adicionada']);
    exit();
}

// Adicionar ferramenta
$stmt = $pdo->prepare("INSERT INTO Ideia_Ferramenta (id_ideia, id_ferramenta) VALUES (?, ?)");
if ($stmt->execute([$id_ideia, $id_ferramenta])) {
    echo json_encode(['success' => true, 'message' => 'Ferramenta adicionada com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao adicionar ferramenta']);
}
?>