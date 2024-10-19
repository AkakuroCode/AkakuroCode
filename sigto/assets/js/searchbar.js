function showSuggestions(query) {
    if (query.length === 0) {
        document.getElementById("suggestions").innerHTML = "";
        document.getElementById("suggestions").style.display = "none"; // Ocultar si no hay sugerencias
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("suggestions").innerHTML = this.responseText;
            document.getElementById("suggestions").style.display = "block"; // Mostrar sugerencias
        }
    };

    xhr.open("GET", "/sigto/buscarProductos.php?query=" + encodeURIComponent(query), true);
    xhr.send();
}

// Función para redirigir al catálogo cuando se hace clic en una sugerencia
function redirectToCatalog(productName) {
    window.location.href = "/sigto/views/catalogo.php?query=" + encodeURIComponent(productName);
}
