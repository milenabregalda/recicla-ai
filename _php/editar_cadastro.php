<?php
require_once('../_php/dados_sessao.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$con = Conexao::getConexao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Atualizar
    if (isset($_POST['atualizar'])) {
        $senhaHash = $senhaHash = hash('sha256', $senha);
        $stmt = $con->prepare("UPDATE usuario SET nome = :nome, email = :email, senha = :senha WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../_public/sessao.php");
        exit();
    }

    // Excluir
    if (isset($_POST['excluir'])) {
        $stmt = $con->prepare("DELETE FROM usuario WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
        $stmt->execute();
        session_destroy();
        header("Location: ../_public/entrar.html");
        exit();
    }

    // Sair da conta
    if (isset($_POST['sairDaConta'])) {
        session_destroy();
        header("Location: ../_public/entrar.html");
        exit();
    }
}
