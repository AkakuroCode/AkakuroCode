<?php
require_once __DIR__ . '/../controllers/ProductoController.php';
session_start();

// Verificar si el usuario está autenticado como empresa
if (!isset($_SESSION['empresa'])) {
    die("Acceso denegado. Solo las empresas pueden agregar productos.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y procesar el formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $oferta = $_POST['oferta'];
    $fecof = $_POST['fecof'];
    $estado = $_POST['estado'];
    $origen = $_POST['origen'];
    $stock = $_POST['stock'];

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
    $data = [
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'oferta' => $oferta,
        'fecof' => $fecof,
        'estado' => $estado,
        'origen' => $origen,
        'stock' => $stock,
        'imagen' => $nombreImagen
    ];

    $resultado = $productoController->create($data);
    echo $resultado; // Mensaje de resultado
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
    <h1>Agregar Producto</h1>
    <form action="agregarproducto.php" method="post" enctype="multipart/form-data">
    <label for="nombre">Nombre del Producto:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" required></textarea>

    <label for="oferta">Oferta:</label>
    <input type="text" id="oferta" name="oferta">

    <label for="fecof">Fecha de Oferta:</label>
    <input type="date" id="fecof" name="fecof">

    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado">

    <label for="origen">Origen:</label>
    <input type="text" id="origen" name="origen">

    <label for="precio">Precio:</label> <!-- Nuevo campo para precio -->
    <input type="number" id="precio" name="precio" step="0.01" required> <!-- Campo de precio -->

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" required>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen">

    <input type="submit" value="Agregar Producto">
</form>

</body>
</html>
