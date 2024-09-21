<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    
    <form action="?action=edit&idus=<?php echo $usuario['idus']; ?>" method="post">
    <h1>Editar Usuario</h1>
        <!-- Campo para el nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br>

        <!-- Campo para el apellido -->
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $usuario['apellido']; ?>" required><br>

        <!-- Campo para la fecha de nacimiento -->
        <label for="fecnac">Fecha de Nacimiento:</label>
        <input type="date" name="fecnac" value="<?php echo $usuario['fecnac']; ?>" required><br>

        <!-- Campo para la dirección -->
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $usuario['direccion']; ?>" required><br>

        <!-- Campo para el teléfono -->
        <label for="telefono">Teléfono:</label>
        <input type="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required><br>

        <!-- Campo para el email -->
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>

        <!-- Campo para la contraseña -->
        <label for="passw">Contraseña:</label>
        <input type="password" name="passw" placeholder="Deja en blanco si no deseas cambiarla"><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Actualizar">
        <a class="button" href="/sigto/index.php?action=list">Volver a la lista</a>
    </form>
    
</body>
</html>
