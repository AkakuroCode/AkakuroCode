document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editForm');

    // Obtener el usuario a editar desde el localStorage
    const userToEdit = JSON.parse(localStorage.getItem('userToEdit'));

    if (userToEdit) {
        // Precargar los datos del usuario en el formulario
        document.getElementById('email').value = userToEdit.email;
        document.getElementById('name').value = userToEdit.name;
        document.getElementById('lastname').value = userToEdit.lastname;
        document.getElementById('ci').value = userToEdit.ci;
        document.getElementById('phone').value = userToEdit.phone;
        document.getElementById('address').value = userToEdit.address;
    }

    editForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const lastname = document.getElementById('lastname').value;
        const ci = document.getElementById('ci').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;

        // Validaciones
        if (!validateEmail(email)) {
            alert('El correo electrónico no cumple con los requisitos');
            return;
        }
        if (!validateName(name)) {
            alert('El nombre no puede estar vacío');
            return;
        }
        if (!validateLastname(lastname)) {
            alert('El apellido no puede estar vacío');
            return;
        }
        if (!validateCI(ci)) {
            alert('El CI debe ser numérico y tener 8 caracteres');
            return;
        }
        if (!validatePhone(phone)) {
            alert('El teléfono debe ser numérico y tener 9 caracteres');
            return;
        }
        if (!validateAddress(address)) {
            alert('La dirección debe tener menos de 50 caracteres');
            return;
        }

        // Actualizar los datos del usuario
        const updatedUser = {
            email: email,
            name: name,
            lastname: lastname,
            ci: ci,
            phone: phone,
            address: address,
            password: userToEdit.password // Mantener la misma contraseña
        };

        // Obtener los usuarios almacenados en localStorage
        const storedUsers = JSON.parse(localStorage.getItem('users')) || [];
        
        // Actualizar el usuario en el array
        const updatedUsers = storedUsers.map(user => user.email === userToEdit.email ? updatedUser : user);

        // Guardar los usuarios actualizados en localStorage
        localStorage.setItem('users', JSON.stringify(updatedUsers));

        alert('Usuario actualizado correctamente');
        window.location.href = 'mainadmin.html'; // Redirigir de nuevo al panel de usuarios
    });

    // Validar el correo electrónico (menor o igual a 50 caracteres)
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email) && email.length <= 50;
    }

    // Validar el nombre (no vacío)
    function validateName(name) {
        return name.trim().length > 0;
    }

    // Validar el apellido (no vacío)
    function validateLastname(lastname) {
        return lastname.trim().length > 0;
    }

    // Validar CI (numérico y 8 caracteres)
    function validateCI(ci) {
        return /^[0-9]{8}$/.test(ci);
    }

    // Validar el teléfono (numérico y 9 caracteres)
    function validatePhone(phone) {
        return /^[0-9]{9}$/.test(phone);
    }

    // Validar la dirección (menor o igual a 50 caracteres)
    function validateAddress(address) {
        return address.length <= 50;
    }
});
