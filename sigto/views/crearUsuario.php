<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="/sigto/assets/css/formularios.css">

</head>
<body>
   
    <form action="/sigto/index.php?action=create" method="POST">
    <h1>Crear Usuario</h1>
        <!-- Campo para el nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <!-- Campo para el apellido -->
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required><br>

        <!-- Campo para la fecha de nacimiento -->
        <label for="fecnac">Fecha de Nacimiento:</label>
        <input type="date" name="fecnac" required><br>

        <!-- Campo para la dirección -->
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <!-- Campo para el teléfono -->
        <label for="telefono">Teléfono:</label>
        <input type="telefono" name="telefono" required><br>

        <!-- Campo para el email -->
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <!-- Campo para la contraseña -->
        <label for="passw">Contraseña:</label>
        <input type="password" name="passw" required><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Crear">
        <br><br><br>
        <a id="volver" href="/sigto/views/mainvisitante.php">Volver al Inicio</a>
    </form>
</body>
</html>
