<?php if (isset($productoSeleccionado)): ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="/sigto/assets/css/login.css">
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="?action=edit3" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="sku" value="<?php echo htmlspecialchars($productoSeleccionado['sku']); ?>">
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($productoSeleccionado['nombre']); ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($productoSeleccionado['descripcion']); ?></textarea>

        <label for="estado">Estado:</label>
        <input type="radio" id="nuevo" name="estado" value="Nuevo" <?php echo $productoSeleccionado['estado'] == 'Nuevo' ? 'checked' : ''; ?>> Nuevo
        <input type="radio" id="usado" name="estado" value="Usado" <?php echo $productoSeleccionado['estado'] == 'Usado' ? 'checked' : ''; ?>> Usado

        <label for="origen">Origen:</label>
        <input type="radio" id="nacional" name="origen" value="Nacional" <?php echo $productoSeleccionado['origen'] == 'Nacional' ? 'checked' : ''; ?>> Nacional
        <input type="radio" id="internacional" name="origen" value="Internacional" <?php echo $productoSeleccionado['origen'] == 'Internacional' ? 'checked' : ''; ?>> Internacional

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($productoSeleccionado['precio']); ?>" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($productoSeleccionado['stock']); ?>" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen">
        <input type="hidden" name="imagenActual" value="<?php echo htmlspecialchars($productoSeleccionado['imagen']); ?>">
        <img src="/sigto/assets/images/<?php echo htmlspecialchars($productoSeleccionado['imagen']); ?>" alt="<?php echo htmlspecialchars($productoSeleccionado['nombre']); ?>" style="width: 100px; height: auto;">

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
        <a href="/sigto/views/mainempresa.php">Volver al Inicio</a>
    </form>
</body>
</html>
<?php else: ?>
<p>No se encontró el producto a editar.</p>
<?php endif; ?>
