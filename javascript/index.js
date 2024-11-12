// Obtener el valor de 'data-usuario-logueado' desde el HTML
const usuarioLogueado = document.documentElement.getAttribute('data-usuario-logueado') === 'true';

// Si el usuario no está logueado, evitar el envío del formulario
if (!usuarioLogueado) {
    // Si el usuario no está logueado, mostrar mensaje de advertencia y evitar envío del formulario
    document.getElementById('form-busqueda').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario
        alert("Para realizar búsquedas y reservas, debes iniciar sesión.");
    });
} else {
    // Si el usuario está logueado, permitir la búsqueda
    document.getElementById('form-busqueda').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario

        // Obtener los valores de los campos de búsqueda
        const checkin = document.getElementById('checkin').value;
        const checkout = document.getElementById('checkout').value;

        // Validar que todos los campos estén completos
        if (!checkin || !checkout) {
            alert("Por favor, completa todos los campos.");
            return; // No enviar el formulario si algún campo está vacío
        }

        // Si todo está correcto, redirigir a la página de resultados de búsqueda sin la ubicación
        window.location.href = `buscar_alojamientos.php?checkin=${encodeURIComponent(checkin)}&checkout=${encodeURIComponent(checkout)}`;
    });
}

// Función para enviar la reseña
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reseña-form');
    const enviarResenaBtn = document.getElementById('enviar-resena');
    const mensajeDiv = document.getElementById('mensaje');

    enviarResenaBtn.addEventListener('click', (event) => {
        // Evitar el envío del formulario
        event.preventDefault();

        // Obtener los valores de los campos
        const nombre = form.name.value.trim();
        const reseña = form.review.value.trim();
        const puntuación = form.rating.value;

        // Validaciones simples
        if (nombre && reseña) {
            // Aquí para enviar los datos al servidor

            // Mostrar un mensaje de éxito
            mensajeDiv.style.display = 'block';
            mensajeDiv.innerText = '¡Reseña enviada con éxito!';
            mensajeDiv.style.color = 'green';

            // Limpiar el formulario
            form.reset();
        } else {
            // Mostrar un mensaje de error
            mensajeDiv.style.display = 'block';
            mensajeDiv.innerText = 'Por favor, completa todos los campos.';
            mensajeDiv.style.color = 'red';
        }
    });
});
