<?php
$host = "127.0.0.1:3306";
$user = "root"; 
$password = "cimatec"; 
$dbname = "clinica"; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
