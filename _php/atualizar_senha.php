<?php
require_once 'Conexao.php';

class Usuario {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    public function atualizarSenha($email, $novaSenha) {
        $sql = "UPDATE usuario SET senha = SHA2(?, 256) WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$novaSenha, $email]);
    }

    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM usuario WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}

// Lógica de controle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $novaSenha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    if ($novaSenha !== $confirmarSenha) {
        echo "<script>
                alert('As senhas não coincidem! Tente novamente.');
                window.location.href = '../_public/trocar-senha.html';
              </script>";
        exit;
    }

    $conexao = Conexao::getConexao();
    $usuario = new Usuario($conexao);

    if (!$usuario->emailExiste($email)) {
        echo "<script>
                alert('E-mail não encontrado! Tente novamente.');
                window.location.href = '../_public/trocar-senha.html';
              </script>";
        exit;
    }

    if ($usuario->atualizarSenha($email, $novaSenha)) {
        echo "<script>
                alert('Senha atualizada com sucesso! Entre na sua conta.');
                window.location.href = '../_public/entrar.html';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao atualizar a senha! Tente novamente.');
                window.location.href = '../_public/trocar-senha.html';
              </script>";
    }
}
