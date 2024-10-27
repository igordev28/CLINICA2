<?php
require 'db.php'; // Inclui a conexão com o banco de dados

// Inicializa variáveis para mensagens de erro e valores
$erros = [];
$valores = [
    'nomeCompleto' => '',
    'dataNascimento' => '',
    'email' => '',
    'telefone' => '',
    'endereco' => '',
    'sexo' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e valida os dados do formulário
    $valores['nomeCompleto'] = trim($_POST['nomeCompleto']);
    $valores['dataNascimento'] = $_POST['dataNascimento'];
    $valores['email'] = trim($_POST['email']);
    $valores['telefone'] = trim($_POST['telefone']);
    $valores['endereco'] = trim($_POST['endereco']);
    $valores['sexo'] = $_POST['sexo'];

    if (empty($valores['nomeCompleto'])) {
        $erros['nomeCompleto'] = 'O nome completo é obrigatório.';
    }

    $dataNascimento = new DateTime($valores['dataNascimento']);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNascimento)->y;
    if ($idade < 18) {
        $erros['dataNascimento'] = 'Você deve ser maior de idade para se cadastrar.';
    }

    if (!filter_var($valores['email'], FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = 'Formato de e-mail inválido.';
    }

    if (!preg_match('/^[0-9]{10,11}$/', $valores['telefone'])) {
        $erros['telefone'] = 'O telefone deve conter 10 ou 11 dígitos.';
    }

    if (empty($valores['endereco'])) {
        $erros['endereco'] = 'O endereço é obrigatório.';
    }

    if (empty($valores['sexo'])) {
        $erros['sexo'] = 'Por favor, selecione seu sexo.';
    }

    if (empty($erros)) {
        // Insere os dados no banco de dados
        $stmt = $conn->prepare("INSERT INTO pacientes (nome, data_nascimento, email, telefone, endereco, sexo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $valores['nomeCompleto'], $valores['dataNascimento'], $valores['email'], $valores['telefone'], $valores['endereco'], $valores['sexo']);
        $stmt->execute();

        echo '<div class="alert alert-success">Cadastro realizado com sucesso!</div>';
        $valores = array_fill_keys(array_keys($valores), '');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Formulário de Cadastro</title>
</head>
<body>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-4 d-flex align-items-start"> <!-- Coluna para o formulário à esquerda -->
            <div class="form-container">
                <div class="heading">Cadastro de Paciente</div>
                <form class="form" method="POST" id="registrationForm">
                    <div class="form-group">
                        <input type="text" class="form-control input" name="nomeCompleto" placeholder="Nome Completo" required>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control input" name="dataNascimento" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control input" name="email" placeholder="E-mail" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control input" name="telefone" placeholder="Telefone" required pattern="[0-9]{10,11}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input" name="endereco" placeholder="Endereço" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control input" name="sexo" required>
                            <option value="" disabled selected>Sexo</option>
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    <button type="submit" class="login-button">Cadastrar</button>
                </form>
                <div class="agreement"><a href="#">DOUTOR IGOR SANTOS</a></div>
            </div>
        </div>
        <div class="col-8"> <!-- Coluna para a lista de pacientes no centro -->
            <div class="patient-list">
                <div class="heading">Lista de Pacientes</div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Completo</th>
                            <th>Data de Nascimento</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Endereço</th>
                            <th>Sexo</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
            <?php
            // Consulta para buscar os pacientes cadastrados
            $sql = "SELECT * FROM pacientes";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($paciente = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$paciente['id']}</td>
                            <td>{$paciente['nome']}</td>
                            <td>{$paciente['data_nascimento']}</td>
                            <td>{$paciente['email']}</td>
                            <td>{$paciente['telefone']}</td>
                            <td>{$paciente['endereco']}</td>
                            <td>{$paciente['sexo']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum paciente encontrado.</td></tr>";
            }
            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
