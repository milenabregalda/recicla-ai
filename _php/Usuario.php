<?php
require_once 'Conexao.php';

class Usuario {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    public function inserir($nome, $email, $senha, $tipo_usuario = 'comum') {
        $sql = "INSERT INTO usuario (nome, email, senha, tipo_usuario, data_cadastro)
                VALUES (?, ?, SHA2(?, 256), ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $email, $senha, $tipo_usuario]);
    }

    public function listar() {
        $sql = "SELECT * FROM usuario";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editar($id, $nome, $email, $tipo_usuario) {
        $sql = "UPDATE usuario SET nome = ?, email = ?, tipo_usuario = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $email, $tipo_usuario, $id]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
