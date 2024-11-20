<?php
session_start();

// Usuário e senha fictícios para validação
$usuarioValido = "admin";
$senhaValida = "senha123"; // Use uma senha mais segura em produção

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Verifica as credenciais
    if ($username === $usuarioValido && $password === $senhaValida) {
        // Se o login for bem-sucedido, armazena na sessão e redireciona
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username; // Armazena o nome de usuário na sessão
        header("Location: index.php"); // Redireciona para a tela inicial
        exit;
    } else {
        echo "<script>alert('Usuário ou senha inválidos.'); window.history.back();</script>";
    }
}
?>
