<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Crear Producto</h1>
    <form action="?action=create" method="post">
        <label for="Nombre">Nombre:</label>
        <input type="Nombre" name="Nombre" required><br>
        <label for="Descripcion">Descripcion:</label>
        <input type="Descripcion" name="Descripcion" required><br>
        <label for="Estado">Estado:</label>
        <input type="Estado" name="Estado" required><br>
        <label for="Origen">Origen:</label>
        <input type="Origen" name="Origen" required><br>
        <label for="Cantidad">Cantidad:</label>
        <input type="text" name="Precio" required><br>
        <input type="text" name="Cantidad" required><br>
        <label for="Precio">Precio:</label>
        <input type="submit" value="Crear">
    </form>
    <a class="button" href="?action=list">Volver a la lista</a>
</body>
</html>