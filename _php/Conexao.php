<?php

class Conexao {
    private static $host = 'localhost';
    private static $dbname = 'banco_recicla_ai';
    private static $usuario = 'root';
    private static $senha = '';

    public static function getConexao() {
        try {
            $conn = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname.";charset=utf8", self::$usuario, self::$senha);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}
