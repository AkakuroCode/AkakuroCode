<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Utils.php'; // Incluye el archivo Utils.php
require_once __DIR__ . '/../models/Empresa.php';

class ProductoController {

    public function create($data) {
          // Inicia la sesión solo si no está activa
          if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        var_dump($_SESSION); // Esto mostrará todos los valores actuales almacenados en la sesión
        // También podrías agregar die() si quieres que se detenga la ejecución en este punto para ver la salida
        die();
        // Verifica si el usuario está autenticado como empresa
        if (!isset($_SESSION['empresa']) || !isset($_SESSION['idemp'])) {
            return "Acceso denegado. Solo las empresas pueden agregar productos.";
        }
    
        $producto = new Producto();
        $producto->setIdEmp($_SESSION['idemp']);
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setFecof($data['fecof']);
        $producto->setEstado($data['estado']);
        $producto->setOrigen($data['origen']);
        $producto->setPrecio($data['precio']);
        $producto->setStock($data['stock']);
    
        // Si se ha especificado una oferta, calcula el precio con descuento
        $oferta = isset($data['oferta']) ? (float)$data['oferta'] : 0;
        if ($oferta > 0) {
            $precioConDescuento = $data['precio'] - ($data['precio'] * ($oferta / 100));
            $producto->setPrecio($precioConDescuento);
        } else {
            $producto->setPrecio($data['precio']);
        }
        
        $producto->setOferta($oferta); // Guardamos el porcentaje de la oferta
        $producto->setImagen($data['imagen']);
    
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
        $producto->setIdEmp($_SESSION['idemp']); // Asegurarte de que el idemp se toma de la sesión
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setFecof($data['fecof']);
        $producto->setEstado($data['estado']);
        $producto->setOrigen($data['origen']);
        $producto->setStock($data['stock']);
        
        // Si se ha especificado una oferta, calcula el precio con descuento
        $oferta = isset($data['oferta']) ? (float)$data['oferta'] : 0;
        if ($oferta > 0) {
            $precioConDescuento = $data['precio'] - ($data['precio'] * ($oferta / 100));
            $producto->setPrecio($precioConDescuento);
        } else {
            $producto->setPrecio($data['precio']); // Si no hay oferta, el precio se queda igual
        }
    
        $producto->setOferta($oferta); // Guardamos el porcentaje de la oferta
    
        // Verificar si se proporciona una nueva imagen
        if (isset($data['imagen']) && $data['imagen'] !== null) {
            $producto->setImagen($data['imagen']);
        } else {
            $producto->setImagen(null); // Si no se sube una nueva imagen, puede quedarse en blanco o dejar la anterior
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
