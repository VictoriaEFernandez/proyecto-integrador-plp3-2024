document.addEventListener("DOMContentLoaded", function() {
    const formularioFiltro = document.getElementById("formulario-filtro");
    const tarjetas = document.querySelectorAll(".tarjeta");

    formularioFiltro.addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar que se recargue la página

        const tipo = document.getElementById("tipo").value.toLowerCase();
        const ubicacion = document.getElementById("ubicacion").value.toLowerCase();
        const precioMaximo = parseFloat(document.getElementById("precio").value);

        tarjetas.forEach(tarjeta => {
            const tarjetaTipo = tarjeta.querySelector("h2").textContent.toLowerCase();
            const tarjetaNombre = tarjeta.querySelector("h3").textContent.toLowerCase();
            const tarjetaPrecio = parseFloat(tarjeta.querySelector("p").textContent.replace(/[^0-9.-]+/g,""));

            const tipoCoincide = tipo === "" || tarjetaTipo === tipo;
            const ubicacionCoincide = ubicacion === "" || tarjetaNombre.includes(ubicacion);
            const precioCoincide = isNaN(precioMaximo) || tarjetaPrecio <= precioMaximo;

            if (tipoCoincide && ubicacionCoincide && precioCoincide) {
                tarjeta.style.display = "block"; // Mostrar tarjeta
            } else {
                tarjeta.style.display = "none"; // Ocultar tarjeta
            }
        });
    });
});
