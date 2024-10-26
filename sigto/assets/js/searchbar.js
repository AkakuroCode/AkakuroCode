function showSuggestions(query) {
    const suggestions = document.getElementById("suggestions");

    if (query.length === 0) {
        suggestions.innerHTML = "";
        suggestions.style.display = "none"; // Oculta el contenedor cuando no hay texto en la búsqueda
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log("Respuesta del servidor:", this.responseText);
            suggestions.innerHTML = this.responseText;

            // Muestra las sugerencias si hay contenido, oculta si está vacío
            if (this.responseText.trim() !== "") {
                suggestions.style.display = "block";
            } else {
                suggestions.style.display = "none";
            }
        }
    };

    xhr.open("GET", "/sigto/models/buscarProductos.php?query=" + encodeURIComponent(query), true);
    xhr.send();
}

// Nueva función para manejar el clic en las sugerencias
function submitSearch(producto) {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-words');
    
    // Actualiza el valor del campo de búsqueda con el producto seleccionado
    searchInput.value = producto;

    // Envía el formulario para redirigir al catálogo con el producto seleccionado
    searchForm.submit();
}
