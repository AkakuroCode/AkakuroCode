<?php
require_once __DIR__ . '/../models/Elige.php';

class EligeController {

    // Método para agregar un producto como elegido por un usuario
    public function addProductToChosen($idus, $sku) {
        $elige = new Elige();

        // Verificar si el producto ya está elegido por el usuario
        if (!$elige->isProductChosen($idus, $sku)) {
            // Si no está elegido, agregarlo
            return $elige->add($idus, $sku);
        }

        return false; // Si ya estaba elegido, no se hace nada
    }

    // Método para eliminar un producto de los elegidos por un usuario
    public function removeProductFromChosen($idus, $sku) {
        $elige = new Elige();
        return $elige->remove($idus, $sku);
    }
}
?>
