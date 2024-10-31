<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/sigto/assets/css/login.css">
    <title>Crear Empresa</title>
</head>
<body>
    <div class="box">
        <h2>Crear Empresa</h2>
        
        <!-- Formulario de Crear Empresa -->
        <form id="createCompanyForm" method="POST" action="/sigto/index.php?action=createCompany">
            <label for="companyName">Nombre de la Empresa:</label>
            <input type="text" id="companyName" name="companyName" class="form-control" required>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" class="form-control" required>

            <label for="phone">Teléfono:</label>
            <input type="text" id="phone" name="phone" class="form-control" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>

            <!-- Campo de Contraseña con botón de mostrar/ocultar -->
            <label for="passw">Contraseña:</label>
            <div class="input-group mb-3">
                <input type="password" id="passw" name="passw" class="form-control" required>
                <button class="btn-show-password" type="button" onclick="togglePassword()">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </div>

            <label for="bankAccount">Cuenta de Banco:</label>
            <input type="text" id="bankAccount" name="bankAccount" class="form-control" required>

            <!-- Botón para Crear Empresa -->
            <button type="submit" class="btn btn-primary btn-block">Crear Empresa</button>
            <button id="volver" onclick="window.location.href='/sigto/views/mainvisitante.php';">Volver al Inicio</button>

        </form>
        

    </div>

    <!-- JavaScript para alternar visibilidad de la contraseña y cambiar el ícono -->
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("passw");
            const eyeIcon = document.querySelector(".btn-show-password i");
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("bi-eye-fill");
                eyeIcon.classList.add("bi-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye-fill");
            }
        }
    </script>
</body>
</html>
