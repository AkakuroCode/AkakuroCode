document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todos los botones de "Actualizar" en el carrito
    const updateButtons = document.querySelectorAll('.btn-secondary');

    updateButtons.forEach(button => {
        button.addEventListener('click', function () {
            updateQuantity(button);
        });
    });
});

// Función para actualizar la cantidad de un producto en el carrito
function updateQuantity(button) {
    const form = button.closest('.update-form');
    const sku = form.dataset.sku;
    const idus = form.dataset.idus;
    const cantidad = form.querySelector('.cantidad-input').value;

    fetch(`?action=update_quantity`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `sku=${sku}&idus=${idus}&cantidad=${cantidad}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar el total del artículo visualmente
            const itemTotalElement = form.closest('.list-group-item').querySelector('.item-total');
            itemTotalElement.textContent = data.newSubtotal.toFixed(2);

            // Actualizar el total del carrito
            updateTotal();
        } else {
            alert('Error al actualizar la cantidad.');
        }
    })
    .catch(error => {
        console.error('Error al actualizar la cantidad:', error);
    });
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
        total += parseFloat(item.textContent);
    });

    document.getElementById('total').textContent = total.toFixed(2);
}
