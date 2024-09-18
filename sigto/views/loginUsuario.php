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
                <form idus="loginForm">
                    <h2>Ingresar</h2>
                    <label for="username">Email:</label>
                    <input type="text" idus="email" name="email" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" idus="passw" name="password" required>
                    <button type="submit">Ingresar</button>
                    <p idus="loginError" class="error-message"></p>
                </form>

                <p>¿No tienes cuenta? <a href="/sigto/index.php?action=create">Regístrate aquí</a></p>
                <a href="./index.html">Volver al Inicio</a>
            </div>
    </div>

</body>
</html>
