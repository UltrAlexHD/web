document.addEventListener('DOMContentLoaded', function() {
    // Obtener el formulario, el div para mostrar el mensaje de registro y el botón de inicio
    var registroForm = document.getElementById('registroForm');
    var mensajeRegistro = document.getElementById('mensajeRegistro');
    var btnInicio = document.getElementById('btnInicio');

    // Añadir evento de envío del formulario
    registroForm.addEventListener('submit', function(event) {
        // Prevenir el envío del formulario por defecto
        event.preventDefault();

        // Realizar una solicitud AJAX al archivo PHP
        var formData = new FormData(registroForm);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'procesar_registro_admin.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Mostrar el mensaje de registro exitoso
                mensajeRegistro.textContent = xhr.responseText;
                mensajeRegistro.style.color = 'green'; // Color verde para el mensaje de éxito
                mensajeRegistro.style.display = 'block'; // Mostrar el mensaje
            } else {
                // En caso de error, mostrar el mensaje de error
                mensajeRegistro.textContent = 'Error al procesar la solicitud';
                mensajeRegistro.style.color = 'red'; // Color rojo para el mensaje de error
                mensajeRegistro.style.display = 'block'; // Mostrar el mensaje
            }
        };
        xhr.onerror = function() {
            // En caso de error de red, mostrar el mensaje de error
            mensajeRegistro.textContent = 'Error de red al procesar la solicitud';
            mensajeRegistro.style.color = 'red'; // Color rojo para el mensaje de error
            mensajeRegistro.style.display = 'block'; // Mostrar el mensaje
        };
        xhr.send(formData);
    });

    // Agregar evento click al botón de inicio
    btnInicio.addEventListener('click', function() {
        // Redirigir a la página de inicio
        window.location.href = 'index.html';
    });
});
