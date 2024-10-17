<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Carrito.php';
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

    public function readVisible() {
        $producto = new Producto();
        return $producto->readVisibleProducts(); // Llama a un método en el modelo
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
    
        // Manejar la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['imagen']['tmp_name'];
            $nombreImagen = basename($_FILES['imagen']['name']);
            $rutaDestino = __DIR__ . '/../assets/images/' . $nombreImagen;
            if (move_uploaded_file($tmp_name, $rutaDestino)) {
                $producto->setImagen($nombreImagen);
            } else {
                return "Error al subir la nueva imagen.";
            }
        } else {
            $producto->setImagen($data['imagenActual']);
        }
    
        // Manejar la categoría
        if (isset($data['categoria']) && $data['categoria'] !== "") {
            $producto->eliminarCategoria($data['sku']);
            $producto->asignarCategoria($data['sku'], $data['categoria']);
        }
    
        // Manejar la oferta
        $ofertaController = new OfertaController();
        $ofertaActual = $ofertaController->readBySku($data['sku']); // Verifica si ya existe una oferta
    
        // Si hay una oferta existente o se proporciona una nueva oferta
        if (isset($data['oferta']) && $data['oferta'] > 0) {
            $precioOferta = $data['precio'] - ($data['precio'] * ($data['oferta'] / 100));
            
            // Verificar si hay fechas nuevas o usar las fechas existentes
            $fechaInicio = !empty($data['fecha_inicio']) ? $data['fecha_inicio'] : $data['fecha_inicio_actual'];
            $fechaFin = !empty($data['fecha_fin']) ? $data['fecha_fin'] : $data['fecha_fin_actual'];
    
            // Si ya existe una oferta, actualizamos
            if ($ofertaActual && isset($ofertaActual['porcentaje_oferta'])) {
                $dataOferta = [
                    'sku' => $data['sku'],
                    'porcentaje_oferta' => $data['oferta'],
                    'preciooferta' => $precioOferta,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin
                ];
                $ofertaController->update($dataOferta);
            } else {
                // Si no existe una oferta, creamos una nueva
                $dataOferta = [
                    'sku' => $data['sku'],
                    'porcentaje_oferta' => $data['oferta'],
                    'preciooferta' => $precioOferta,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin
                ];
                $ofertaController->create($dataOferta);
            }
        }
    
        // Actualizar el producto
        if ($producto->update()) {
            return "Producto actualizado exitosamente.";
        } else {
            return "Error al actualizar producto.";
        }
    }
    
    public function addToCart($idus, $sku, $cantidad) {
        $carrito = new Carrito();
        $carrito->setIdus($idus);
        $carrito->setSku($sku);
        $carrito->setCantidad($cantidad);

        // Verificar si el producto ya está en el carrito del usuario
        $itemExistente = $carrito->getItemByUserAndSku();

        if ($itemExistente) {
            // Si el producto ya está en el carrito, actualizar la cantidad sumando la nueva
            $nuevaCantidad = $itemExistente['cantidad'] + $cantidad;
            return $carrito->updateQuantity($idus, $sku, $nuevaCantidad);

        } else {
            // Si el producto no está en el carrito, añadirlo como un nuevo ítem
            return $carrito->addItem();
        }
    }  

    // Método para el borrado lógico (ocultar producto)
    public function softDelete($sku) {
        $producto = new Producto();
        $producto->setSku($sku);
        if ($producto->softDelete()) {
            return "Producto ocultado exitosamente.";
        } else {
            return "Error al ocultar el producto.";
        }
    }
    
    // Método para restaurar el producto
    public function restore($sku) {
        $producto = new Producto();
        $producto->setSku($sku);
        if ($producto->restore()) {
            return "Producto restaurado exitosamente.";
        } else {
            return "Error al restaurar el producto.";
        }
    }
}
?>
