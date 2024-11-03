document.addEventListener('DOMContentLoaded', function () {
    const updateButtons = document.querySelectorAll('.btn-actualizar');
    const deleteButtons = document.querySelectorAll('.btn-eliminar');

    updateButtons.forEach(button => {
        button.addEventListener('click', function () {
            updateQuantity(button);
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            deleteItem(button);
        });
    });
});

async function updateQuantity(button) {
    const form = button.closest('.update-form');
    const cantidadInput = form.querySelector('.cantidad-input');
    const cantidad = cantidadInput.value;
    const sku = form.dataset.sku;
    const idus = form.dataset.idus;

    try {
        const response = await fetch('/sigto/index.php?action=update_quantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'idus': idus,
                'sku': sku,
                'cantidad': cantidad
            })
        });

        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }

        const rawResponse = await response.text(); // Verifica la respuesta cruda
        console.log(rawResponse); // Imprime la respuesta cruda

        const result = JSON.parse(rawResponse); // Parsear manualmente a JSON

        if (result.status === 'success') {
            const cantidadInput = form.querySelector('.cantidad-input');
            cantidadInput.value = cantidad; // Actualiza el valor en el input
            const cantidadElement = document.getElementById(`cantidad-${sku}`);
            if (cantidadElement) {
                cantidadElement.textContent = `Cantidad: ${cantidad}`;
            }
            // Actualizar elementos en la vista con el formato adecuado
            const itemTotalElement = document.getElementById(`item-total-${sku}`);
            if (itemTotalElement) {
                itemTotalElement.textContent = `${result.subtotal}`; 
            }

            const totalElement = document.getElementById('total');
            if (totalElement) {
                totalElement.textContent = `${result.totalCarrito}`; 
            }
        } else {
            alert(result.message || 'Error al actualizar la cantidad');
        }

    } catch (error) {
        console.error('Error al actualizar la cantidad:', error);
        alert('Hubo un problema al actualizar la cantidad.');
    }
}




// Función para eliminar un producto del carrito
function deleteItem(button) {
    const form = button.closest('.delete-form');
    const sku = form.dataset.sku;
    const idus = form.dataset.idus;

    fetch(`/sigto/index?action=delete_from_cart`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `sku=${sku}&idus=${idus}` // No se envía cantidad
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const itemElement = button.closest('.list-group-item');
            itemElement.remove();
            updateTotal();
            if (document.querySelectorAll('.list-group-item').length === 0) {
                const colMd4Element = document.querySelector('.col-md-4');
                const mainContainer = document.querySelector('main.container');
            
                if (colMd4Element) {
                    colMd4Element.style.display = 'none';
                }
                if (mainContainer) {
                    mainContainer.innerHTML = '<p class="text-center mt-4">No hay productos en el carrito.</p>';
                }
            }
            
        } else {
            alert('Error al eliminar el producto del carrito.');
        }
    })
    .catch(error => {
        console.error('Error al eliminar el producto:', error);
    });
}





function updateTotal() {
    let total = 0;
    const itemTotals = document.querySelectorAll('.item-total');

    if (itemTotals.length === 0) {
        // Si no hay elementos, establecer el total a "0.00"
        totalCarrito = 0;

        const totalElement = document.getElementById('total');
        if (totalElement) {
            totalElement.textContent = `${totalCarrito.toFixed(2)}`;
        }

        const totalInputElement = document.getElementById('total-carrito');
        if (totalInputElement) {
            totalInputElement.value = totalCarrito.toFixed(2);
        }
    } else {
        itemTotals.forEach(item => {
            const itemValue = parseFloat(item.textContent.replace('US$', ''));
            if (!isNaN(itemValue)) {
                total += itemValue; // Sumar solo si es un número válido
            }
        });

        totalCarrito = total;

        const totalElement = document.getElementById('total');
        if (totalElement) {
            totalElement.textContent = `US$${totalCarrito.toFixed(2)}`;
        }

        const totalInputElement = document.getElementById('total-carrito');
        if (totalInputElement) {
            totalInputElement.value = totalCarrito.toFixed(2);
        }
    }
}
