<?php
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';

class CarritoController {
    private $carrito;
    private $producto;

    public function __construct() {
        $this->carrito = new Carrito();
        $this->producto = new Producto();
    }

    // Método para obtener los productos del carrito de un usuario
    public function getItemsByUser($idus) {
        return $this->carrito->getItemsByUser($idus);
    }

    public function addItem($idus, $sku, $cantidad) {
        // Obtener el idcarrito activo
        $idcarrito = $this->carrito->getActiveCartIdByUser($idus);
    
        if (!$idcarrito) {
            // Si no existe, crea un nuevo carrito para el usuario
            $idcarrito = $this->carrito->createCart($idus);
        }
    
        if ($idcarrito) {
            // Verificar si el producto ya está en el carrito
            $itemExistente = $this->carrito->getItemByUserAndSku($idus, $sku);
    
            if ($itemExistente) {
                $nuevaCantidad = $itemExistente['cantidad'] + $cantidad;
                $this->carrito->updateQuantity($idcarrito, $sku, $nuevaCantidad);
            } else {
                $this->carrito->addItem($idcarrito, $sku, $cantidad);
            }
    
            // Recalcular el total del carrito después de agregar un producto
            $this->carrito->recalcularTotalCarrito($idcarrito);
            
            return true;
        } else {
            echo "Error al crear el carrito.";
            return false;
        }
    }
    

    public function getTotalByUser($idus) {
        return $this->carrito->getTotalByUser($idus);
    }
    public function getActiveCartIdByUser($idus) {
    return $this->carrito->getActiveCartIdByUser($idus);
}


public function updateQuantity($idus, $sku, $cantidad) {
    $idcarrito = $this->carrito->getActiveCartIdByUser($idus); // Asegúrate de que esto obtenga el idcarrito correctamente.
    $result = $this->carrito->updateQuantity($idcarrito, $sku, $cantidad);
    
    if ($result) {
        // Calcula el subtotal y el total del carrito
        $subtotal = $this->calcularSubtotal($idus, $sku);
        $totalCarrito = $this->carrito->recalcularTotalCarrito($idcarrito);
        
        return ['status' => 'success', 'subtotal' => $subtotal, 'totalCarrito' => $totalCarrito];
    } else {
        return ['status' => 'error', 'message' => 'No se pudo actualizar la cantidad.'];
    }
}


public function calcularSubtotal($idus, $sku) {
    // Llama al método correspondiente en el modelo Carrito para obtener el subtotal
    return $this->carrito->getSubtotalByUserAndSku($idus, $sku);
}

public function removeItem($idus, $sku) {
    $idcarrito = $this->carrito->getActiveCartIdByUser($idus);
    $result = $this->carrito->removeItem($idcarrito, $sku);

    if ($result) {
        // Recalcular el total después de eliminar el producto
        $this->carrito->recalcularTotalCarrito($idcarrito);
    }

    return $result;
}

public function removeAllItems($idcarrito) {
    $resultado = $this->carrito->removeAllItems($idcarrito);

    if (!$resultado) {
        echo "Error al eliminar los productos del carrito.";
        return false;
    }

    // Recalcular el total del carrito después de eliminar los productos
    $this->carrito->recalcularTotalCarrito($idcarrito);

    return true;
}


public function obtenerIdCarrito($idus) {
    $idCarrito = $this->carrito->obtenerIdCarrito($idus);

    if (!$idCarrito) {
        echo "No se pudo obtener el ID del carrito.";
        return null;
    }

    return $idCarrito;
}

}
