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
    <title>Lista de Clientes</title>
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
                    <a class="navbar-brand" href="#">Lista de Clientes</a>
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
                <?php
                $csvFile = 'clientes.csv';

                // Função para formatar CPF e CNPJ
                function formatarCpfCnpj($documento) {
                    $documento = preg_replace('/\D/', '', $documento); // Remove caracteres não numéricos
                    
                    if (strlen($documento) === 11) {
                        // CPF
                        return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $documento);
                    } elseif (strlen($documento) === 14) {
                        // CNPJ
                        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $documento);
                    }
                    return $documento; // Retorna sem formatação se não for CPF nem CNPJ
                }

                // Função para formatar o celular
                function formatarCelular($celular) {
                    $celular = preg_replace('/\D/', '', $celular); // Remove caracteres não numéricos
                    
                    if (strlen($celular) === 11) {
                        // Formato (XX) XXXXX-XXXX
                        return preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $celular);
                    } elseif (strlen($celular) === 10) {
                        // Se o celular estiver no formato 4899619517, assume DDD 48
                        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '($1) $2-$3', $celular);
                    }
                    return $celular; // Retorna sem formatação se não tiver 10 ou 11 dígitos
                }

                // Verifica se o arquivo CSV existe
                if (!file_exists($csvFile) || !is_readable($csvFile)) {
                    echo "<p>Nenhum cliente cadastrado.</p>";
                } else {
                    $clientes = [];
                    if (($handle = fopen($csvFile, 'r')) !== false) {
                        // Lê todo o arquivo, incluindo o cabeçalho
                        while (($data = fgetcsv($handle)) !== false) {
                            $clientes[] = [
                                'cpf' => $data[0],
                                'nome' => $data[1],
                                'celular' => $data[2],
                            ];
                        }
                        fclose($handle);
                    }

                    if (count($clientes) > 0) {
                        echo "<table class='table table-striped table-dark'>";
                        echo "<thead><tr><th>CPF/CNPJ</th><th>Nome</th><th>Celular</th></tr></thead><tbody>";

                        // Exibe cada cliente em uma nova linha da tabela
                        foreach ($clientes as $cliente) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars(formatarCpfCnpj($cliente['cpf'])) . "</td>";
                            echo "<td>" . htmlspecialchars($cliente['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars(formatarCelular($cliente['celular'])) . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "<p>Nenhum cliente cadastrado.</p>";
                    }
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
