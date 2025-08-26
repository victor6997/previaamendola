<?php
// dashboard.php

// Exemplo básico de proteção simples - sessão iniciada
session_start();

// Verifica se o usuário está logado, por enquanto vamos simular
// Substitua essa verificação conforme seu sistema real
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redireciona para a página de login (crie depois)
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Painel Administrativo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #222;
            color: #eee;
            margin: 0; padding: 20px;
        }
        header {
            background: #444;
            padding: 10px 20px;
            margin-bottom: 20px;
        }
        nav a {
            color: #0af;
            text-decoration: none;
            margin-right: 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            background: #333;
            padding: 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Administrativo</h1>
    <nav>
        <a href="dashboard.php">Home</a>
        <a href="../index.php">Site</a>
        <a href="logout.php">Sair</a>
    </nav>
</header>

<main>
    <h2>Bem-vindo, administrador!</h2>
    <p>Aqui você pode gerenciar o conteúdo do seu site.</p>

    <!-- Você pode adicionar links para outras funções administrativas aqui -->
</main>

</body>
</html>
