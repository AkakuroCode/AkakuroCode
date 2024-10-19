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
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/sigto/assets/css/style.css"> <!-- Estilos personalizados -->
</head>
<body>
<div class="contenedor">
    <header>
    <nav class="navbar navbar-expand-sm bg-body-tertiary">
                <div class="container-fluid">
                  <a class="navbar-brand" href="#"><img class="w-50" src="/sigto/assets/images/navbar logo 2.png" alt="OceanTrade"></a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                      <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/maincliente.php">Inicio</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/usuarioperfil.php">Perfil</a>
                    </li>
                      <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/nosotroscliente.php">Nosotros</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/index?action=view_cart">Carrito</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/index.php?action=logout">Salir</a>
                    </li>
                    </ul>
                    <form id="search-form" action="/sigto/views/catalogo.php" method="GET" autocomplete="off">
                    <input type="text" id="search-words" name="query" placeholder="Buscar productos..." onkeyup="showSuggestions(this.value)">
                    <div id="suggestions"></div> <!-- Div para mostrar las sugerencias -->
                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</div>
</body>
</html>
