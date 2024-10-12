document.getElementById('imagen').addEventListener('change', function(){
    var fileName = this.files[0] ? this.files[0].name : "Ningún archivo seleccionado";
    document.getElementById('file-name').textContent = fileName;
});