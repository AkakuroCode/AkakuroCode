<?php
require_once __DIR__ . '/../controllers/CategoriaController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/OfertaController.php';

$categoriaController = new CategoriaController();
$categorias = $categoriaController->getAllCategorias();

// Inicializar variables
$oferta = 0;
$mensaje = '';

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $origen = $_POST['origen'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $idcat = $_POST['idcat'] ?? '';

    $oferta = $_POST['oferta'] ?? 0;
    $fechaInicio = $_POST['fecha_inicio'] ?? null;
    $fechaFin = $_POST['fecha_fin'] ?? null;

    $imagen = $_FILES['imagen'] ?? null;
    $nombreImagen = '';
    if ($imagen && $imagen['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $imagen['tmp_name'];
        $nombreImagen = basename($imagen['name']);
        $rutaDestino = __DIR__ . '/../assets/images/' . $nombreImagen;
        if ($imagen['size'] > 2000000) {
            $mensaje = "La imagen es demasiado grande. El tamaño máximo permitido es 2MB.";
        } elseif (!move_uploaded_file($tmp_name, $rutaDestino)) {
            $mensaje = "Error al subir la imagen.";
        }
    }

    if (empty($mensaje)) {
        $productoController = new ProductoController();
        $dataProducto = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'estado' => $estado,
            'origen' => $origen,
            'precio' => $precio,
            'stock' => $stock,
            'imagen' => $nombreImagen,
            'tipo_stock' => $_POST['tipo_stock'],
            'codigos_unitarios' => $_POST['codigos_unitarios'] ?? ''
        ];

        $resultadoProducto = $productoController->create($dataProducto);

        if (isset($resultadoProducto['status']) && $resultadoProducto['status'] === 'success') {
            $skuGenerado = $resultadoProducto['sku'];
            $productoController->asignarCategoria($skuGenerado, $idcat);
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
                    $mensaje = "Error al crear la oferta.";
                }
            }

            if (empty($mensaje)) {
                $mensaje = "Producto y oferta creados con éxito.";
            }
        } else {
            $mensaje = "Error al crear el producto: " . $resultadoProducto['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="/sigto/assets/css/formularios.css">
</head>
<body>
    <form action="agregarproducto.php" method="post" enctype="multipart/form-data">
        <h1>Agregar Producto</h1>
        <?php if (!empty($mensaje)): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

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

        <label for="tipo_stock">Tipo de Stock:</label>
        <select name="tipo_stock" id="tipo_stock" required>
            <option value="">Seleccionar tipo de stock</option>
            <option value="unidad">Unidad (código único por unidad)</option>
            <option value="cantidad">Cantidad (manejo por stock total)</option>
        </select>

        <!-- Campo de Stock -->
        <div id="stock-container">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock">
        </div>

        <!-- Campo para ingresar códigos unitarios -->
        <div id="codigos-container">
            <label for="codigos_unitarios">Códigos de las unidades (separados por comas):</label>
            <textarea id="codigos_unitarios" name="codigos_unitarios" rows="4" placeholder="Ingrese los códigos de cada unidad, separados por comas..."></textarea>
        </div>

        <label for="imagen" class="custom-file-upload">
        Seleccionar archivo
        </label>
        <input type="file" id="imagen" name="imagen" accept="image/*"/>

        <!-- Oferta -->
        <h2>Datos de la Oferta</h2>
        <label for="oferta">Oferta (Descuento en %):</label>
        <input type="number" id="oferta" name="oferta" min="0" max="100" step="1" value="0">
        <label for="fecha_inicio">Fecha de inicio de la oferta:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio">
        <label for="fecha_fin">Fecha de fin de la oferta:</label>
        <input type="date" id="fecha_fin" name="fecha_fin">

        <input type="submit" value="Agregar Producto">
        <br><br><br>
        <a id="volver"  href="/sigto/views/mainempresa.php">Volver al Inicio</a>
    </form>

    <script>
        document.getElementById('tipo_stock').addEventListener('change', function() {
            var tipoStock = this.value;
            var stockContainer = document.getElementById('stock-container');
            var codigosContainer = document.getElementById('codigos-container');

            if (tipoStock === 'cantidad') {
                stockContainer.style.display = 'block';
                codigosContainer.style.display = 'none';
            } else if (tipoStock === 'unidad') {
                codigosContainer.style.display = 'block';
                stockContainer.style.display = 'none';
            } else {
                stockContainer.style.display = 'none';
                codigosContainer.style.display = 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('stock-container').style.display = 'none';
            document.getElementById('codigos-container').style.display = 'none';
        });
    </script>
</body>
</html>
