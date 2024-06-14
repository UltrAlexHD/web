document.addEventListener('DOMContentLoaded', function() {
    // Obtener la hora actual
    var hora = new Date().getHours();
    var mensaje = "";

    // Determinar el mensaje según la hora
    if (hora < 12) {
        mensaje = "Hola, buenos días. ¿Qué puedo hacer por ti hoy?";
    } else if (hora < 18) {
        mensaje = "Hola, buenas tardes. ¿Qué puedo hacer por ti hoy?";
    } else {
        mensaje = "Hola, buenas noches. ¿Qué puedo hacer por ti hoy?";
    }

    // Mostrar el mensaje en el content-bar
    document.getElementById("mensaje").innerText = mensaje;

    // Cambiar el título de la ventana cuando cambia de pestaña
    let originalTitle = document.title;
    window.addEventListener('blur', function() {
        document.title = 'Hey sigo abierto...';
    });
    window.addEventListener('focus', function() {
        document.title = originalTitle;
    });
});
