<?php
// includes/db_connection.php

// Ativar exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $host = 'localhost';
    $db   = 'ne';
    $user = 'root';
    $pass = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<!-- Conexão bem-sucedida -->";
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>