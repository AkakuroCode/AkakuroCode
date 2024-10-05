<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../controllers/OfertaController.php'; // Asegurarnos de incluir el modelo Oferta

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
    
        // Manejar la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];
            $tmp_name = $imagen['tmp_name'];
            $nombreImagen = basename($imagen['name']);
            $rutaDestino = __DIR__ . '/../assets/images/' . $nombreImagen;

            // Verificar el tamaño de la imagen
            if ($imagen['size'] > 2000000) {
                return "La imagen es demasiado grande. El tamaño máximo permitido es 2MB.";
            }

            // Mover la imagen a la carpeta de destino
            if (!move_uploaded_file($tmp_name, $rutaDestino)) {
                return "Error al subir la imagen.";
            }

            // Establecer la nueva imagen en el producto
            $producto->setImagen($nombreImagen);
        } else {
            // Mantener la imagen actual si no se sube una nueva
            $producto->setImagen($data['imagenActual']);
        }
    
        // Validar y actualizar la oferta
        $ofertaController = new OfertaController();
    
        if (isset($data['oferta']) && $data['oferta'] > 0) {
            $fechaInicio = $data['fecha_inicio'];
            $fechaFin = $data['fecha_fin'];
    
            // Validación de fecha
            if ($fechaInicio && $fechaFin && $fechaInicio < $fechaFin) {
                $precioOferta = $data['precio'] - ($data['precio'] * ($data['oferta'] / 100));
                $dataOferta = [
                    'sku' => $data['sku'],
                    'porcentaje_oferta' => $data['oferta'],
                    'preciooferta' => $precioOferta,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin
                ];
                $ofertaController->update($dataOferta); // Actualizamos la oferta
            } else {
                return "Error: La fecha de inicio debe ser anterior a la fecha de fin.";
            }
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
