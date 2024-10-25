function cambiarEstadoUsuario(idus, estado) {
    if (confirm(`¿Estás seguro de que deseas ${estado === 'si' ? 'dar de alta' : 'dar de baja'} este usuario?`)) {
        fetch(`/sigto/index.php?action=updateStatus`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                idus: idus,
                estado: estado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualiza el botón de alta/baja del usuario sin recargar la página
                location.reload(); // Refresca la página para reflejar el cambio de estado
            } else {
                alert('Error al cambiar el estado del usuario.');
            }
        })
        .catch(error => {
            console.error('Error al cambiar el estado del usuario:', error);
            alert('Hubo un problema al intentar cambiar el estado del usuario.');
        });
    }
}

function cambiarEstadoEmpresa(idemp, estado) {
    if (confirm(`¿Estás seguro de que deseas ${estado === 'si' ? 'dar de alta' : 'dar de baja'} esta empresa?`)) {
        fetch(`/sigto/index.php?action=updateEmpresaStatus`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                idemp: idemp,
                estado: estado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualiza el botón de alta/baja de la empresa sin recargar la página
                location.reload(); // Refresca la página para reflejar el cambio de estado
            } else {
                alert('Error al cambiar el estado de la empresa.');
            }
        })
        .catch(error => {
            console.error('Error al cambiar el estado de la empresa:', error);
            alert('Hubo un problema al intentar cambiar el estado de la empresa.');
        });
    }
}
