document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita que se recargue la página
    
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    
    // Aquí puedes agregar tu lógica de autenticación
    // Por ejemplo, verificar las credenciales con una base de datos o con algún servicio de autenticación
    
    // Supongamos que la autenticación es exitosa
    if (username === "usuario" && password === "contraseña") {
        // Redireccionar a la página principal
        window.location.href = "floreria.html";
    } else {
        alert("Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo.");
    }
});


