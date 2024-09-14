<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sigto/assets/css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="box">
        <img class="logologin" src="/sigto/assets/images/logo completo.png" alt="oceanTrade logo">
            <div>
                <form id="loginForm">
                    <h2>Ingresar</h2>
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Ingresar</button>
                    <p id="loginError" class="error-message"></p>
                </form>

                <p>¿No tienes cuenta? <a href="crearusuario.php">Regístrate aquí</a></p>
                <a href="../index.html">Volver al Inicio</a>
            </div>
    </div>

</body>
</html>
