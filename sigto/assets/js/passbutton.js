function togglePassword() {
    const passwordField = document.getElementById("passw");
    const passwordToggle = document.querySelector(".toggle-password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordToggle.textContent = "🙈"; // Cambia el icono cuando se muestre la contraseña
    } else {
        passwordField.type = "password";
        passwordToggle.textContent = "👁️"; // Cambia el icono cuando se oculte la contraseña
    }
}