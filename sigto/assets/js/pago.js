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
            return actions.order.capture().then(async function(details) {
                alert('Pago completado por ' + details.payer.name.given_name);
        
                try {
                    const response = await fetch('/sigto/controllers/CompraController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'procesarCompra',  
                            orderId: data.orderID,
                            payerName: details.payer.name.given_name,
                            paymentStatus: details.status,
                            total: details.purchase_units[0].amount.value,
                            currency: details.purchase_units[0].amount.currency_code,
                            idpago: 'paypal',
                            tipo_entrega: document.querySelector('input[name="metodo_entrega"]:checked').value,
                            direccion: {
                                calle: document.getElementById('calle').value,
                                numero: document.getElementById('numero').value,
                                esquina: document.getElementById('esquina').value
                            },
                            centroRecibo: document.querySelector('input[name="ubicacion_pickup"]:checked') ? document.querySelector('input[name="ubicacion_pickup"]:checked').value : null
                        })
                    });
        
                    if (!response.ok) {
                        throw new Error("Error en la solicitud al servidor: " + response.status);
                    }
        
                    // Intentar analizar JSON
                    const resultText = await response.text();
                    let result;
                    try {
                        result = JSON.parse(resultText);
                    } catch (jsonError) {
                        console.error("Error en la respuesta JSON:", jsonError);
                        console.error("Respuesta del servidor:", resultText);
                        alert('Error al registrar la orden. Inténtalo de nuevo.');
                        return;
                    }
                    
                    if (result.success) {
                        console.log('Orden registrada exitosamente:', result);
                        window.location.href = "/sigto/views/confirmacionCompra.php";
                    } else {
                        console.error('Error al registrar la orden:', result.message);
                        alert('Error al registrar la orden. Inténtalo de nuevo.');
                    }
                } catch (error) {
                    console.error('Error en la respuesta JSON:', error);
                    alert('Error al registrar la orden. Inténtalo de nuevo.');
                }
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
