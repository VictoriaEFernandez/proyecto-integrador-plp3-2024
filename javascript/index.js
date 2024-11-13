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
document.addEventListener('DOMContentLoaded', function() {
    const formResena = document.getElementById('resena-form');
    const inputNombre = document.getElementById('name');
    const inputResena = document.getElementById('review');
    const selectRating = document.getElementById('rating');

    // Validación del formulario
    formResena.addEventListener('submit', function(e) {
        let isValid = true;
        let mensajeError = '';

        // Validar nombre
        if (inputNombre.value.trim().length < 2) {
            isValid = false;
            mensajeError = 'El nombre debe tener al menos 2 caracteres';
            inputNombre.focus();
        }
        // Validar reseña
        else if (inputResena.value.trim().length < 10) {
            isValid = false;
            mensajeError = 'La reseña debe tener al menos 10 caracteres';
            inputResena.focus();
        }
        // Validar puntuación
        else if (!selectRating.value) {
            isValid = false;
            mensajeError = 'Por favor, selecciona una puntuación';
            selectRating.focus();
        }

        // Si hay errores, prevenir el envío y mostrar mensaje
        if (!isValid) {
            e.preventDefault();
            alert(mensajeError);
        } else {
            // Si todo está bien, asegurarse de que el formulario se envíe a index.php
            formResena.action = 'index.php';
        }
    });

    // Limpiar espacios en blanco
    inputNombre.addEventListener('blur', function() {
        this.value = this.value.trim();
    });

    inputResena.addEventListener('blur', function() {
        this.value = this.value.trim();
    });
});