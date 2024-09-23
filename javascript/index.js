document.querySelectorAll('.alojamiento').forEach(button => {
    button.addEventListener('click', function() {
        // Quitar la clase active de todos los botones
        document.querySelectorAll('.alojamiento').forEach(btn => btn.classList.remove('active'));
        
        // Añadir la clase active al botón clickeado
        this.classList.add('active');
    });
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
document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.galeria-images img');
    let currentIndex = 0;

    // Mostrar la primera imagen
    images[currentIndex].style.display = 'block';

    const showImage = (index) => {
        images.forEach((img, i) => {
            img.style.display = (i === index) ? 'block' : 'none';
        });
    };

    const nextImage = () => {
        currentIndex = (currentIndex + 1) % images.length; // Volver al inicio
        showImage(currentIndex);
    };

    const prevImage = () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length; // Volver al final
        showImage(currentIndex);
    };

    document.getElementById('next').addEventListener('click', nextImage);
    document.getElementById('prev').addEventListener('click', prevImage);
});
//Galeeria de imagenes 
