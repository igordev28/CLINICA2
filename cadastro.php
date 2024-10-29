<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nomeCompleto'];
    $data_nascimento = $_POST['dataNascimento'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $sexo = $_POST['sexo'];

    if (empty($nome) || empty($email) || empty($telefone) || empty($data_nascimento)) {
        $_SESSION['mensagem'] = "Por favor, preencha todos os campos obrigatórios.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $data_nascimento_obj = new DateTime($data_nascimento);
    $hoje = new DateTime();
    $idade = $hoje->diff($data_nascimento_obj)->y;

    if ($idade < 18) {
        $_SESSION['mensagem'] = "O paciente deve ser maior de idade.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $sql = "INSERT INTO pacientes (nome, data_nascimento, email, telefone, endereco, sexo) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['mensagem'] = "Erro na preparação da consulta: " . $conn->error;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $stmt->bind_param("ssssss", $nome, $data_nascimento, $email, $telefone, $endereco, $sexo);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
