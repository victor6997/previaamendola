<?php
session_start();

// Verifica se o admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel Administrativo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #003366;
      color: white;
      padding: 20px;
      text-align: center;
      position: relative;
    }

    .logout {
      position: absolute;
      right: 20px;
      top: 20px;
      background-color: #cc0000;
      color: white;
      padding: 8px 12px;
      border-radius: 5px;
      text-decoration: none;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      display: flex;
      justify-content: space-around;
      gap: 30px;
      flex-wrap: wrap;
    }

    .card {
      background-color: white;
      padding: 30px;
      width: 300px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .card h2 {
      margin-bottom: 10px;
    }

    .card a {
      display: inline-block;
      margin-top: 15px;
      background-color: #003366;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
    }

    .card a:hover {
      background-color: #0055aa;
    }
  </style>
</head>
<body>

  <header>
    <h1>Painel Administrativo</h1>
    <a href="logout.php" class="logout">Sair</a>
    <p>Bem-vindo, <?php echo $_SESSION['admin']; ?>!</p>
  </header>

  <div class="container">
    <div class="card">
      <h2>Equipe</h2>
      <p>Gerenciar funcionários</p>
      <a href="cadastrar-equipe.php">Cadastrar Funcionário</a>
    </div>

    <div class="card">
      <h2>Clientes</h2>
      <p>Gerenciar clientes</p>
      <a href="cadastrar-cliente.php">Cadastrar Cliente</a>
    </div>
  </div>

</body>
</html>
