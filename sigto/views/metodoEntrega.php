<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario esté logueado
if (!isset($_SESSION['idus'])) {
    echo "Error: Usuario no logueado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Seleccionar Método de Entrega</title>
    <script>
        function mostrarOpcionesEntrega() {
            var opcionesPickUp = document.getElementById('opciones-pickup');
            var formularioDomicilio = document.getElementById('formulario-domicilio');
            
            if (document.getElementById('pickUp').checked) {
                opcionesPickUp.style.display = 'block';
                formularioDomicilio.style.display = 'none';
            } else if (document.getElementById('domicilio').checked) {
                opcionesPickUp.style.display = 'none';
                formularioDomicilio.style.display = 'block';
            } else {
                opcionesPickUp.style.display = 'none';
                formularioDomicilio.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Seleccionar Método de Entrega</h2>
        <form action="procesarEntrega.php" method="POST">
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
                    <label for="esquina">Esquina:</label>
                    <input type="text" class="form-control" id="esquina" name="esquina">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Continuar</button>
        </form>
    </div>
</body>
</html>