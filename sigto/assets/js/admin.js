function eliminarUsuario(idus) {
    if (confirm('¿Estás seguro de que deseas dar de baja este usuario?')) {
        fetch(`/sigto/index.php?action=delete&idus=${idus}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `idus=${idus}` // Se envía el ID del usuario en el cuerpo de la solicitud
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remover la fila de la tabla correspondiente al usuario eliminado
                const row = document.querySelector(`tr[data-id="${idus}"]`);
                if (row) {
                    row.remove(); // Remover la fila visualmente
                }
                alert('Usuario dado de baja correctamente');
            } else {
                alert('Error al dar de baja el usuario');
            }
        })
        .catch(error => {
            console.error('Error al dar de baja el usuario:', error);
            alert('Hubo un problema al intentar dar de baja el usuario.');
        });
    }
}
