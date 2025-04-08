<?php
require_once 'Conexao.php';

class Noticias {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    public function inserir($titulo, $conteudo) {
        $sql = "INSERT INTO noticias (titulo, conteudo) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$titulo, $conteudo]);
    }

    public function listar() {
        $sql = "SELECT * FROM noticias";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editar($id, $titulo, $conteudo) {
        $sql = "UPDATE noticias SET titulo = ?, conteudo = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$titulo, $conteudo, $id]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM noticias WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
