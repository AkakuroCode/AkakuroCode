<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['idus'])) {
    echo "Error: Usuario no logueado.";
    exit;
}

require_once __DIR__ . '/../controllers/MetodopagoController.php';
$metodoDePagoController = new MetodoDePagoController();
$metodos_pago = $metodoDePagoController->obtenerMetodosDePagoActivos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <title>Seleccionar Método de Entrega y Pago</title>
    <script>
        function mostrarOpcionesEntrega() {
            var opcionesPickUp = document.getElementById('opciones-pickup');
            var formularioDomicilio = document.getElementById('formulario-domicilio');
            var botonContinuar = document.getElementById('boton-continuar');
            
            if (document.getElementById('pickUp').checked) {
                opcionesPickUp.style.display = 'block';
                formularioDomicilio.style.display = 'none';
                botonContinuar.style.display = 'block';
            } else if (document.getElementById('domicilio').checked) {
                opcionesPickUp.style.display = 'none';
                formularioDomicilio.style.display = 'block';
                botonContinuar.style.display = 'block';
            } else {
                opcionesPickUp.style.display = 'none';
                formularioDomicilio.style.display = 'none';
                botonContinuar.style.display = 'none';
            }
        }

        function validarCampos() {
            // Verificar si un radio button de Pick Up está seleccionado
            var pickupSeleccionado = document.querySelector('input[name="ubicacion_pickup"]:checked');
            // Obtener los valores de los campos de entrega a domicilio
            var calle = document.getElementById('calle').value;
            var numero = document.getElementById('numero').value;

            // Mostrar las opciones de pago solo si:
            // 1. Se seleccionó una opción de Pick Up
            // O
            // 2. Los campos "Calle" y "Número de Puerta" están completos
            if (pickupSeleccionado || (calle.trim() !== '' && numero.trim() !== '')) {
                mostrarOpcionesPago();
            } else {
                alert("Por favor, complete todos los campos requeridos para continuar.");
            }
        }

        function mostrarOpcionesPago() {
            var opcionesPago = document.getElementById('opciones-pago');
            opcionesPago.style.display = 'block'; // Mostrar opciones de pago después de continuar
        }
    </script>
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
    <main>
    <div class="container mt-5">
        <h2>Seleccionar Método de Entrega</h2>
        <form id="form-entrega" action="procesarEntregaYPago.php" method="POST">
            <!-- Selección de Retiro en Pick up -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo_entrega" id="pickUp" value="pick_up" required onclick="mostrarOpcionesEntrega()">
                <label class="form-check-label" for="pickUp">
                    Retiro en Pick up
                </label>
            </div>

            <!-- Selección de Entrega a Domicilio -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo_entrega" id="domicilio" value="domicilio" required onclick="mostrarOpcionesEntrega()">
                <label class="form-check-label" for="domicilio">
                    Entrega a Domicilio
                </label>
            </div>

            <!-- Opciones de Pick up -->
            <div id="opciones-pickup" style="display: none; margin-top: 20px;">
                <h5>Seleccionar ubicación de Pick up:</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ubicacion_pickup" id="pickup1" value="ubicacion1" required>
                    <label class="form-check-label" for="pickup1">Ubicación 1 - Shopping Tres Cruces</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ubicacion_pickup" id="pickup2" value="ubicacion2" required>
                    <label class="form-check-label" for="pickup2">Ubicación 2 - Unión</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ubicacion_pickup" id="pickup3" value="ubicacion3" required>
                    <label class="form-check-label" for="pickup3">Ubicación 3 - Portones Shopping</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ubicacion_pickup" id="pickup4" value="ubicacion4" required>
                    <label class="form-check-label" for="pickup4">Ubicación 4 - Prado</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ubicacion_pickup" id="pickup5" value="ubicacion5" required>
                    <label class="form-check-label" for="pickup5">Ubicación 5 - Centro</label>
                </div>
            </div>

            <!-- Formulario para Entrega a Domicilio -->
            <div id="formulario-domicilio" style="display: none; margin-top: 20px;">
                <h5>Ingresar Dirección de Entrega</h5>
                <div class="form-group">
                    <label for="calle">Calle:</label>
                    <input type="text" class="form-control" id="calle" name="calle" required>
                </div>
                <div class="form-group">
                    <label for="numero">Número de Puerta:</label>
                    <input type="text" class="form-control" id="numero" name="numero" required>
                </div>
                <div class="form-group">
                    <label for="esquina">Esquina (opcional):</label>
                    <input type="text" class="form-control" id="esquina" name="esquina">
                </div>
            </div>

            <!-- Botón Continuar -->
            <button type="button" id="boton-continuar" class="btn btn-primary mt-3" style="display: none;" onclick="validarCampos()">Continuar</button>

            <!-- Opciones de Pago -->
            <div id="opciones-pago" style="display: none; margin-top: 20px;">
                    <h5>Seleccionar Método de Pago:</h5>
                    <?php foreach ($metodos_pago as $index => $metodo): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodo_pago" id="metodo_pago_<?= $index ?>" value="<?= strtolower(str_replace(' ', '_', $metodo)) ?>" required>
                            <label class="form-check-label" for="metodo_pago_<?= $index ?>"><?= $metodo ?></label>
                        </div>
                    <?php endforeach; ?>
                <!-- Botón Finalizar -->
                <button type="submit" class="btn btn-success mt-3">Finalizar y Pagar</button>
            </div>
        </form>
    </div>
    </main>
    <br><br><br><br><br><br>
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
        
        <script src="/sigto/assets/js/searchbar.js"></script>
    </footer>
</div>
</body>
</html>
