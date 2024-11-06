<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="/sigto/assets/css/formularios.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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
        <input type="text" name="telefono" required><br>

        <!-- Campo para el email -->
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <!-- Campo para la contraseña con el ícono de mostrar/ocultar -->
        <label for="passw">Contraseña:</label>
        <span class="input-wrapper">
            <input type="password" id="passw" name="passw" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i class="bi bi-eye-fill"></i>
            </span>
        </span><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Crear">
        <br><br><br>
        <a id="volver" href="/sigto/views/loginUsuario.php">Volver al Inicio</a>
    </form>

    <!-- Script para el botón de mostrar/ocultar contraseña -->
    <script src="/sigto/assets/js/passbutton.js"></script>
</body>
</html>
