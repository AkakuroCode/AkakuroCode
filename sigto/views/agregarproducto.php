<?php
require_once __DIR__ . '/../controllers/CategoriaController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/OfertaController.php';

$categoriaController = new CategoriaController();
$categorias = $categoriaController->getAllCategorias();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y procesar el formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $origen = $_POST['origen'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $idcat = $_POST['idcat']; // El ID de la categoría seleccionada

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
        if ($imagen['size'] > 2000000) {
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
        $skuGenerado = $resultadoProducto['sku'];

        // Asignar el producto a la categoría seleccionada en la tabla 'pertenece'
        $productoController->asignarCategoria($skuGenerado, $idcat);
    } else {
        die("Error al crear el producto: " . $resultadoProducto['message']);
    }

    // Crear la oferta si existe
    if ($oferta > 0) {
        $precioOferta = $precio - ($precio * ($oferta / 100));
        $ofertaController = new OfertaController();
        $dataOferta = [
            'sku' => $skuGenerado,
            'porcentaje_oferta' => $oferta,
            'preciooferta' => $precioOferta,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ];

        $resultadoOferta = $ofertaController->create($dataOferta);
        if (!$resultadoOferta) {
            die("Error al crear la oferta.");
        }
    }

    echo "Producto y oferta creados con éxito.";
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
        <select name="estado" id="estado" required>
            <option value="">Estado del producto</option>
            <option value="nuevo">Nuevo</option>
            <option value="usado">Usado</option>
        </select>

        <label for="origen">Origen:</label>
        <select name="origen" id="origen" required>
            <option value="">Origen del producto</option>
            <option value="nacional">Nacional</option>
            <option value="internacional">Internacional</option>
        </select>

        <label for="categoria">Categoría:</label>
        <select name="idcat" id="categoria" required>
            <option value="">Seleccionar categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo $categoria['idcat']; ?>"><?php echo $categoria['nombre']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">

        <!-- Datos de la Oferta -->
        <h2>Datos de la Oferta</h2>

        <label for="oferta">Oferta (Descuento en %):</label>
        <input type="number" id="oferta" name="oferta" min="0" max="100" step="1" value="0">

        <label for="fecha_inicio">Fecha de inicio de la oferta:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio">

        <label for="fecha_fin">Fecha de fin de la oferta:</label>
        <input type="date" id="fecha_fin" name="fecha_fin">

        <input type="submit" value="Agregar Producto">
        <a href="/sigto/views/mainempresa.php">Volver al Inicio</a>
    </form>
</body>
</html>
