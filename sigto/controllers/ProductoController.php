<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {

    public function create($data) {
        // Verificar si la sesión está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar que el usuario sea una empresa
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'empresa' || !isset($_SESSION['idemp'])) {
            return "Acceso denegado. Solo las empresas pueden agregar productos.";
        }

        $producto = new Producto();
        $producto->setIdEmp($_SESSION['idemp']);
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setEstado($data['estado']);
        $producto->setOrigen($data['origen']);
        $producto->setStock($data['stock']);
        $producto->setPrecio($data['precio']);
        $producto->setImagen($data['imagen']);

          // Intentar crear el producto
        $skuGenerado = $producto->create();

        if ($skuGenerado) {
            return ['status' => 'success', 'sku' => $skuGenerado];
        } else {
            return ['status' => 'error', 'message' => 'Error al crear el producto.'];
        }
    }

    public function readAll() {
        $producto = new Producto();
        $result = $producto->readAllProducts(); // Llamamos al método del modelo que recupera todos los productos
    
        if (!$result) {
            return false;
        }
    
        return $result;
    }

    public function readAllByEmpresa($idemp) {
        $producto = new Producto();
        $result = $producto->readByEmpresa($idemp);
    
        if (!$result) {
            return false; // Manejo de errores si no se obtienen productos
        }
    
        return $result;
    }

    public function readOne($sku) {
        $producto = new Producto();
        $producto->setSku($sku);
        return $producto->readOne();
    }

    public function update($data) {
        $producto = new Producto();
        $producto->setSku($data['sku']);
        $producto->setIdEmp($_SESSION['idemp']);
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setEstado($data['estado']);
        $producto->setOrigen($data['origen']);
        $producto->setStock($data['stock']);
        $producto->setPrecio($data['precio']);

        // Actualizar imagen si se proporciona
        if (isset($data['imagen']) && $data['imagen'] !== null) {
            $producto->setImagen($data['imagen']);
        }

        if ($producto->update()) {
            return "Producto actualizado exitosamente.";
        } else {
            return "Error al actualizar producto.";
        }
    }

    public function delete($sku) {
        $producto = new Producto();
        $producto->setSku($sku);
        if ($producto->delete()) {
            return "Producto eliminado exitosamente.";
        } else {
            return "Error al eliminar producto.";
        }
    }
}
?>
