<?php
require 'db.php';


$sql = "SELECT * FROM pacientes";
$result = $conn->query($sql);
$pacientes = [];

if ($result->num_rows > 0) {
    // Armazena os dados dos pacientes em um array
    while ($row = $result->fetch_assoc()) {
        $pacientes[] = $row;
    }
} else {
    echo "Nenhum paciente encontrado.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Pacientes Cadastrados</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Sexo</th>
                <th class="actions">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pacientes)): ?>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td><?= $paciente['id'] ?></td>
                        <td><?= $paciente['nome'] ?></td>
                        <td><?= date("d/m/Y", strtotime($paciente['data_nascimento'])) ?></td>
                        <td><?= $paciente['email'] ?></td>
                        <td><?= $paciente['telefone'] ?></td>
                        <td><?= $paciente['endereco'] ?></td>
                        <td><?= ucfirst($paciente['sexo']) ?></td>
                        <td class="actions">
                            <a href="editar_paciente.php?id=<?= $paciente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deletar_paciente.php?id=<?= $paciente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este paciente?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Nenhum paciente cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
