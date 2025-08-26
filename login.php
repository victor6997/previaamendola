<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($senha, $usuario["senha"])) {
            $_SESSION["usuario"] = $usuario["nome"];
            header("Location: dashboard.php");
            exit;
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>

<form method="POST">
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Entrar</button>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
</form>
