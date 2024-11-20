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
    <title>Cadastro de Produtos</title>
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
                    <a class="navbar-brand" href="#">Cadastrar Produtos</a>
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
                        <label for="id">ID:</label>
                        <input type="text" class="form-control bg-secondary text-white" id="id" name="id" value="<?php echo getNextId(); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome do Produto:</label>
                        <input type="text" class="form-control bg-secondary text-white" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" class="form-control bg-secondary text-white" id="quantidade" name="quantidade" required>
                    </div>
                    <div class="form-group">
                        <label for="valor_compra">Valor de aluguel (R$):</label>
                        <input type="number" step="0.01" class="form-control bg-secondary text-white" id="valor_compra" name="valor_compra" required>
                    </div>
                    <button type="submit" class="btn btn-success">Cadastrar Produto</button>
                </form>

                <?php
                // Função para obter o próximo ID
                function getNextId() {
                    $csvFile = 'estoque.csv';
                    $lastId = 0;

                    // Verifica se o arquivo CSV existe e é legível
                    if (file_exists($csvFile) && is_readable($csvFile)) {
                        if (($handle = fopen($csvFile, 'r')) !== false) {
                            fgetcsv($handle); // Ignora o cabeçalho
                            while (($data = fgetcsv($handle)) !== false) {
                                $lastId = max($lastId, intval($data[0])); // Pega o maior ID
                            }
                            fclose($handle);
                        }
                    }

                    return $lastId + 1; // Retorna o próximo ID
                }

                // Verifica se o formulário foi enviado
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id = htmlspecialchars($_POST['id']);
                    $nome = htmlspecialchars($_POST['nome']);
                    $quantidade = htmlspecialchars($_POST['quantidade']);
                    $valor_compra = htmlspecialchars($_POST['valor_compra']);
                    
                    // Nome do arquivo CSV
                    $csvFile = 'estoque.csv';

                    // Abre o arquivo em modo append
                    $file = fopen($csvFile, 'a');
                    // Adiciona os dados como uma nova linha no CSV
                    fputcsv($file, [$id, $nome, $quantidade, $valor_compra]);
                    fclose($file);

                    echo "<div class='alert alert-success mt-3'>Produto cadastrado com sucesso!</div>";
                }
                ?>
            </div>
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
