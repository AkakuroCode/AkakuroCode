<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="?action=edit&idemp=<?php echo $empresa['idemp']; ?>" method="post">
        <input type="hidden" name="idemp" value="<?php echo $usuario['idemp']; ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $empresa['email']; ?>" required><br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $empresa['nombre']; ?>" required><br>
        <label for="direccion">Dirección</label>
        <input type="direccion" name="direccion" value="<?php echo $empresa['direccion']; ?>" required><br>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" value="<?php echo $empresa['telefono']; ?>" required><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required><br>
        <input type="submit" value="Actualizar">
    </form>
    <a class="button" href="?action=list">Volver a la lista</a>
</body>
</html>
