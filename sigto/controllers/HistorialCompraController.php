<?php
require_once __DIR__ . '/../models/HistorialCompra.php';

class HistorialCompraController {
    private $historialCompraModel;

    public function __construct() {
        $this->historialCompraModel = new HistorialCompra();
    }

    public function obtenerHistorialUsuario() {
        // Verifica si el usuario está logueado
        if (!isset($_SESSION['idus'])) {
            echo "No has iniciado sesión.";
            return [];
        }

        $idus = $_SESSION['idus'];

        // Obtiene el idhistorial asociado al usuario logueado
        $idhistorial = $this->historialCompraModel->obtenerIdHistorialPorUsuario($idus);

        if ($idhistorial) {
            // Obtiene los registros del historial de compras y los retorna
            return $this->historialCompraModel->obtenerRegistrosPorHistorial($idhistorial);
        } else {
            // Retorna un array vacío si no hay historial
            return [];
        }
    }
    
    public function obtenerHistorialPorUsuarioAdmin($idus) {
        // Obtiene el idhistorial asociado al usuario especificado
        $idhistorial = $this->historialCompraModel->obtenerIdHistorialPorUsuario($idus);
    
        if ($idhistorial) {
            // Obtiene los registros del historial de compras y los retorna
            return $this->historialCompraModel->obtenerRegistrosPorHistorial($idhistorial);
        } else {
            // Retorna un array vacío si no hay historial
            return [];
        }
    }
}
