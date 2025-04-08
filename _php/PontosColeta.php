<?php
require_once 'Conexao.php';

class PontosColeta {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    public function inserir($nome, $endereco, $cidade, $estado, $capacidade_total, $capacidade_disponivel, $horario, $contato, $id_admin) {
        $sql = "INSERT INTO pontos_coleta (nome, endereco, cidade, estado, capacidade_total, capacidade_disponivel, horario_funcionamento, contato, id_admin)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $endereco, $cidade, $estado, $capacidade_total, $capacidade_disponivel, $horario, $contato, $id_admin]);
    }

    public function listar() {
        $sql = "SELECT * FROM pontos_coleta";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editar($id, $nome, $endereco, $cidade, $estado, $capacidade_total, $capacidade_disponivel, $horario, $contato) {
        $sql = "UPDATE pontos_coleta SET nome = ?, endereco = ?, cidade = ?, estado = ?, capacidade_total = ?, capacidade_disponivel = ?, horario_funcionamento = ?, contato = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $endereco, $cidade, $estado, $capacidade_total, $capacidade_disponivel, $horario, $contato, $id]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM pontos_coleta WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
