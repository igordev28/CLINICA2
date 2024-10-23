<?php
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

    // Valida Nome Completo
    if (empty($valores['nomeCompleto'])) {
        $erros['nomeCompleto'] = 'O nome completo é obrigatório.';
    }

    // Valida Data de Nascimento
    $dataNascimento = new DateTime($valores['dataNascimento']);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNascimento)->y;

    if ($idade < 18) {
        $erros['dataNascimento'] = 'Você deve ser maior de idade para se cadastrar.';
    }

    // Valida E-mail
    if (!filter_var($valores['email'], FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = 'Formato de e-mail inválido.';
    }

    // Valida Telefone
    if (!preg_match('/^[0-9]{10,11}$/', $valores['telefone'])) {
        $erros['telefone'] = 'O telefone deve conter 10 ou 11 dígitos.';
    }

    // Valida Endereço
    if (empty($valores['endereco'])) {
        $erros['endereco'] = 'O endereço é obrigatório.';
    }

    // Valida Sexo
    if (empty($valores['sexo'])) {
        $erros['sexo'] = 'Por favor, selecione seu sexo.';
    }

    // Se não houver erros, processa os dados (armazenamento, envio, etc.)
    if (empty($erros)) {
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
    <title>Formulário de Cadastro</title>
    <style>
        /* Estilização atualizada */
       
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="heading">Cadastro de Paciente</div>
        <form class="form" method="POST" id="registrationForm">
            <div class="form-group">
                <input type="text" class="form-control input" name="nomeCompleto" placeholder="Nome Completo" value="<?php echo htmlspecialchars($valores['nomeCompleto']); ?>" required>
                <?php if (isset($erros['nomeCompleto'])): ?>
                    <small class="text-danger"><?php echo $erros['nomeCompleto']; ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="date" class="form-control input" name="dataNascimento" placeholder="Data de Nascimento" value="<?php echo htmlspecialchars($valores['dataNascimento']); ?>" required>
                <?php if (isset($erros['dataNascimento'])): ?>
                    <small class="text-danger"><?php echo $erros['dataNascimento']; ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="email" class="form-control input" name="email" placeholder="E-mail" value="<?php echo htmlspecialchars($valores['email']); ?>" required>
                <?php if (isset($erros['email'])): ?>
                    <small class="text-danger"><?php echo $erros['email']; ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="tel" class="form-control input" name="telefone" placeholder="Telefone" value="<?php echo htmlspecialchars($valores['telefone']); ?>" required pattern="[0-9]{10,11}">
                <?php if (isset($erros['telefone'])): ?>
                    <small class="text-danger"><?php echo $erros['telefone']; ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="text" class="form-control input" name="endereco" placeholder="Endereço" value="<?php echo htmlspecialchars($valores['endereco']); ?>" required>
                <?php if (isset($erros['endereco'])): ?>
                    <small class="text-danger"><?php echo $erros['endereco']; ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <select class="form-control input" name="sexo" required>
                    <option value="" disabled selected>Sexo</option>
                    <option value="masculino" <?php echo $valores['sexo'] === 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                    <option value="feminino" <?php echo $valores['sexo'] === 'feminino' ? 'selected' : ''; ?>>Feminino</option>
                    <option value="outro" <?php echo $valores['sexo'] === 'outro' ? 'selected' : ''; ?>>Outro</option>
                </select>
                <?php if (isset($erros['sexo'])): ?>
                    <small class="text-danger"><?php echo $erros['sexo']; ?></small>
                <?php endif; ?>
            </div>
            <button type="submit" class="login-button">Cadastrar</button>
        </form>
        <div class="agreement"><a href="#">Aprenda sobre o acordo de licença do usuário</a></div>
    </div>
</body>
</html>
