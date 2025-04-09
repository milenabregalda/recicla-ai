<?php
require_once 'Conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../_public/entrar.html");
    exit();
}

try {
    $con = Conexao::getConexao();

    $stmt = $con->prepare("SELECT * FROM usuario WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $nomeCompleto = $usuario['nome'];
        $emailUsuario = $usuario['email'];
    } else {
        echo "<script>alert('Usuário não encontrado.');</script>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
