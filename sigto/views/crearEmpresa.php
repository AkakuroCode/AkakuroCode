<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Crear Usuario</h1>
    <form action="?action=create" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="nombre">Nombre de Usuario:</label>
        <input type="text" name="nombre" required><br>
        <label for= "direccion">Direcció</label>
        <input type="direccion" name="direccion" required><br>
        <label for="telefono">Teléfono</label>
        <input type="telefono" name="telefono" required>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required><br>
        <input type="submit" value="Crear">
    </form>
    <a class="button" href="?action=list">Volver a la lista</a>
</body>
</html>
