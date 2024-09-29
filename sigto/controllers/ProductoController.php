<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Utils.php'; // Incluye el archivo Utils.php

class ProductoController {

    public function create($data) {
        // Verificar si el usuario está autenticado como empresa
        session_start();
        if (!isset($_SESSION['empresa'])) {
            return "Acceso denegado. Solo las empresas pueden agregar productos.";
        }

        $producto = new Producto();
        $producto->setIdEmp($_SESSION['empresa_id']); // Asegúrate de almacenar el ID de la empresa en la sesión al iniciar sesión
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setOferta($data['oferta']);
        $producto->setFecof($data['fecof']);
        $producto->setEstado($data['estado']);
        $producto->setOrigen($data['origen']);
        $producto->setStock($data['stock']);
        $producto->setImagen($data['imagen']); // Asegúrate de que el nombre de la imagen se haya establecido correctamente

        if ($producto->create()) {
            return "Producto creado exitosamente.";
        } else {
            return "Error al crear producto.";
        }
    }

    public function readAll() {
        $producto = new Producto();
        $result = $producto->readAll();

        if (!$result) {
            return "No se pudieron obtener los productos.";
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
        $producto->setIdEmp($data['idemp']);
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setOferta($data['oferta']);
        $producto->setFecof($data['fecof']);
        $producto->setEstado($data['estado']);
        $producto->setOrigen($data['origen']);
        $producto->setStock($data['stock']);
        $producto->setImagen($data['imagen']); // Asegúrate de que el nombre de la imagen se haya establecido correctamente

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