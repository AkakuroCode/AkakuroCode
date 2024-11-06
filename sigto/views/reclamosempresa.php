<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/reclamos.css">
    <title>Reclamos</title>
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
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/mainempresa.php">
                        <i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/empresaperfil.php"><i class="bi bi-building"></i> Perfil</a>
                        </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/agregarproducto.php"><i class="bi bi-plus-circle"></i> Agregar</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/index.php?action=logout">
                        <i class="bi bi-door-closed"></i> Salir</a>
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
            <section class="reclamo-form">
                <h2>Enviar Reclamo</h2>
                <form class="formulario" action="" method="GET" onsubmit="enviarReclamo()">
                    <div>
                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" name="asunto" placeholder="Ingrese su asunto..." required>
                    </div>

                    <div>
                        <label for="reclamo">Escriba su reclamo:</label>
                        <textarea id="reclamo" name="reclamo" rows="5" placeholder="Escriba su reclamo aquí..." required></textarea>
                    </div>

                    <div id="botoncito" >
                        <button type="submit">Enviar Reclamo</button>
                    </div>
                </form>
    <h6>Si no se envia correctamente el reclamo a través de su aplicación de correo, <br>puede mandar un mail manualmente con el asunto "reclamo"<br> al mail <a href="mailto: oceantrade@gmail.com">oceantrade@gmail.com</a></h6>
    <script>
        function enviarReclamo() {
            var asunto = document.getElementById("asunto").value;
            var mensaje = document.getElementById("reclamo").value;

            var mailto_link = "mailto:akakurocode@gmail.com?subject=" + encodeURIComponent(asunto) + "&body=" + encodeURIComponent(mensaje);

            window.location.href = mailto_link;
            return false; // Evitar que el formulario se envíe de la manera tradicional
        }
    </script>
            </section>
        </main>
          
    <br><br><br><br><br><br>
    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <p>Contacto</p>
                <a href="/sigto/views/nosotroscliente.php">Nosotros</a>
                <br>
                <a href="tel:+598 92345888">092345888</a>
                <br>
                <a href="mailto: oceantrade@gmail.com">oceantrade@gmail.com</a>
            </div>
            <div class="footer-item">
                <p>Horario de Atención <br><br>Lunes a Viernes de 10hs a 18hs</p>

            </div>

            <div class="footer-redes">
                <a href="https://www.facebook.com/"><img class="redes" src="/sigto/assets/images/facebook logo.png"  alt="Facebook"></a>
                <a href="https://twitter.com/home"><img class="redes" src="/sigto/assets/images/x.png"  alt="Twitter"></a>
                <a href="https://www.instagram.com/"><img class="redes" src="/sigto/assets/images/ig logo.png"  alt="Instagram"></a>
            </div>
        </div>
    </footer>
    <script src="/assets/js/script.js"></script>
    <script src="/sigto/assets/js/searchbar.js"></script>

</body>
</html>