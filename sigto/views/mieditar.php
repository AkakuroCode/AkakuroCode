<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Incluir el controlador de usuario o la lógica para obtener el usuario logueado
require_once __DIR__ . '/../controllers/UsuarioController.php';


$usuarioController = new UsuarioController();
$usuario = $usuarioController->getUserById($_SESSION['idus']);

// Verificar que se encontró el usuario
if (!$usuario) {
    echo "Error: no se encontró el usuario.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="/sigto/assets/css/formularios.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    
    <form action="/sigto/index?action=edit_profile&idus=<?php echo $usuario['idus']; ?>" method="post">
        <h1>Editar Usuario</h1>

        <!-- Campo oculto para el idus -->
        <input type="hidden" name="idus" value="<?php echo $usuario['idus']; ?>">

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

        <label for="passw">Contraseña:</label>
        <span class="input-wrapper">
        <input type="password" id="passw" name="passw" placeholder="Deja en blanco si no deseas cambiarla">
        <span class="toggle-password" onclick="togglePassword()">
        <i class="bi bi-eye-fill"></i>
         </span>
        </span><br>


        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Actualizar">
        <br><br><br>
        <a id="volver" href="/sigto/views/usuarioperfil.php">Volver al perfil</a>
    </form>
    <script src="/sigto/assets/js/passbutton.js"></script>
</body>
</html>
