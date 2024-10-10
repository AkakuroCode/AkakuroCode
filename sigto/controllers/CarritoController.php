<?php
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Usuario.php';// Para manejar el modelo de productos si es necesario

class CarritoController {
    // Método para agregar un producto al carrito
    public function addItem($idus, $sku, $cantidad) {
        $carrito = new Carrito();
        $carrito->setIdus($idus);
        $carrito->setSku($sku);
        $carrito->setCantidad($cantidad);
    
        // Verificar si el producto ya está en el carrito para actualizar la cantidad
        $itemExistente = $carrito->getItemByUserAndSku();
        if ($itemExistente) {
            // Si el producto ya está en el carrito, sumamos la nueva cantidad a la existente
            $nuevaCantidad = $itemExistente['cantidad'] + $cantidad;
            return $carrito->updateQuantity($idus, $sku, $nuevaCantidad);
        } else {
            // Obtener el precio del producto, considerando ofertas
            $producto = new Producto();
            $producto->setSku($sku);
            $productoData = $producto->readOne();
    
            $precioProducto = $productoData['precio'];
            if (isset($productoData['preciooferta']) && $productoData['preciooferta'] > 0) {
                $precioProducto = $productoData['preciooferta'];
            }
    
            // Establecer el total del producto (cantidad * precio unitario)
            $carrito->setTotal($precioProducto * $cantidad);
    
            // Si no está en el carrito, agregarlo
            return $carrito->addItem();
        }
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
        $carrito->setCantidad($cantidad);
        return $carrito->updateQuantity($idus, $sku, $cantidad);
    }

    // Método para eliminar un producto del carrito
    public function removeItem($idus, $sku) {
        $carrito = new Carrito();
        $carrito->setIdus($idus);
        $carrito->setSku($sku);
        return $carrito->removeItem($idus, $sku);
    }

    // Método para obtener el total del carrito de un usuario
    public function getTotalByUser($idus) {
        $items = $this->getItemsByUser($idus);
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item['subtotal']; // Sumar los subtotales de cada producto (ya calculados con oferta si aplica)
        }
        
        return $total;
    }
}
?>
