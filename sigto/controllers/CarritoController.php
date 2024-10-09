<?php
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Elige.php';
require_once __DIR__ . '/../models/Crea.php';

class CarritoController {

    // Método para agregar un producto al carrito
    public function addItem($idus, $sku, $cantidad) {
        $carrito = new Carrito();
        $elige = new Elige(); // Instancia para manejar la tabla 'elige'
        $crea = new Crea(); // Instancia para manejar la tabla 'crea'
        
        $carrito->setIdus($idus);
        $carrito->setSku($sku);
        $carrito->setCantidad($cantidad);
        
        // Verificar si el producto ya fue elegido por el usuario
        if (!$elige->isProductChosen($idus, $sku)) {
            // Si no ha sido elegido, lo agregamos a 'elige'
            if (!$elige->add($idus, $sku)) {
                return "Error al agregar el producto a la tabla 'elige'.";
            }
        }
    
        // Obtener o crear un idcarrito para el usuario
        $idcarrito = $carrito->getIdCarritoByUser($idus);
        if (!$idcarrito) {
            // Si no tiene un carrito, crear uno nuevo
            $idcarrito = $carrito->createCart($idus);
            if (!$idcarrito) {
                return "Error al crear un nuevo carrito.";
            }
        }
    
        // Verificar si el producto ya está en el carrito
        if ($carrito->itemExists($idcarrito, $sku)) {
            // Si ya está, actualizar la cantidad sumando la nueva
            $cantidadExistente = $carrito->getCantidad($idcarrito, $sku);
            $nuevaCantidad = $cantidadExistente + $cantidad;
            if (!$carrito->updateQuantity($idcarrito, $sku, $nuevaCantidad)) {
                return "Error al actualizar la cantidad del producto en el carrito.";
            }
        } else {
            // Si no está, agregarlo a la tabla 'crea' y 'carrito'
            if (!$crea->add($sku, $idcarrito)) {
                return "Error al agregar el producto a la tabla 'crea'.";
            }
            if (!$carrito->addItemToCart($idcarrito, $sku, $cantidad)) {
                return "Error al agregar el producto al carrito.";
            }
        }
    
        return "Producto agregado correctamente al carrito.";
    }
    // Método para obtener todos los productos del carrito de un usuario
    public function getItemsByUser($idus) {
        $carrito = new Carrito();
        return $carrito->getItemsByUser($idus);
    }

    // Método para actualizar la cantidad de un producto en el carrito
    public function updateQuantity($idus, $sku, $cantidad) {
        $carrito = new Carrito();
        $carrito->setIdus($idus);
        $carrito->setSku($sku);
        
        // Obtener el idcarrito del usuario
        $idcarrito = $carrito->getIdCarritoByUser($idus);
        
        return $carrito->updateQuantity($idcarrito, $sku, $cantidad);
    }

    // Método para eliminar un producto del carrito
    public function removeItem($idus, $sku) {
        $carrito = new Carrito();
        $crea = new Crea(); // Instancia para manejar la tabla 'crea'
        
        $carrito->setIdus($idus);
        $carrito->setSku($sku);
        
        // Obtener el idcarrito del usuario
        $idcarrito = $carrito->getIdCarritoByUser($idus);
        
        // Eliminar la relación del producto con el carrito en 'crea'
        $crea->remove($sku, $idcarrito);
        
        // Eliminar el producto del carrito
        return $carrito->removeItem($idcarrito, $sku);
    }
}
?>
