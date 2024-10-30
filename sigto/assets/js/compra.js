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


document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("form-entrega");
    const finalizarPagarBtn = document.querySelector("button[type='submit']");

    finalizarPagarBtn.addEventListener("click", function(event) {
        const metodoPagoSeleccionado = document.querySelector("input[name='metodo_pago']:checked");
        
        // Verificar si el método de pago es PayPal
        if (metodoPagoSeleccionado && metodoPagoSeleccionado.value === "paypal") {
            event.preventDefault(); // Prevenir el envío normal del formulario
            // Redirigir a la API de PayPal
            window.location.href = "/sigto/controllers/PaymentController.php?action=createPayment";
        } else {
            // Si no es PayPal, el formulario se envía normalmente
            form.submit();
        }
    });
});
