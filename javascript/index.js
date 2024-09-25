const botonesAlojamiento = document.querySelectorAll('.alojamiento');
let tipoSeleccionado = '';

// Manejar el clic en los botones de alojamiento
botonesAlojamiento.forEach(boton => {
    boton.addEventListener('click', function() {
        // Desmarcar todos los botones
        botonesAlojamiento.forEach(btn => btn.classList.remove('active'));

        // Marcar el botón seleccionado
        this.classList.add('active');
        tipoSeleccionado = this.innerText; // Guardar el tipo seleccionado
    });
});

// Manejar el envío del formulario
document.getElementById('form-busqueda').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario

    const ubicacion = document.getElementById('ubicacion').value;
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;

    if (!tipoSeleccionado) {
        alert("Por favor, selecciona un tipo de alojamiento.");
        return;
    }

    // Redirigir a la página de resultados con los parámetros necesarios
    window.location.href = `pagina-resultados.php?tipo=${encodeURIComponent(tipoSeleccionado)}&ubicacion=${encodeURIComponent(ubicacion)}&checkin=${encodeURIComponent(checkin)}&checkout=${encodeURIComponent(checkout)}`;
});


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
