document.querySelectorAll('.btn-favorito').forEach(button => {
    button.addEventListener('click', function() {
        const idus = this.getAttribute('data-idus');
        const sku = this.getAttribute('data-sku');
        const imgElement = document.getElementById('favorito-' + sku);

        // Determina la acción (agregar o quitar favorito) según el color actual del corazón
        const accion = imgElement.getAttribute('src').includes('favoritos.png') ? 'agregar' : 'quitar';

        // Enviar la petición AJAX al controlador
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/sigto/controllers/UsuarioController.php?action=actualizarFavorito', true);  // Ruta correcta al controlador
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    if (xhr.responseText.trim() !== '') {  // Asegúrate de que no sea una respuesta vacía
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            // Cambia el color del corazón según la acción realizada
                            if (accion === 'agregar') {
                                imgElement.setAttribute('src', '/sigto/assets/images/favoritos2.png');
                            } else {
                                imgElement.setAttribute('src', '/sigto/assets/images/favoritos.png');
                            }
                        } else {
                            console.error('Error al actualizar favorito: ' + response.message);
                        }
                    } else {
                        console.error('Respuesta vacía del servidor');
                    }
                } catch (e) {
                    console.error('Error al procesar la respuesta AJAX', e);
                }
            }
        };
        xhr.send('idus=' + idus + '&sku=' + sku + '&accion=' + accion);
    });
});
