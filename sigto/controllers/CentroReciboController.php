<?php
require_once __DIR__ . '/../models/CentroRecibo.php';

class CentroReciboController {
    private $centroReciboModel;

    public function __construct() {
        $this->centroReciboModel = new CentroRecibo();
    }

    public function obtenerCentrosDeRecibo() {
        return $this->centroReciboModel->obtenerTodos();
    }
}
