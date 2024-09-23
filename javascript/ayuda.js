document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.querySelector('.formulario-contacto form');

    formulario.addEventListener('submit', (event) => {
        event.preventDefault(); // Evitar el envío por defecto

        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const mensaje = document.getElementById('mensaje').value.trim();

        let errores = [];

        // Validaciones simples
        if (nombre.length < 3) errores.push("El nombre debe tener al menos 3 caracteres.");
        if (!validateEmail(email)) errores.push("Por favor, ingresa un correo electrónico válido.");
        if (!/^\+?\d{0,13}/.test(telefono)) errores.push("Número de teléfono inválido.");
        if (mensaje.length < 10) errores.push("El mensaje debe tener al menos 10 caracteres.");

        if (errores.length > 0) {
            alert(errores.join("\n")); // Mostrar errores
        } else {
            alert("Formulario enviado con éxito!");
            formulario.reset(); // Limpiar el formulario
            // Aquí puedes agregar el envío real del formulario
        }
    });

    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
});
document.querySelectorAll('.faq tbody tr').forEach((row) => {
    row.addEventListener('click', () => {
        const respuesta = row.querySelector('td:last-child');
        respuesta.classList.toggle('visible');
    });
});
document.querySelectorAll('.consultas-rapidas a').forEach((link) => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const targetId = event.target.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
