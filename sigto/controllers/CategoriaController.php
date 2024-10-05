<?php
require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController {

    public function getAllCategorias() {
        $categoria = new Categoria();
        return $categoria->readAll();
    }
}
?>