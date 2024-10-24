// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los botones de favoritos
    document.querySelectorAll('.btn-favorito').forEach(button => {
        button.addEventListener('click', function() {
            const idus = this.getAttribute('data-idus'); // Obtener el ID del usuario
            const sku = this.getAttribute('data-sku');   // Obtener el SKU del producto
            const imgElement = document.getElementById('favorito-' + sku); // Obtener el elemento de la imagen
            const accion = imgElement.getAttribute('src').includes('favoritos.png') ? 'agregar' : 'quitar'; // Determinar la acción

            // Realizar la petición AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/sigto/controllers/FavoritoController.php?action=actualizarFavorito', true); // Asegurarse de que la acción esté correctamente definida
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) { // Comprobar si la solicitud está completa
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText); // Procesar la respuesta
                            console.log(response); // Mostrar la respuesta en la consola para depurar
                            
                            if (response.success) {
                                // Cambiar la imagen según la acción realizada
                                if (accion === 'agregar') {
                                    imgElement.setAttribute('src', '/sigto/assets/images/favoritos2.png');
                                } else {
                                    imgElement.setAttribute('src', '/sigto/assets/images/favoritos.png');
                                }
                            } else {
                                alert(response.message || 'Error inesperado');
                            }
                        } catch (e) {
                            console.error('Error procesando la respuesta JSON:', e);
                            console.log('Respuesta recibida del servidor:', xhr.responseText); // Mostrar la respuesta original para depurar
                            alert('Error inesperado al procesar la respuesta.');
                        }
                    } else {
                        console.error('Error en la solicitud AJAX. Estado:', xhr.status);
                        alert('Hubo un problema con la solicitud. Intenta nuevamente.');
                    }
                }
            };
            // Enviar los datos al controlador
            xhr.send('idus=' + idus + '&sku=' + sku + '&accion=' + accion);
        });
    });
});
