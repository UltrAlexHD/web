document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('accountForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar que se envíe el formulario automáticamente

        // Realizar la petición AJAX para enviar los datos del formulario
        const formData = new FormData(document.getElementById('accountForm'));
        fetch('registro_cuentas.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Mostrar mensaje de éxito o error
            const messageElement = document.getElementById('message');
            if (data.status === 'success') {
                messageElement.style.color = 'green';
            } else {
                messageElement.style.color = 'red';
            }
            messageElement.innerHTML = data.message;
        })
        .catch(error => {
            console.error('Error:', error);
            const messageElement = document.getElementById('message');
            messageElement.innerHTML = 'Hubo un error al procesar la solicitud.';
            messageElement.style.color = 'red';
        });
    });
});
