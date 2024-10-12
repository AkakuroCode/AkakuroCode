<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css"> <!-- Estilos personalizados -->
</head>
<body>
    <header>
        <nav class="mi-navbar">
            <div class="mi-navbar-container">
                <h1>
                    <img class="mi-navbar-logo" src="/sigto/assets/images/navbar logo.png" alt="OceanTrade">
                </h1>
                <div class="mi-navbar-items">
                    <form action="ruta/destino" method="GET" class="search-form">
                        <input class="searchbar" type="text" placeholder="Buscar..." autocomplete="off" maxlength="50" id="search-words" name="query">
                    </form>
                    <a href="maincliente.php">Inicio</a>
                    <a href="/sigto/views/usuarioperfil.php">Perfil</a> 
                    <a href="/sigto/index?action=view_cart">Carrito</a>
                    <a href="nosotroscliente.php">Nosotros</a>
                    <a href="/sigto/index.php?action=logout">Salir</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h2 class="text-center">Perfil de Usuario</h2>
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 text-center">
                <a href="/sigto/index?action=edit_profile" class="btn btn-outline-primary btn-lg btn-block mb-3">Editar Información</a>
                <a href="historialCompras.php" class="btn btn-outline-secondary btn-lg btn-block">Historial de Compras</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <p>Contacto</p>
                <a href="tel:+598 92345888">092345888</a>
                <br>
                <a href="mailto: oceantrade@gmail.com">oceantrade@gmail.com</a>
                <br>
                <a href="reclamoscliente.php">Reclamos</a>
            </div>
            <div class="footer-item">
                <p>Horario de Atención <br><br>Lunes a Viernes de 10hs a 18hs</p>
            </div>
            
            <div class="footer-redes">
                <a href="https://www.facebook.com/"><img class="redes" src="/sigto/assets/images/facebook logo.png" alt="Facebook"></a>
                <a href="https://twitter.com/home"><img class="redes" src="/sigto/assets/images/x.png" alt="Twitter"></a>
                <a href="https://www.instagram.com/"><img class="redes" src="/sigto/assets/images/ig logo.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
