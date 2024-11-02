document.addEventListener('DOMContentLoaded', function () {
    async function obtenerTotalCarrito() {
        try {
            const response = await fetch('/sigto/index.php?action=obtener_total_carrito');
            const data = await response.json();
            return data.total;
        } catch (error) {
            console.error('Error al obtener el total del carrito:', error);
            return '0.00'; // Valor predeterminado en caso de error
        }
    }

    paypal.Buttons({
        createOrder: async function(data, actions) {
            const totalCarrito = await obtenerTotalCarrito(); // Obtenemos el total desde el servidor
            
            if (totalCarrito === '0.00') {
                alert("Error: El total del carrito es 0. No se puede procesar el pago.");
                return; // Evita continuar si el total es 0
            }

            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalCarrito // Usa el total dinámico
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Pago completado por ' + details.payer.name.given_name);
                fetch('/sigto/controllers/CompraController.php', {
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
                  }).catch(error => {
                      console.error('Error al registrar la orden:', error);
                  });
            });
        },
        onCancel: function(data) {
            alert('El pago fue cancelado.');
            window.location.href = "/sigto/views/metodoEntrega.php?status=cancelled";
        },
        onError: function(err) {
            console.error('Error en el proceso de pago:', err);
            alert('Hubo un problema al procesar el pago: ' + (err.message || 'Error desconocido.'));
        }
    }).render('#paypal-button-container');
});