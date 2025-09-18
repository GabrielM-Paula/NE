<?php
// Ativar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar a sessão
session_start();

// Verificar se o usuário está logado para redirecionar adequadamente
if (isset($_SESSION['user_id'])) {
    header("Location: pages/meusProjetos.php");
} else {
    header("Location: pages/Home2.php");
}
exit();
?>