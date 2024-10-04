<?php
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/OfertaController.php'; // Controlador de ofertas

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y procesar el formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado']; // Estado ya será un radio button
    $origen = $_POST['origen']; // Origen ya será un radio button
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Oferta
    $oferta = $_POST['oferta'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];

    // Manejo de la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = '';
    if ($imagen['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $imagen['tmp_name'];
        $nombreImagen = basename($imagen['name']);
        $rutaDestino = __DIR__ . '/../assets/images/' . $nombreImagen;

        // Verificar el tamaño de la imagen
        if ($imagen['size'] > 2000000) { // 2MB límite
            die("La imagen es demasiado grande. El tamaño máximo permitido es 2MB.");
        }

        // Mover la imagen a la carpeta de destino
        if (!move_uploaded_file($tmp_name, $rutaDestino)) {
            die("Error al subir la imagen.");
        }
    } else {
        die("Error en la subida de la imagen.");
    }

    // Crear el producto
    $productoController = new ProductoController();
    $dataProducto = [
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'estado' => $estado,
        'origen' => $origen,
        'precio' => $precio,
        'stock' => $stock,
        'imagen' => $nombreImagen
    ];

    // Crear el producto y obtener el SKU generado
    $resultadoProducto = $productoController->create($dataProducto);

    if (isset($resultadoProducto['status']) && $resultadoProducto['status'] === 'success') {
        $skuGenerado = $resultadoProducto['sku']; // Captura el SKU generado
    } else {
        die("Error al crear el producto: " . $resultadoProducto['message']);
    }

    // Si se especifica una oferta, creamos la oferta
    if ($oferta > 0) {
        // Calculamos el precio con oferta (precio - porcentaje de descuento)
        $precioOferta = $precio - ($precio * ($oferta / 100));

        // Creamos la oferta
        $ofertaController = new OfertaController();
        $dataOferta = [
            'sku' => $skuGenerado, // Usamos el SKU del producto creado
            'porcentaje_oferta' => $oferta,
            'precio_oferta' => $precioOferta,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ];

        $resultadoOferta = $ofertaController->create($dataOferta);

        if ($resultadoOferta['status'] !== 'success') {
            die("Error al crear la oferta: " . $resultadoOferta['message']);
        }
    }

    echo "Producto y oferta creados con éxito."; // Mensaje de resultado
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="/sigto/assets/css/login.css">
</head>
<body>
    <form action="agregarproducto.php" method="post" enctype="multipart/form-data">
        <h1>Agregar Producto</h1>

        <!-- Datos del Producto -->
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="estado">Estado:</label>
        <div>
            <input type="radio" id="nuevo" name="estado" value="Nuevo" required>
            <label for="nuevo">Nuevo</label>
            
            <input type="radio" id="usado" name="estado" value="Usado" required>
            <label for="usado">Usado</label>
        </div>

        <label for="origen">Origen:</label>
        <div>
            <input type="radio" id="nacional" name="origen" value="Nacional" required>
            <label for="nacional">Nacional</label>

            <input type="radio" id="internacional" name="origen" value="Internacional" required>
            <label for="internacional">Internacional</label>
        </div>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">

        <!-- Datos de la Oferta -->
        <h2>Datos de la Oferta</h2>

        <label for="oferta">Oferta (Descuento en %):</label>
        <input type="number" id="oferta" name="oferta" min="0" max="100" step="1" placeholder="Ej: 10 para 10%" value="0">

        <label for="fecha_inicio">Fecha de inicio de la oferta:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio">

        <label for="fecha_fin">Fecha de fin de la oferta:</label>
        <input type="date" id="fecha_fin" name="fecha_fin">

        <input type="submit" value="Agregar Producto">
        <a href="/sigto/views/mainempresa.php">Volver al Inicio</a>
    </form>
</body>
</html>
