<?php
require_once __DIR__ . '/../controllers/ProductoController.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y procesar el formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $oferta = $_POST['oferta'];
    $fecof = $_POST['fecof'];
    $estado = $_POST['estado']; // Estado ya será un radio button
    $origen = $_POST['origen']; // Origen ya será un radio button
    $precio = $_POST['precio'];
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
        'precio' => $precio,
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
    <form action="agregarproducto.php" method="post" enctype="multipart/form-data">
    <h1>Agregar Producto</h1>

    <label for="nombre">Nombre del Producto:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" required></textarea>

    <label for="oferta">Oferta (Descuento en %):</label>
    <input type="number" id="oferta" name="oferta" min="0" max="100" step="1" placeholder="Ej: 10 para 10%" value="0">


    <label for="fecof">Fecha de Oferta:</label>
    <input type="date" id="fecof" name="fecof">

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

    <label for="precio">Precio:</label> <!-- Nuevo campo para precio -->
    <input type="number" id="precio" name="precio" step="0.01" required> <!-- Campo de precio -->

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" required>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*">

    <input type="submit" value="Agregar Producto">
</form>

</body>
</html>
