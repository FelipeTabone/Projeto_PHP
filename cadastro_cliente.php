<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Lógica para deslogar
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Funções de validação e exibição de mensagens
        function capitalizeWords(input) {
            input.value = input.value.replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
        }

        function showSuccessMessage(name) {
            Swal.fire({
                icon: 'success',
                title: 'Cliente cadastrado com sucesso!',
                text: 'Nome: ' + name,
                confirmButtonText: 'OK'
            });
        }

        function showErrorMessage(message) {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: message,
                confirmButtonText: 'OK'
            });
        }

        function isValidCpf(cpf) {
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length !== 11) return false;

            let soma = 0;
            let resto;

            for (let i = 1; i <= 9; i++) {
                soma += parseInt(cpf.charAt(i - 1)) * (11 - i);
            }
            resto = (soma * 10) % 11;
            if (resto === 10 || resto === 11) resto = 0;
            if (resto !== parseInt(cpf.charAt(9))) return false;

            soma = 0;
            for (let i = 1; i <= 10; i++) {
                soma += parseInt(cpf.charAt(i - 1)) * (12 - i);
            }
            resto = (soma * 10) % 11;
            if (resto === 10 || resto === 11) resto = 0;
            return resto === parseInt(cpf.charAt(10));
        }

        function isValidCnpj(cnpj) {
            cnpj = cnpj.replace(/\D/g, '');
            if (cnpj.length !== 14) return false;

            let soma = 0;
            let peso = 5;

            for (let i = 0; i < 12; i++) {
                soma += parseInt(cnpj.charAt(i)) * peso;
                peso = peso === 2 ? 9 : peso - 1;
            }

            let resto = soma % 11;
            let digito1 = resto < 2 ? 0 : 11 - resto;

            if (digito1 !== parseInt(cnpj.charAt(12))) return false;

            soma = 0;
            peso = 6;
            for (let i = 0; i < 13; i++) {
                soma += parseInt(cnpj.charAt(i)) * peso;
                peso = peso === 2 ? 9 : peso - 1;
            }

            resto = soma % 11;
            let digito2 = resto < 2 ? 0 : 11 - resto;

            return digito2 === parseInt(cnpj.charAt(13));
        }

        function validateForm() {
            const cpfCnpj = document.getElementById('cpf').value;
            if (!isValidCpf(cpfCnpj) && !isValidCnpj(cpfCnpj)) {
                showErrorMessage('CPF ou CNPJ inválido.');
                return false;
            }
            return true;
        }
    </script>
    <style>
        body {
            background-color: #343a40; /* Cor de fundo escura */
            color: #ffffff; /* Cor do texto */
        }

        footer {
            text-align: center;
            margin-top: 20px;
        }

        .card {
            background-color: #495057; /* Fundo do card */
            border: none; /* Remove a borda do card */
        }

        .form-control {
            background-color: #6c757d; /* Fundo dos inputs */
            color: #ffffff; /* Cor do texto dos inputs */
            border: 1px solid #ced4da; /* Borda dos inputs */
        }

        .form-control::placeholder {
            color: #ffffff; /* Cor do placeholder */
        }

        .btn-success {
            background-color: #28a745; /* Cor do botão de cadastrar */
            border: none; /* Remove a borda do botão */
        }

        .btn-success:hover {
            background-color: #218838; /* Cor do botão ao passar o mouse */
        }

        .btn-secondary {
            background-color: #6c757d; /* Cor do botão de retornar */
            border: none; /* Remove a borda do botão */
        }

        .btn-secondary:hover {
            background-color: #5a6268; /* Cor do botão ao passar o mouse */
        }
    </style>
</head>
<body class="bg-dark text-white">
<header class="container mt-4">
    <nav class="navbar navbar-expand-lg navbar-dark"> <!-- Adicionada a navbar -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Tela inicial</a>
                </li>
                <li class="nav-item">
                    <a class="navbar-brand" href="#">Cadastrar Cliente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listar_clientes.php">Lista de Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cadastro_produto.php">Cadastrar Produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lista_produto.php">Lista de Produtos</a>
                </li>
            </ul>
            <div class="user-info ml-auto">
                <span class="mr-3">Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <form method="POST" action="" style="display: inline;">
                    <button type="submit" name="logout" class="btn btn-danger">Deslogar</button>
                </form>
            </div>
        </div>
    </nav>
    </header>

    <main class="container mt-4">
    <div class="card bg-dark text-white mx-auto" style="max-width: 400px;">
        <div class="card-body">
        <form method="POST" action="">
                    <div class="form-group">
                        <label for="cpf">CPF ou CNPJ:</label>
                        <input type="text" id="cpf" name="cpf" class="form-control bg-secondary text-white" placeholder="Digite CPF ou CNPJ do cliente" required>
                    </div>

                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control bg-secondary text-white" placeholder="Digite Nome e Sobrenome" required onblur="capitalizeWords(this)">
                    </div>

                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input type="text" id="celular" name="celular" class="form-control bg-secondary text-white" placeholder="Digite o celular com DDD" required>
                    </div>

                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $cpf = htmlspecialchars($_POST['cpf']);
                    $nome = htmlspecialchars($_POST['nome']);
                    $celular = htmlspecialchars($_POST['celular']);
                    
                    // Nome do arquivo CSV
                    $filename = 'clientes.csv'; 
                    $cpfExists = false;

                    // Verifica se o CPF/CNPJ já existe no arquivo
                    if (file_exists($filename) && is_readable($filename)) {
                        if (($handle = fopen($filename, 'r')) !== false) {
                            while (($data = fgetcsv($handle)) !== false) {
                                if ($data[0] === $cpf) {
                                    $cpfExists = true;
                                    break;
                                }
                            }
                            fclose($handle);
                        }
                    }

                    if ($cpfExists) {
                        // Chama a função de erro do SweetAlert
                        echo "<script>showErrorMessage('CPF/CNPJ já cadastrado.');</script>";
                    } else {
                        // Abre o arquivo em modo append
                        $file = fopen($filename, 'a');
                        // Adiciona os dados como uma nova linha no CSV
                        fputcsv($file, [$cpf, $nome, $celular]);
                        fclose($file);

                        // Chama a função de sucesso do SweetAlert
                        echo "<script>showSuccessMessage('$nome');</script>";
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Felipe Andrade Tabone</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
