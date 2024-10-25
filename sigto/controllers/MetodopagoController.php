<?php
require_once __DIR__ . '/../models/MetodoPago.php';

class MetodoDePagoController {
    private $metodoPagoModel;

    public function __construct() {
        // Crear una conexión y pasarla al modelo
        $database = new Database();
        $this->metodoPagoModel = new MetodoPago($database->getConnection());
    }

    public function obtenerMetodosDePagoActivos() {
        return $this->metodoPagoModel->obtenerMetodosActivos();
    }
}