document.addEventListener('DOMContentLoaded', function () {
    const updateButtons = document.querySelectorAll('.btn-secondary');

    updateButtons.forEach(button => {
        button.addEventListener('click', function () {
            updateQuantity(button);
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
        const response = await fetch('index.php?action=update_quantity', {
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

        const result = await response.json();

        if (result.status === 'success') {
            // Verificar y actualizar el subtotal del producto
            const itemTotalElement = form.closest('.list-group-item').querySelector('.item-total');
            if (itemTotalElement) {
                itemTotalElement.textContent = `${result.subtotal}`;
            }

            // Verificar y actualizar la cantidad mostrada
            const cantidadElement = document.getElementById(`cantidad-${sku}`);
            if (cantidadElement) {
                cantidadElement.textContent = `Cantidad: ${cantidad}`;
            }

            // Verificar y actualizar el total del carrito
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
            button.closest('.list-group-item').remove();

            // Actualizar el total en el resumen de compra
            updateTotal();
        } else {
            alert('Error al eliminar el producto del carrito.');
        }
    })
    .catch(error => {
        console.error('Error al eliminar el producto:', error);
    });
}

// Función para actualizar el total después de la eliminación
function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-total').forEach(item => {
        total += parseFloat(item.textContent.replace('', '')); // Eliminar "US$" antes de convertir a número.
    });

    document.getElementById('total').textContent = `${total.toFixed(2)}`; // Mostrar el total actualizado con "US$".
}
