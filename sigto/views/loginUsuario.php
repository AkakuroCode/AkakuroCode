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
                <div class="registro">
                    <p>¿No tienes cuenta? Regístrate aquí:</p>
                    <a id="registro" href="/sigto/index.php?action=create">Regístrate aquí</a>
                    <a id="registro" href="/sigto/index.php?action=create2">Regístra tu empresa</a>
                    <a id="registro" href="/sigto/views/mainvisitante.php">Volver al Inicio</a>
                </div>
    </div>

</body>
</html>
