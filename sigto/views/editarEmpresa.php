<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="../sigto/assets/css/formularios.css">
</head>
<body>
    
    <form action="../sigto/index.php?action=edit2&idemp=<?php echo $empresa['idemp']; ?>" method="post">
    <h1>Editar Empresa</h1>

        <!-- Campo oculto para el idemp -->
        <input type="hidden" name="idemp" value="<?php echo $empresa['idemp']; ?>">

        <!-- Campo para el nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $empresa['nombre']; ?>" required><br>

        <!-- Campo para la dirección -->
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $empresa['direccion']; ?>" required><br>

        <!-- Campo para el teléfono -->
        <label for="telefono">Teléfono:</label>
        <input type="telefono" name="telefono" value="<?php echo $empresa['telefono']; ?>" required><br>

        <!-- Campo para el email -->
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $empresa['email']; ?>" required><br>

        <!-- Campo para la contraseña -->
        <label for="passw">Contraseña:</label>
        <input type="password" name="passw" placeholder="Deja en blanco si no deseas cambiarla"><br>

        <!-- Campo para el cuenta de banco -->
        <label for="cuentabanco">Cuenta de Banco:</label>
        <input type="cuentabanco" name="cuentabanco" value="<?php echo $empresa['cuentabanco']; ?>" required><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Actualizar">
        <br><br><br>
        <a id="volver" href="/sigto/index.php?action=list">Volver a la lista</a>
    </form>
    
</body>
</html>
