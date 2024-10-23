function showSuggestions(query) {
    if (query.length == 0) {
        document.getElementById("suggestions").innerHTML = "";
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("suggestions").innerHTML = this.responseText;
            document.getElementById("suggestions").style.display = "block";
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
