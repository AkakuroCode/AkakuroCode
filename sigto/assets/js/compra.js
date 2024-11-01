function mostrarOpcionesEntrega() {
    var opcionesPickUp = document.getElementById('opciones-pickup');
    var formularioDomicilio = document.getElementById('formulario-domicilio');
    var botonContinuar = document.getElementById('boton-continuar');
    var opcionesPago = document.getElementById('opciones-pago');
    var vehiculoContainer = document.getElementById('vehiculo-container');

    // Ocultar las opciones de pago cada vez que se cambia la opción de entrega
    opcionesPago.style.display = 'none';

    if (document.getElementById('pickUp').checked) {
        opcionesPickUp.style.display = 'block';
        formularioDomicilio.style.display = 'none';
        vehiculoContainer.style.display = 'none'; // Ocultar el select de vehículos para la opción de pick-up
        botonContinuar.style.display = 'block';
    } else if (document.getElementById('domicilio').checked) {
        opcionesPickUp.style.display = 'none';
        formularioDomicilio.style.display = 'block';
        vehiculoContainer.style.display = 'block'; // Mostrar el select de vehículos para la opción de domicilio
        botonContinuar.style.display = 'block';
    } else {
        opcionesPickUp.style.display = 'none';
        formularioDomicilio.style.display = 'none';
        vehiculoContainer.style.display = 'none';
        botonContinuar.style.display = 'none';
    }
}

function validarCampos() {
    var pickupSeleccionado = document.querySelector('input[name="ubicacion_pickup"]:checked');
    var calle = document.getElementById('calle').value;
    var numero = document.getElementById('numero').value;
    var vehiculoSeleccionado = document.getElementById('vehiculo').value;

    // Validar los campos según el método de entrega seleccionado
    if (document.getElementById('pickUp').checked && pickupSeleccionado) {
        mostrarOpcionesPago();
    } else if (document.getElementById('domicilio').checked && 
               calle.trim() !== '' && 
               numero.trim() !== '' && 
               vehiculoSeleccionado !== '') {
        mostrarOpcionesPago();
    } else {
        alert("Por favor, complete todos los campos requeridos para continuar.");
    }
}

function mostrarOpcionesPago() {
    var opcionesPago = document.getElementById('opciones-pago');
    opcionesPago.style.display = 'block'; // Mostrar opciones de pago después de continuar
}
