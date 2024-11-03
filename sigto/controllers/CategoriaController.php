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

    public function addCategoria($nombre, $descripcion) {
        $categoria = new Categoria();
        return $categoria->create($nombre, $descripcion);
    }

    public function updateCategoria($id, $nombre, $descripcion) {
        $categoria = new Categoria('write'); // Usar 'write' para operaciones de escritura
        return $categoria->update($id, $nombre, $descripcion);
    }

    public function deleteCategoria($id) {
        $categoria = new Categoria('write'); // Usar 'write' para operaciones de escritura
        return $categoria->delete($id);
    }
    
}
?>