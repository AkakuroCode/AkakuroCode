document.addEventListener('DOMContentLoaded', function() {
    // Obtener el contenedor donde se mostrarán los usuarios
    const userContainer = document.querySelector('.user-list');

    // Obtener los usuarios almacenados en localStorage
    const storedUsers = JSON.parse(localStorage.getItem('users')) || [];

    // Filtrar los usuarios para excluir a "torrescristian661@gmail.com"
    const filteredUsers = storedUsers.filter(user => user.email !== 'torrescristian661@gmail.com');

    // Recorrer los usuarios y agregarlos dinámicamente al contenedor
    filteredUsers.forEach((user, index) => {
        const userItem = document.createElement('div');
        userItem.classList.add('user-item');

        const userEmail = document.createElement('p');
        userEmail.textContent = user.email; // Mostrar correo electrónico del usuario
        userItem.appendChild(userEmail);

        const userActions = document.createElement('div');
        userActions.classList.add('user-actions');

        const editButton = document.createElement('button');
        editButton.classList.add('edit-btn');
        editButton.textContent = 'Editar';
        editButton.addEventListener('click', () => handleEditUser(user));

        const deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-btn');
        deleteButton.textContent = 'Borrar';
        deleteButton.addEventListener('click', () => handleDeleteUser(user, userItem));

        userActions.appendChild(editButton);
        userActions.appendChild(deleteButton);

        userItem.appendChild(userActions);
        userContainer.appendChild(userItem);
    });
});

// Función para borrar un usuario
function handleDeleteUser(user, userItem) {
    const storedUsers = JSON.parse(localStorage.getItem('users')) || [];
    if (confirm(`¿Estás seguro que deseas eliminar al usuario con correo: ${user.email}?`)) {
        // Eliminar usuario del localStorage
        const updatedUsers = storedUsers.filter(u => u.email !== user.email);
        localStorage.setItem('users', JSON.stringify(updatedUsers));

        // Remover el elemento del DOM
        userItem.remove();

        alert(`Usuario con correo ${user.email} eliminado correctamente`);
    }
}

// Función para editar un usuario
function handleEditUser(user) {
    // Guardar los datos del usuario en el localStorage
    localStorage.setItem('userToEdit', JSON.stringify(user));
    // Redirigir a la página de edición
    window.location.href = '../pages/edit.html';
}
