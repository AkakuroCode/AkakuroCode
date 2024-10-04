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
                <form id="loginForm" method="POST" action="/sigto/index.php?action=login">
                    <h2>Ingresar</h2>
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" required>
                    <label for="passw">Contraseña:</label>
                    <input type="password" id="passw" name="passw" required>
                    <button type="submit">Ingresar</button>
                    <?php if (isset($error)) { ?><p id="loginError" class="error-message">
                    <?php echo $error; ?></p><?php } ?>
                </form>
                <p>¿No tienes cuenta? <a href="/sigto/index.php?action=create">Regístrate aquí</a></p>
                <a href="/sigto/index.php?action=create2">Regístra tu empresa</a>
                <a href="/sigto/views/mainvisitante.php">Volver al Inicio</a>
            </div>
    </div>

</body>
</html>
