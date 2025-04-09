<?php
require_once 'Conexao.php';
require_once 'Usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $nomeCompleto = $usuario['nome'];
    $emailUsuario = $usuario['email'];

    $conexao = Conexao::getConexao();
    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && hash_equals($usuario['senha'], hash('sha256', $senha))) {
        $_SESSION['usuario_id'] = $usuario['id'];
        if ($usuario['tipo_usuario'] === 'admin') {
            header("Location: ../_php/pagina_admin.php");
        } else {
            header("Location: ../_public/sessao.php");
        }
        exit();
    } else {
        echo "<script>
                alert('E-mail ou senha inválido. Tente novamente ou cadastre-se.');
                window.location.href = '../_public/entrar.html';
              </script>";
    }
}
