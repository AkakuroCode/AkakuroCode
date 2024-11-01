<?php
require_once __DIR__ . '/../config/Database.php';

class Vehiculo {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    // Método para obtener vehículos disponibles
    public function obtenerVehiculosDisponibles() {
        $sql = "SELECT idv, capacidad, modelo, tipo, marca FROM vehiculo WHERE estado = 'disponible'";
        $result = $this->conn->query($sql);

        $vehiculos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $vehiculos[] = $row;
            }
        }
        return $vehiculos;
    }
}
