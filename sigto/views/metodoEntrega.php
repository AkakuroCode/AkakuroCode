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
    <!-- Incluir CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Seleccionar Método de Entrega</title>
    <style>
        /* Estilos para el mapa */
        #map {
            width: 100%;
            height: 400px;
            margin-top: 20px;
        }
    </style>
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

        // Geocodificación inversa con Nominatim
        function reverseGeocode(lat, lng) {
    var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data && data.address) {
                var address = data.address;

                // Actualizamos el campo de la calle y número de puerta
                document.getElementById('calle').value = address.road || '';
                document.getElementById('numero').value = address.house_number || '';

                // Tratamos de obtener la esquina o intersección de la dirección
                var esquina = address.intersection || address.road || '';
                
                // Fallbacks adicionales
                if (!esquina && address.neighbourhood) {
                    esquina = address.neighbourhood;
                }
                if (!esquina && address.suburb) {
                    esquina = address.suburb;
                }

                // Asignar la esquina al campo correspondiente
                document.getElementById('esquina').value = esquina;
            }
        })
        .catch(error => {
            console.error('Error al obtener la dirección:', error);
        });
}

        // Inicializar el mapa usando Leaflet
        function initMap() {
            var map = L.map('map').setView([-34.9011, -56.1645], 13); // Coordenadas de Montevideo, por ejemplo

            // Cargar tiles de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker([-34.9011, -56.1645], {draggable: true}).addTo(map);

            // Actualizar los campos de latitud y longitud cuando se mueva el marcador
            marker.on('dragend', function(event) {
                var position = marker.getLatLng();
                document.getElementById('latitud').value = position.lat;
                document.getElementById('longitud').value = position.lng;

                // Hacer la geocodificación inversa
                reverseGeocode(position.lat, position.lng);
            });
        }
    </script>
</head>
<body onload="initMap()">
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
                    <label class="form-check-label" for="pickup1">Ubicación 1 - Centro Comercial A</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ubicacion_pickup" id="pickup2" value="ubicacion2" required>
                    <label class="form-check-label" for="pickup2">Ubicación 2 - Plaza B</label>
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
                    <input type="text" class="form-control" id="esquina" name="esquina" required>
                </div>

                <!-- Mapa para seleccionar ubicación -->
                <div id="map"></div>
                <input type="hidden" id="latitud" name="latitud" required>
                <input type="hidden" id="longitud" name="longitud" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Continuar</button>
        </form>
    </div>

    <!-- Incluir JavaScript de Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</body>
</html>