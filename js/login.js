function login() {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    
    if (!email || !password) {
        Swal.fire("Error", "Por favor, complete todos los campos", "error");
        return;
    }
    
    // Simulación de autenticación (remplazar con backend real)
    if (email === "admin@finanzas.com" && password === "admin123") {
        Swal.fire("Éxito", "Inicio de sesión exitoso", "success").then(() => {
            window.location.href = "index.html";
        });
    } else {
        Swal.fire("Error", "Credenciales incorrectas", "error");
    }
}