paypal.Buttons({
    createOrder: function(data, actions) {
        // Configura la orden en PayPal
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '10.00' // Cambia esto al monto dinámico de tu compra
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        // Captura el pago cuando el usuario lo aprueba
        return actions.order.capture().then(function(details) {
            alert('Pago completado por ' + details.payer.name.given_name);

            // Opcional: enviar datos al servidor para registrar la orden
            // Esto se puede hacer con fetch() o AJAX
            fetch('/sigto/controllers/OrderController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    orderId: data.orderID,
                    payerName: details.payer.name.given_name,
                    paymentStatus: details.status
                })
            }).then(response => response.json())
              .then(data => {
                  console.log('Orden registrada:', data);
                  // Redirigir al usuario o actualizar la UI
              }).catch(error => {
                  console.error('Error al registrar la orden:', error);
              });
        });
    },
    onCancel: function(data) {
        // Muestra un mensaje o redirige si el usuario cancela el pago
        alert('El pago fue cancelado.');
        window.location.href = "/sigto/views/metodoEntrega.php?status=cancelled";
    },
    onError: function(err) {
        console.error('Error en el proceso de pago:', err);
        alert('Hubo un problema al procesar el pago.');
    }
}).render('#paypal-button-container'); // Renderiza el botón en el contenedor
