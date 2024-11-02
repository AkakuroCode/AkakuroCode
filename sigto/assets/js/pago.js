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
        onApprove: async function(data, actions) {
            const totalCarrito = await obtenerTotalCarrito(); // Obtenemos el total del servidor para enviar al backend

            return actions.order.capture().then(function(details) {
                alert('Pago completado por ' + details.payer.name.given_name);

                // Asegurando el idpago correcto
                const idPago = 3; // ID de PayPal en la base de datos
                const tipoEntrega = document.querySelector('input[name="metodo_entrega"]:checked').value;
                let idrecibo = null;
                let direccion = null;

                if (tipoEntrega === 'Recibo') {
                    idrecibo = document.querySelector('input[name="ubicacion_pickup"]:checked').value;
                } else if (tipoEntrega === 'Envio') {
                    direccion = {
                        calle: document.getElementById('calle').value,
                        numero: document.getElementById('numero').value,
                        esquina: document.getElementById('esquina').value
                    };
                }

                fetch('/sigto/controllers/CompraController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payerName: details.payer.name.given_name,
                        paymentStatus: details.status,
                        idpago: idPago,
                        tipo_entrega: tipoEntrega,
                        idrecibo: idrecibo,
                        direccion: direccion,
                        total_compra: totalCarrito // Envía el total del carrito
                    })
                }).then(response => response.text()) // Cambia a .text() para ver la respuesta original
                  .then(data => {
                      console.log('Respuesta del servidor:', data);
                      // Luego puedes convertir manualmente la respuesta a JSON si es válida
                      try {
                        const jsonData = JSON.parse(data.trim()); // Elimina espacios al inicio y al final
                          console.log('Orden registrada:', jsonData);
                      } catch (e) {
                          console.error('Error al analizar JSON:', e);
                      }
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
