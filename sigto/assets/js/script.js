document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const lastname = document.getElementById('lastname').value;
        const ci = document.getElementById('ci').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;
        const password = document.getElementById('registerPassword').value;

        // Validaciones
        if (!validateEmail(email)) {
            document.getElementById('registerError').textContent = 'El correo electrónico no cumple con los requisitos';
            return;
        }
        if (!validateName(name)) {
            document.getElementById('registerError').textContent = 'El nombre no puede estar vacío';
            return;
        }
        if (!validateLastname(lastname)) {
            document.getElementById('registerError').textContent = 'El apellido no puede estar vacío';
            return;
        }
        if (!validateCI(ci)) {
            document.getElementById('registerError').textContent = 'El CI debe ser numérico y tener hasta 8 caracteres';
            return;
        }
        if (!validatePhone(phone)) {
            document.getElementById('registerError').textContent = 'El teléfono debe ser numérico';
            return;
        }
        if (!validateAddress(address)) {
            document.getElementById('registerError').textContent = 'La dirección debe tener menos de 50 caracteres';
            return;
        }
        if (!validatePassword(password)) {
            document.getElementById('registerError').textContent = 'La contraseña debe contener al menos una mayúscula, una minúscula y un número';
            return;
        }

        // Comprobar si el correo electrónico ya está registrado
        const storedUsers = JSON.parse(localStorage.getItem('users')) || [];
        if (storedUsers.some(user => user.email === email)) {
            document.getElementById('registerError').textContent = 'El correo electrónico ya está registrado';
            return;
        }

        // Guardar el nuevo usuario
        const user = {
            email: email,
            name: name,
            lastname: lastname,
            ci: ci,
            phone: phone,
            address: address,
            password: password
        };

        storedUsers.push(user);
        localStorage.setItem('users', JSON.stringify(storedUsers));

        alert('Registro exitoso');
        window.location.href = 'login.html';
    });

    // Validar el correo electrónico (menor o igual a 50 caracteres)
    function validateEmail(email) {
        return email.length <= 50;
    }

    // Validar el nombre (no vacío)
    function validateName(name) {
        return name.trim().length > 0;
    }

    // Validar el apellido (no vacío)
    function validateLastname(lastname) {
        return lastname.trim().length > 0;
    }

    // Validar CI (numérico y hasta 8 caracteres)
    function validateCI(ci) {
        return /^[0-9]{1,8}$/.test(ci);
    }

    // Validar el teléfono (numérico)
    function validatePhone(phone) {
        return /^[0-9]+$/.test(phone);
    }

    // Validar la dirección (menor o igual a 50 caracteres)
    function validateAddress(address) {
        return address.length <= 50;
    }

    // Validar la contraseña (al menos una mayúscula, una minúscula y un número)
    function validatePassword(password) {
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        return hasUpperCase && hasLowerCase && hasNumber;
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Obtener los usuarios almacenados en localStorage
        const storedUsers = JSON.parse(localStorage.getItem('users')) || [];

        // Buscar el usuario con el correo electrónico proporcionado
        const user = storedUsers.find(user => user.email === username);

        // Validar credenciales
        if (user && user.password === password) {
            alert('Login exitoso');

            // Redirigir según el tipo de usuario
            if (user.email === 'torrescristian661@gmail.com'){
                window.location.href = '../pages/mainadmin.html'; // Redirigir a la página de administrador
            }
            if (user.email === 'notegui410@gmail.com'){
                window.location.href = '../pages/maincliente.html'; // Redirigir a la página de usuario
            }else {
                window.location.href = '../pages/paginaprincipal.html'; // Redirigir a la página de vendedor
            }
        } else {
            document.getElementById('loginError').textContent = 'Usuario o contraseña incorrectos';
        }
    });
});