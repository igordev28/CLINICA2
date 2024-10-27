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
        header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para evitar reenvio de formulário
        exit;
    }

    // Verifica a idade
    $data_nascimento_obj = new DateTime($data_nascimento);
    $hoje = new DateTime();
    $idade = $hoje->diff($data_nascimento_obj)->y;
    
    if ($idade < 18) {
        echo "O paciente deve ser maior de idade.";
        exit;
    }
}
    
    
    $sql = "INSERT INTO pacientes (nome, data_nascimento, email, telefone, endereco, sexo) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $data_nascimento, $email, $telefone, $endereco, $sexo);
    
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
    ?>