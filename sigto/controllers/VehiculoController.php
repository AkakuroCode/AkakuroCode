<?php
require_once __DIR__ . '/../models/Vehiculo.php';

class VehiculoController {
    private $vehiculoModel;

    public function __construct() {
        $this->vehiculoModel = new Vehiculo();
    }

    public function obtenerVehiculosDisponibles() {
        return $this->vehiculoModel->obtenerVehiculosDisponibles();
    }
}
