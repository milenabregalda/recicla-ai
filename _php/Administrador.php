<?php
require_once 'Conexao.php';

class Administrador {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    public function inserir($permissoes, $id_usuario) {
        $sql = "INSERT INTO administrador (permissoes, data_admissao, id_usuario)
                VALUES (?, NOW(), ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$permissoes, $id_usuario]);
    }

    public function listar() {
        $sql = "SELECT * FROM administrador";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editar($id, $permissoes) {
        $sql = "UPDATE administrador SET permissoes = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$permissoes, $id]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM administrador WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}

