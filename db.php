<?php
$host = '127.0.0.1:3306';
$db = 'clinica'; 
$user = 'root'; 
$pass = 'jones'; 
$charset = 'utf8mb4';

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
