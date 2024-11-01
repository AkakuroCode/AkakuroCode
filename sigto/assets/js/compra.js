function mostrarOpcionesEntrega() {
    var opcionesPickUp = document.getElementById('opciones-pickup');
    var formularioDomicilio = document.getElementById('formulario-domicilio');
    var botonContinuar = document.getElementById('boton-continuar');
    var opcionesPago = document.getElementById('opciones-pago');

    // Ocultar el contenedor de opciones de pago cada vez que se cambia la opción de entrega
    opcionesPago.style.display = 'none';

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
    if (document.getElementById('pickUp').checked && pickupSeleccionado) {
        mostrarOpcionesPago();
    } else if (document.getElementById('domicilio').checked && calle.trim() !== '' && numero.trim() !== '') {
        mostrarOpcionesPago();
    } else {
        alert("Por favor, complete todos los campos requeridos para continuar.");
    }
}

function mostrarOpcionesPago() {
    var opcionesPago = document.getElementById('opciones-pago');
    opcionesPago.style.display = 'block'; // Mostrar opciones de pago después de continuar
}
