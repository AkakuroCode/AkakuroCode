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
        $rutaDestino = __DIR__ . '/../images/' . $nombreImagen;

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
</head>
<body>
    <h1>Agregar Producto</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea><br>

        <label for="oferta">Oferta:</label>
        <input type="text" name="oferta"><br>

        <label for="fecof">Fecha de Oferta:</label>
        <input type="date" name="fecof"><br>

        <label for="estado">Estado:</label>
        <input type="text" name="estado" required><br>

        <label for="origen">Origen:</label>
        <input type="text" name="origen" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" required><br>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" accept="image/*" required><br>

        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>
