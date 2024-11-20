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

// Define o caminho do arquivo CSV
$csvFile = 'estoque.csv';

// Verifica se o arquivo CSV existe
if (!file_exists($csvFile) || !is_readable($csvFile)) {
    die('Arquivo CSV não encontrado ou não é legível.');
}

// Lê o arquivo CSV
$produtos = [];
if (($handle = fopen($csvFile, 'r')) !== false) {
    fgetcsv($handle); // Ignora o cabeçalho
    while (($data = fgetcsv($handle)) !== false) {
        $produtos[] = [
            'id' => $data[0],
            'nome' => $data[1],
            'quantidade' => $data[2],
            'valor_compra' => $data[3],
        ];
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Disponíveis</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Seu CSS existente -->
</head>
<body class="bg-dark text-white">
    <header class="container mt-4">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Tela inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro_cliente.php">Cadastrar Cliente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_clientes.php">Lista de Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro_produto.php">Cadastrar Produto</a>
                    </li>
                    <a class="navbar-brand" href="#">Lista de Produtos</a>
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
        <div class="card bg-dark text-white shadow">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor de Aluguel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produto['id']); ?></td>
                        <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                        <td><?php echo htmlspecialchars($produto['quantidade']); ?></td>
                        <td>R$ <?php echo htmlspecialchars($produto['valor_compra']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer class="text-center mt-4">
        <p>&copy; 2024 Felipe Andrade Tabone</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
