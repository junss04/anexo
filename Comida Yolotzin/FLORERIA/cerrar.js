document.getElementById("logout").addEventListener("click", function(event) {
    event.preventDefault(); // Evitar que el enlace funcione normalmente
    
    // Aquí puedes agregar la lógica para cerrar la sesión, como eliminar las credenciales almacenadas
    
    // Por ejemplo, redireccionar a la página de inicio de sesión
    window.location.href = "inicio.html";
});
