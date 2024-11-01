function togglePassword() {
    const passwordField = document.getElementById("passw");
    const passwordToggle = document.querySelector(".toggle-password i");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordToggle.classList.remove("bi-eye-fill");
        passwordToggle.classList.add("bi-eye-slash-fill"); // Cambia a un ícono de ojo cerrado
    } else {
        passwordField.type = "password";
        passwordToggle.classList.remove("bi-eye-slash-fill");
        passwordToggle.classList.add("bi-eye-fill"); // Cambia al ícono de ojo abierto
    }
}
