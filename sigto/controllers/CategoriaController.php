<?php
require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController {
    
    public function asignarCategoria($sku, $idcat) {
        // Código para asignar la categoría a un producto
        $categoria = new Categoria();
        return $categoria->asignarCategoria($sku, $idcat);
    }
    public function getAllCategorias() {
        $categoria = new Categoria();
        return $categoria->readAll();
    }


}
?>