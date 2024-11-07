<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <title>Nosotros Cliente</title>
</head>
<body>
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
                        <a class="nav-link nav-icon" href="/sigto/views/maincliente.php">
                        <i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link nav-icon" href="/sigto/views/usuarioperfil.php">
                        <i class="bi bi-person-circle"></i> Perfil</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link nav-icon" href="/sigto/index.php?action=view_cart">
                        <i class="bi bi-cart"></i> Carrito</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link nav-icon" href="/sigto/index.php?action=logout">
                        <i class="bi bi-door-open"></i>Salir</a>
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
    
    <main>
        <div class="ot">
            <h1>
            <img src="/sigto/assets/images/logo 2.png" alt="Nosotros">
            </h1>

            <h2>Sobre nosotros</h2>
            <p>El nombre OceanTrade claramente refleja el propósito y la misión de la empresa en el sector del comercio internacional. El logo, con su imagen de velero, evoca la esencia del transporte marítimo, mientras que la paleta de colores elegida comunica confianza, modernidad, eficiencia y dinamismo. Juntos, estos elementos forman una identidad visual coherente y profesional que representa adecuadamente los valores y objetivos de la empresa.</p>

            <h2>Misión</h2>
            <p>Nuestra misión es proporcionar a nuestros clientes una experiencia de compra en línea confiable, eficiente y moderna. A través de nuestra plataforma, nos esforzamos por ofrecer una amplia gama de productos de alta calidad con un servicio al cliente excepcional, asegurando que cada transacción sea segura, rápida y satisfactoria.</p>

            <h2>Visión</h2>
            <p>Nuestra visión es ser el líder global en el comercio electrónico, conocido por nuestra innovación, eficiencia y compromiso con la sostenibilidad. Aspiramos a conectar a consumidores y proveedores de todo el mundo, facilitando el comercio internacional y promoviendo un desarrollo económico sostenible y equitativo.</p>
            
            <h2>Valores</h2>
            <p>
                <b>Confianza:</b> Construimos relaciones sólidas con nuestros clientes y socios comerciales a través de la transparencia, la honestidad y la integridad.
                <br><br>
                <b>Innovación:</b> Adoptamos y fomentamos la creatividad y la innovación en todas nuestras operaciones para mejorar continuamente nuestros servicios.
                <br><br>
                <b>Eficiencia:</b> Optimizamos nuestros procesos para ofrecer una experiencia de compra rápida y sin contratiempos.
                <br><br>
                <b>Sostenibilidad:</b> Nos comprometemos a prácticas comerciales responsables que minimicen nuestro impacto ambiental y promuevan la sostenibilidad.
                <br><br>
                <b>Dinamicidad:</b> Nos adaptamos rápidamente a los cambios del mercado y a las necesidades de nuestros clientes para seguir siendo relevantes y competitivos.
            </p>
            
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <p>Contacto</p>
                <a href="/sigto/views/nosotroscliente.php">Nosotros</a>
                <br>
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
                <a href="https://www.instagram.com/akakurocode/"><img class="redes" src="/sigto/assets/images/ig logo.png" alt="Instagram"></a>ig logo.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>
    <script src="/assets/js/script.js"></script>
    <script src="/sigto/assets/js/searchbar.js"></script>
</body>
</html>