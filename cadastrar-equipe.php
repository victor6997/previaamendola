<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
require '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $cargo = $_POST["cargo"];
    $descricao = $_POST["descricao"];

    // Upload da imagem
    $imagem = null;
    if ($_FILES["imagem"]["error"] == 0) {
        $pasta = "../uploads/";
        $nomeImagem = uniqid() . "_" . $_FILES["imagem"]["name"];
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $pasta . $nomeImagem);
        $imagem = "uploads/" . $nomeImagem;
    }

    $sql = "INSERT INTO equipe (nome, cargo, descricao, imagem) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $cargo, $descricao, $imagem);
    $stmt->execute();

    echo "<p>Funcionário cadastrado com sucesso!</p>";
}
?>

<form method="POST" enctype="multipart/form-data">
    <h2>Cadastrar Funcionário</h2>
    <input type="text" name="nome" placeholder="Nome" required><br>
    <input type="text" name="cargo" placeholder="Cargo" required><br>
    <textarea name="descricao" placeholder="Descrição" required></textarea><br>
    <input type="file" name="imagem" accept="image/*"><br>
    <button type="submit">Salvar</button>
</form>
