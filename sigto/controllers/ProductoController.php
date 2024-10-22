<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../controllers/OfertaController.php';
require_once __DIR__ . '/../controllers/CategoriaController.php'; 

class ProductoController {

    public function create($data) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'empresa' || !isset($_SESSION['idemp'])) {
            return "Acceso denegado. Solo las empresas pueden agregar productos.";
        }

        $producto = new Producto();
        $producto->setIdEmp($_SESSION['idemp']);
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setEstado($data['estado']);
        $producto->setOrigen($data['origen']);
        $producto->setPrecio($data['precio']);
        $producto->setImagen($data['imagen']);

        // Verificar el tipo de stock y asignar el tipo correcto
        if ($data['tipo_stock'] === 'cantidad') {
            $producto->setTipoStock('cantidad');
            $producto->setStock($data['stock']);  // Establecer el stock si es por cantidad
        } elseif ($data['tipo_stock'] === 'unidad') {
            $producto->setTipoStock('unidad');
            $producto->setStock(null);  // No necesita stock en la tabla principal si es por unidad
        } else {
            return ['status' => 'error', 'message' => 'Tipo de stock inválido.'];
        }

        $skuGenerado = $producto->create();

        // Si es por unidad, insertar los códigos únicos en la tabla 'producto_unitario'
        if ($skuGenerado && $data['tipo_stock'] === 'unidad' && !empty($data['codigos_unitarios'])) {
            $codigos = explode(',', $data['codigos_unitarios']);
            $codigosRepetidos = [];

            foreach ($codigos as $codigoUnidad) {
                $codigoUnidad = trim($codigoUnidad);  // Eliminar espacios en blanco

                // Verificar si el código ya existe
                if ($producto->existeCodigoUnidad($codigoUnidad)) {
                    $codigosRepetidos[] = $codigoUnidad;
                } else {
                    $producto->agregarUnidad($skuGenerado, $codigoUnidad);  // Agregar si no existe
                }
            }

            // Si hay códigos repetidos, retornamos un mensaje de error
            if (!empty($codigosRepetidos)) {
                return ['status' => 'error', 'message' => 'Los siguientes códigos ya existen: ' . implode(', ', $codigosRepetidos)];
            }
        }

        return $skuGenerado ? ['status' => 'success', 'sku' => $skuGenerado] : ['status' => 'error', 'message' => 'Error al crear el producto.'];
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

    // Verificar el tipo de stock y actuar en consecuencia
    if ($data['tipo_stock'] === 'cantidad') {
        // Si es por cantidad, actualizar el stock
        $producto->setStock($data['stock']);
    } elseif ($data['tipo_stock'] === 'unidad') {
        // Si es por unidad, manejar los códigos unitarios
        if (!empty($data['codigos_unitarios'])) {
            // Separar los códigos ingresados por comas y eliminamos espacios en blanco
            $codigos = array_map('trim', explode(',', $data['codigos_unitarios']));
            $codigosRepetidos = [];

            foreach ($codigos as $codigoUnidad) {
                // Verificar si el código ya existe
                if ($producto->existeCodigoUnidad($codigoUnidad)) {
                    $codigosRepetidos[] = $codigoUnidad; // Guardamos los códigos repetidos para mostrar al usuario
                } else {
                    // Si no existe, agregar la unidad
                    $producto->agregarUnidad($data['sku'], $codigoUnidad);
                }
            }

            // Si hay códigos repetidos, retornamos un mensaje de error
            if (!empty($codigosRepetidos)) {
                return ['status' => 'error', 'message' => 'Los siguientes códigos ya existen: ' . implode(', ', $codigosRepetidos)];
            }
        }
    } else {
        return ['status' => 'error', 'message' => 'Tipo de stock inválido.'];
    }

    // Manejar la oferta (sin cambios)
    $ofertaController = new OfertaController();
    $ofertaActual = $ofertaController->readBySku($data['sku']); // Verificar si ya existe una oferta

    if (isset($data['oferta']) && $data['oferta'] > 0) {
        $precioOferta = $data['precio'] - ($data['precio'] * ($data['oferta'] / 100));

        // Si no se proporcionan fechas nuevas, usar las fechas actuales
        if (!empty($ofertaActual)) {
            $fechaInicio = !empty($data['fecha_inicio']) ? $data['fecha_inicio'] : $ofertaActual['fecha_inicio'];
            $fechaFin = !empty($data['fecha_fin']) ? $data['fecha_fin'] : $ofertaActual['fecha_fin'];
        } else {
            // Si no hay una oferta previa, es necesario proporcionar fechas nuevas
            $fechaInicio = !empty($data['fecha_inicio']) ? $data['fecha_inicio'] : null;
            $fechaFin = !empty($data['fecha_fin']) ? $data['fecha_fin'] : null;
        }

        // Validar que las fechas sean correctas (si no hay fechas, se mostrará un error)
        if ($fechaInicio && $fechaFin && $fechaInicio <= $fechaFin) {
            $dataOferta = [
                'sku' => $data['sku'],
                'porcentaje_oferta' => $data['oferta'],
                'preciooferta' => $precioOferta,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin
            ];

            // Actualizar o crear la oferta dependiendo de si ya existe
            if ($ofertaActual) {
                $ofertaController->update($dataOferta); // Actualizar la oferta existente
            } else {
                $ofertaController->create($dataOferta); // Crear una nueva oferta si no existe
            }
        } else {
            return "Error: Fechas de oferta inválidas o incompletas.";
        }
    } else {
        // Si solo se está actualizando el porcentaje de la oferta, recalcular el precio de oferta
        if ($ofertaActual) {
            $precioOferta = $data['precio'] - ($data['precio'] * ($ofertaActual['porcentaje_oferta'] / 100));
            $dataOferta = [
                'sku' => $data['sku'],
                'porcentaje_oferta' => $ofertaActual['porcentaje_oferta'],
                'preciooferta' => $precioOferta,
                'fecha_inicio' => $ofertaActual['fecha_inicio'], // Mantener fechas anteriores
                'fecha_fin' => $ofertaActual['fecha_fin'] // Mantener fechas anteriores
            ];
            $ofertaController->update($dataOferta); // Actualizar solo el precio de la oferta
        }
    }

    // Actualizar el producto
    if ($producto->update()) {
        return "Producto actualizado exitosamente.";
    } else {
        return "Error al actualizar producto.";
    }
}

    
    
    // Método para obtener la cantidad de productos disponibles por SKU
    public function getCantidadDisponiblePorSku($sku) {
        $producto = new Producto();
        return $producto->getCantidadDisponiblePorSku($sku); // Usar el método del modelo para obtener cantidad disponible
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
        $producto = new Producto('write');
        $producto->setSku($sku);
        if ($producto->softDelete()) {
            return "Producto ocultado exitosamente.";
        } else {
            return "Error al ocultar el producto.";
        }
    }
    
    // Método para restaurar el producto
    public function restore($sku) {
        $producto = new Producto('write');
        $producto->setSku($sku);
        if ($producto->restore()) {
            return "Producto restaurado exitosamente.";
        } else {
            return "Error al restaurar el producto.";
        }
    }

    public function handleRequest() {
        if (isset($_GET['action']) && isset($_GET['sku'])) {
            $action = $_GET['action'];
            $sku = $_GET['sku'];
    
            if ($action === 'desactivar') {
                return $this->softDelete($sku);
            } elseif ($action === 'activar') {
                return $this->restore($sku);
            }
        }
    }
    
    public function searchByName($term) {
        $producto = new Producto();
        return $producto->searchByName($term);
    }
    
}
?>
