<?php
require_once __DIR__ . '/../models/Crea.php';

class CreaController {

    // Método para agregar un producto a un carrito
    public function addProductToCart($sku, $idcarrito) {
        $crea = new Crea();

        // Verificar si el producto ya está en el carrito
        if (!$crea->isProductInCart($sku, $idcarrito)) {
            // Si no está en el carrito, agregarlo
            return $crea->add($sku, $idcarrito);
        }

        return false; // Si ya estaba en el carrito, no se hace nada
    }

    // Método para eliminar un producto del carrito
    public function removeProductFromCart($sku, $idcarrito) {
        $crea = new Crea();
        return $crea->remove($sku, $idcarrito);
    }
}
?>
