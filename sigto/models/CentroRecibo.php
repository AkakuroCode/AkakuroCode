<?php
require_once __DIR__ . '/../config/Database.php';

class CentroRecibo {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM centrorecibo";
        $result = $this->conn->query($sql);
        $centros = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $centros[] = $row;
            }
        }
        return $centros;
    }
}
