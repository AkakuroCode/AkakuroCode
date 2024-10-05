<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../controllers/OfertaController.php';
require_once __DIR__ . '/../controllers/CategoriaController.php'; 

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

    public function asignarCategoria($sku, $idcat) {
        $producto = new Producto(); // Instanciar el modelo de Producto
        return $producto->asignarCategoria($sku, $idcat); // Llamar al método del modelo
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

    // Función para actualizar el producto
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
    
        // Verificar si se ha subido una nueva imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Procesar la nueva imagen
            $tmp_name = $_FILES['imagen']['tmp_name'];
            $nombreImagen = basename($_FILES['imagen']['name']);
            $rutaDestino = __DIR__ . '/../assets/images/' . $nombreImagen;

            // Mover la nueva imagen a la carpeta de destino
            if (move_uploaded_file($tmp_name, $rutaDestino)) {
                // Establecer la nueva imagen en el producto
                $producto->setImagen($nombreImagen);
            } else {
                return "Error al subir la nueva imagen.";
            }
        } else {
            // Mantener la imagen actual si no se ha subido una nueva
            $producto->setImagen($data['imagenActual']);
        }

        // Solo eliminar y asignar nueva categoría si se selecciona una nueva
        if (isset($data['categoria']) && $data['categoria'] !== "") {
            $producto->eliminarCategoria($data['sku']); // Elimina la categoría anterior del producto
            $producto->asignarCategoria($data['sku'], $data['categoria']); // Asigna la nueva categoría
        }

        // Validar y actualizar la oferta
        $ofertaController = new OfertaController();
        if (isset($data['oferta']) && $data['oferta'] > 0) {
            $fechaInicio = !empty($data['fecha_inicio']) ? $data['fecha_inicio'] : $data['fecha_inicio_actual'];
            $fechaFin = !empty($data['fecha_fin']) ? $data['fecha_fin'] : $data['fecha_fin_actual'];

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
        } else {
            // Si no se cambia el porcentaje de oferta, recalcular el precio de oferta en función del nuevo precio
            $ofertaActual = $ofertaController->readBySku($data['sku']);
            if ($ofertaActual) {
                $precioOferta = $data['precio'] - ($data['precio'] * ($ofertaActual['porcentaje_oferta'] / 100));
                $dataOferta = [
                    'sku' => $data['sku'],
                    'porcentaje_oferta' => $ofertaActual['porcentaje_oferta'],
                    'preciooferta' => $precioOferta,
                    'fecha_inicio' => $ofertaActual['fecha_inicio'],
                    'fecha_fin' => $ofertaActual['fecha_fin']
                ];
                $ofertaController->update($dataOferta); // Actualizamos la oferta con el nuevo precio
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
