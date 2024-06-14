// Función para actualizar la hora en formato 12 horas con AM/PM
function actualizarHora() {
    const ahora = new Date();
    let horas = ahora.getHours();
    const minutos = String(ahora.getMinutes()).padStart(2, '0');
    const segundos = String(ahora.getSeconds()).padStart(2, '0');
    const ampm = horas >= 12 ? 'PM' : 'AM';

    horas = horas % 12;
    horas = horas ? horas : 12; // La hora '0' debe ser '12'

    const horaFormateada = `La hora actualmente es ${horas}:${minutos}:${segundos} ${ampm}`;

    document.getElementById('hora').textContent = horaFormateada;
}

// Actualiza la hora cada segundo
setInterval(actualizarHora, 1000);

// Llamada inicial para mostrar la hora inmediatamente
actualizarHora();

// Manejar el envío del formulario
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío tradicional del formulario

    const formData = new FormData(this);

    fetch('verificacion.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            window.location.href = 'index.html'; // Redirigir a la página principal
        } else {
            document.getElementById('error').textContent = data;
            document.getElementById('error').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
