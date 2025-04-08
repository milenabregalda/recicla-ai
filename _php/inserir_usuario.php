<?php
require_once 'Conexao.php';
require_once 'Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    if ($senha !== $confirmarSenha) {
        echo "<script>alert('As senhas não coincidem. Tente novamente.');
            window.location.href = '../_public/index.html';
            </script>";
        exit;
    }

    try {
        $conn = Conexao::getConexao();
        $usuario = new Usuario($conn);

        // Verificar se o e-mail já está cadastrado
        $verifica = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
        $verifica->execute([$email]);
        
        if ($verifica->rowCount() > 0) {
            echo "<script>alert('E-mail já cadastrado! Tente novamente com outro.');
                window.location.href = '../_public/index.html';
                </script>";
        } else {
            $inserido = $usuario->inserir($nome, $email, $senha);
            if ($inserido) {
                echo "<script>
                        alert('Cadastro feito com sucesso! Entre na sua conta.');
                        window.location.href = '../_public/entrar.html';
                    </script>";
            } else {
                echo "<script>alert('Erro ao cadastrar usuário!');
                    window.location.href = '../_public/index.html';
                    </script>";
            }
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "');
            window.location.href = '../_public/index.html';
            </script>";
    }
}
