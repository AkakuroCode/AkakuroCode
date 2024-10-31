<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/sigto/assets/css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="box">
        <!-- Logo del formulario de login -->
        <img class="logologin" src="/sigto/assets/images/logo completo.png" alt="oceanTrade logo">
        
        <!-- Formulario de Login -->
        <form id="loginForm" method="POST" action="/sigto/index.php?action=login">
            <h2>Ingresar</h2>
            
            <!-- Campo de email -->
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" class="form-control" required>
            
            <!-- Campo de contraseña con botón de mostrar/ocultar integrado -->
            <label for="passw" class="mt-3">Contraseña:</label>
            <div class="input-group mb-3">
                <input type="password" id="passw" name="passw" class="form-control" required>
                <button class="btn-show-password" type="button" onclick="togglePassword()">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </div>
            
            <!-- Botón de ingresar -->
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            
            <!-- Mensaje de error si las credenciales son incorrectas -->
            <?php if (isset($error)) { ?>
                <p id="loginError" class="error-message mt-3"><?php echo $error; ?></p>
            <?php } ?>
        </form>
        
        <!-- Opciones de registro y navegación -->
        <div class="registro mt-4">
            <p>¿No tienes cuenta? Regístrate aquí:</p>
            <a id="registro" href="/sigto/index.php?action=create" class="btn btn-light btn-block">Regístrate aquí</a>
            <a id="registro" href="/sigto/index.php?action=create2" class="btn btn-light btn-block">Registra tu empresa</a>
            <a id="registro" href="/sigto/views/mainvisitante.php" class="btn btn-light btn-block">Volver al Inicio</a>
        </div>
    </div>

    <!-- JavaScript para alternar visibilidad de la contraseña y cambiar el ícono -->
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("passw");
            const eyeIcon = document.querySelector(".btn-show-password i");
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("bi-eye-fill");
                eyeIcon.classList.add("bi-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye-fill");
            }
        }
    </script>
</body>
</html>
