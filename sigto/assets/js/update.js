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
    const sku = button.closest('.delete-form').dataset.sku;
    const idus = button.closest('.delete-form').dataset.idus;

    fetch(`?action=delete_from_cart`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `sku=${sku}&idus=${idus}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Eliminar el elemento de la lista visualmente
            const itemElement = button.closest('.list-group-item');
            itemElement.remove();

            // Actualizar el total en el resumen de compra
            updateTotal();

            // Verificar si quedan productos en el carrito
            if (document.querySelectorAll('.list-group-item').length === 0) {
                // Ocultar el resumen de compra
                document.querySelector('.col-md-4').style.display = 'none';

                // Mostrar mensaje de carrito vacío
                document.querySelector('main.container').innerHTML = '<p class="text-center mt-4">No hay productos en el carrito.</p>';
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
    document.querySelectorAll('.item-total').forEach(item => {
        total += parseFloat(item.textContent.replace('US$', '')); // Elimina "US$" antes de convertir a número.
    });

    totalCarrito = total; // Actualiza la variable global totalCarrito
    document.getElementById('total').textContent = `${totalCarrito.toFixed(2)}`;
    document.getElementById('total-carrito').value = totalCarrito.toFixed(2); // Actualiza el input oculto
}
