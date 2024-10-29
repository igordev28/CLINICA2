<?php
$host = 'localhost:3306'; 
$user = 'root'; 
$password = 'cimatec'; 
$database = 'clinica2'; 


$conn = new mysqli($host, $user, $password, $database);


if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
