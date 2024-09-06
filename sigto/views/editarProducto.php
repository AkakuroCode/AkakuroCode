<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="?action=edit&id=<?php echo $producto['sku']; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $producto['idProductos']; ?>">
        <label for="Nombre">Nombre:</label>
        <input type="Nombre" name="Nombre" value="<?php echo $producto['Nombre']; ?>" required><br>
        <label for="Cantidad">Cantidad de producto:</label>
        <input type="text" name="Cantidad" value="<?php echo $producto['Cantidad']; ?>" required><br>
        <label for="Precio">Precio:</label>
        <input type="text" name="Precio" value="<?php echo $producto['Precio']; ?>" required><br>
        <input type="submit" value="Actualizar">
    </form>
    <a class="button" href="?action=list">Volver a la lista</a>
</body>
</html>