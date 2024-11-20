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
    <title>Tela Inicial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Seu CSS existente -->
</head>
<body class="bg-dark text-white">
    <header class="container mt-4">
        <nav class="navbar navbar-expand-lg navbar-dark "> <!-- Alterado para bg-dark -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <a class="navbar-brand" href="#">Tela inicial</a>
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
        <div class="card bg-dark text-white shadow">
            <div class="card-body text-center">
                <h2>Selecione uma opção:</h2>
                <div class="d-flex flex-column align-items-center">
                    <a href="cadastro_cliente.php" class="btn btn-success mb-2">Cadastrar Cliente</a>
                    <a href="listar_clientes.php" class="btn btn-success mb-2">Lista de Clientes</a>
                    <a href="cadastro_produto.php" class="btn btn-success mb-2">Cadastrar Produto</a> <!-- Botão para cadastrar produto -->
                    <a href="lista_produto.php" class="btn btn-success mb-2">Lista de Produtos</a>
                </div>
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
