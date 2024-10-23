<?php
require 'db.php';

$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$sexo = $_POST['sexo'];


if (empty($nome) || empty($email) || empty($telefone) || empty($data_nascimento)) {
    echo "Por favor, preencha todos os campos obrigatórios.";
    exit;
}


$data_nascimento_obj = new DateTime($data_nascimento);
$hoje = new DateTime();
$idade = $hoje->diff($data_nascimento_obj)->y;

if ($idade < 18) {
    echo "O paciente deve ser maior de idade.";
    exit;
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
