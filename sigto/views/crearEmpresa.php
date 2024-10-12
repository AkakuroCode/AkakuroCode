<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Empresa</title>
    <link rel="stylesheet" href="/sigto/assets/css/formularios.css">
</head>
<body>
   
    <form action="/sigto/index.php?action=create2" method="POST">
    <h1>Crear Empresa</h1>
    
        <!-- Campo para el nombre de la empresa -->
        <label for="nombre">Nombre de la Empresa:</label>
        <input type="text" name="nombre" required><br>

        <!-- Campo para la dirección de la empresa -->
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <!-- Campo para el teléfono de la empresa -->
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br>

        <!-- Campo para el email de la empresa -->
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <!-- Campo para la contraseña -->
        <label for="passw">Contraseña:</label>
        <input type="password" name="passw" required><br>

        <!-- Campo para la cuenta de banco -->
        <label for="cuentabanco">Cuenta de Banco:</label>
        <input type="text" name="cuentabanco" required><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Crear Empresa">
        <br><br><br>
        <a id="volver" href="/sigto/views/mainvisitante.php">Volver al Inicio</a>
    </form>

</body>
</html>
