document.getElementById("formulario-filtro").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío del formulario
    
    const tipoSeleccionado = document.getElementById("tipo").value;
    const precioMaximo = parseInt(document.getElementById("precio").value) || Infinity; // Valor máximo o Infinity si está vacío
    const tarjetas = document.querySelectorAll(".tarjeta"); // Selecciona todas las tarjetas de alojamiento

    tarjetas.forEach(tarjeta => {
        const precioTexto = tarjeta.querySelector("p").innerText; // Obtiene el texto del precio
        const precio = parseInt(precioTexto.replace(/[^0-9]/g, '')); // Extrae el valor numérico del texto

        // Obtiene el tipo del alojamiento
        const tipoAlojamiento = tarjeta.querySelector("h2").innerText.toLowerCase();

        // Verifica si el tipo seleccionado es el adecuado y si el precio está dentro del rango
        const cumpleTipo = tipoSeleccionado === "" || tipoAlojamiento === tipoSeleccionado.toLowerCase();
        const cumplePrecio = precio <= precioMaximo;

        // Muestra u oculta la tarjeta según los criterios de filtrado
        if (cumpleTipo && cumplePrecio) {
            tarjeta.style.display = "block"; // Muestra la tarjeta
        } else {
            tarjeta.style.display = "none"; // Oculta la tarjeta
        }
    });
});
