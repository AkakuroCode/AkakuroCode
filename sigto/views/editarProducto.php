<?php
if (isset($productoSeleccionado)):
require_once __DIR__ . '/../controllers/CategoriaController.php'; // Asegúrate de incluir el controlador de categorías

$categoriaController = new CategoriaController();
$categorias = $categoriaController->getAllCategorias(); // Obtiene todas las categorías
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="/sigto/assets/css/formularios.css">
</head>
<body>
    <form action="../sigto/index/?action=edit3&sku" method="POST" enctype="multipart/form-data">
    <h1>Editar Producto</h1>
        <input type="hidden" name="sku" value="<?php echo htmlspecialchars($productoSeleccionado['sku']); ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($productoSeleccionado['nombre']); ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($productoSeleccionado['descripcion']); ?></textarea>

        <!-- Select para elegir el estado -->
        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="Nuevo" <?php echo $productoSeleccionado['estado'] == 'Nuevo' ? 'selected' : ''; ?>>Nuevo</option>
            <option value="Usado" <?php echo $productoSeleccionado['estado'] == 'Usado' ? 'selected' : ''; ?>>Usado</option>
        </select>

        <!-- Select para elegir el origen -->
        <label for="origen">Origen:</label>
        <select id="origen" name="origen" required>
            <option value="Nacional" <?php echo $productoSeleccionado['origen'] == 'Nacional' ? 'selected' : ''; ?>>Nacional</option>
            <option value="Internacional" <?php echo $productoSeleccionado['origen'] == 'Internacional' ? 'selected' : ''; ?>>Internacional</option>
        </select>

        <!-- Select para elegir la categoría -->
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria">
            <option value="">Seleccionar categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo htmlspecialchars($categoria['idcat']); ?>" 
                    <?php echo (isset($categoriaSeleccionada['idcat']) && $categoriaSeleccionada['idcat'] == $categoria['idcat']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($productoSeleccionado['precio']); ?>" required>

        <?php if ($productoSeleccionado['tipo_stock'] === 'cantidad'): ?>
        <!-- Si el tipo de stock es "cantidad", muestra el campo de stock -->
        <label for="stock">Stock (Cantidad):</label>
        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($productoSeleccionado['stock']); ?>" required>
        <?php elseif ($productoSeleccionado['tipo_stock'] === 'unidad'): ?>
        <!-- Si el tipo de stock es "unidad", muestra el textarea para agregar los códigos de unidades -->
        <label for="codigos_unitarios">Códigos de las unidades (separados por comas):</label>
        <textarea id="codigos_unitarios" name="codigos_unitarios" rows="4" placeholder="Ingrese los códigos de cada unidad, separados por comas..."><?php 
            // Verificar si ya hay códigos unitarios para este producto
            if (isset($productoSeleccionado['codigo_unidad'])) {
                // Convertir a array si es necesario, y mostrar los códigos separados por comas
                echo htmlspecialchars(implode(',', (array)$productoSeleccionado['codigo_unidad']));
            }
        ?></textarea>
        <?php endif; ?>


        <label for="imagen" class="custom-file-upload">
        Seleccionar archivo
        </label>
        <input type="file" id="imagen" name="imagen" accept="image/*"/><br>
        <input type="hidden" name="imagenActual" value="<?php echo htmlspecialchars($productoSeleccionado['imagen']); ?>">
        <img src="/sigto/assets/images/<?php echo htmlspecialchars($productoSeleccionado['imagen']); ?>" alt="<?php echo htmlspecialchars($productoSeleccionado['nombre']); ?>" style="width: 100px; height: auto;">
        
        <input type="hidden" name="tipo_stock" value="<?php echo htmlspecialchars($productoSeleccionado['tipo_stock']); ?>">

        <!-- Sección de Oferta -->
        <h2>Editar Oferta</h2>

        <?php if (isset($ofertaSeleccionada)): ?>
            <!-- Mostrar detalles de la oferta actual si existe -->
            <label for="oferta">Oferta Actual (Descuento en %):</label>
            <input type="number" id="oferta" name="oferta" value="<?php echo htmlspecialchars($ofertaSeleccionada['porcentaje_oferta']); ?>" min="0" max="100">

            <label for="fecha_inicio">Fecha de inicio de la oferta:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($ofertaSeleccionada['fecha_inicio']); ?>">

            <label for="fecha_fin">Fecha de fin de la oferta:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($ofertaSeleccionada['fecha_fin']); ?>">

        <?php else: ?>
            <!-- Si no existe una oferta previa, permitir crear una nueva -->
            <label for="oferta">Nueva Oferta (Descuento en %):</label>
            <input type="number" id="oferta" name="oferta" min="0" max="100">

            <label for="fecha_inicio">Fecha de inicio de la oferta:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio">

            <label for="fecha_fin">Fecha de fin de la oferta:</label>
            <input type="date" id="fecha_fin" name="fecha_fin">
        <?php endif; ?>

        <button type="submit">Actualizar Producto</button>
        <br><br><br>
        <a id="volver" href="?action=list2">Volver a la lista</a>
    </form>
</body>
</html>
<?php else: ?>
<p>No se encontró el producto a editar.</p>
<?php endif; ?>
