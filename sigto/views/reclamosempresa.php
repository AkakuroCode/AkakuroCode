<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/reclamos.css">
    <title>Reclamos</title>
</head>
<body>
    <header>
        <nav class="mi-navbar">
           <div class="mi-navbar-container">
                   <h1>
                    <img class="mi-navbar-logo" src="/sigto/assets/images/navbar logo 2.png" alt="OceanTrade">
                   </h1>
                    <div class="mi-navbar-items">
                        <form action="ruta/destino" method="GET" class="search-form"> <!-- Ajusta 'action' y 'method' según el backend -->
                            <input class="searchbar" type="text" placeholder="Buscar..." autocomplete="off" maxlength="50" id="search-words" name="query">
                        </form>
                    <a href="mainempresa.php">Inicio</a>
                    <a href="../index.php?action=logout">Salir</a>
                    </div>
                    
            </div>
        </nav>
    </header>

        <main>
            <section class="reclamo-form">
                <h2>Enviar Reclamo</h2>
                <form action="/enviar-reclamo" method="POST">
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" placeholder="Ingrese su correo" required>
                    </div>

                    <div class="form-group">
                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" class="input-text" placeholder="Ingrese su asunto" name="asunto" required>
                    </div>

                    <div class="form-group">
                        <label for="reclamo">Escriba su reclamo:</label>
                        <textarea id="reclamo" name="reclamo" rows="5" placeholder="Escriba su reclamo aquí..." required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit">Enviar Reclamo</button>
                    </div>
                </form>
            </section>
        </main>
          
    <br><br><br><br><br><br>
    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <p>Contacto</p>
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
</body>
</html>