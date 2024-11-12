document.addEventListener('DOMContentLoaded', function () {
    // Precios
    const precioMinInput = document.getElementById('precio-min');
    const precioMaxInput = document.getElementById('precio-max');
    const precioMinValue = document.getElementById('precio-min-value');
    const precioMaxValue = document.getElementById('precio-max-value');

    // Actualizar los valores de precios mínimo y máximo en tiempo real
    precioMinInput.addEventListener('input', function () {
        precioMinValue.textContent = Number(this.value).toFixed(2);
    });

    precioMaxInput.addEventListener('input', function () {
        precioMaxValue.textContent = Number(this.value).toFixed(2);
    });

    // Obtener el modal y el botón de cierre
    const modal = document.getElementById("modal");
    const closeButton = document.querySelector(".close");

    // Agregar event listeners a los botones "Ver detalles"
    document.querySelectorAll(".boton-ver-detalles").forEach(button => {
        button.addEventListener("click", function() {
            // Obtener el ID del alojamiento del atributo data-id
            const alojamientoId = this.parentElement.getAttribute("data-id");

            // Hacer una solicitud AJAX para obtener los detalles del alojamiento
            fetch(`detalles.php?id=${alojamientoId}`)
                .then(response => response.text())
                .then(data => {
                    // Mostrar los detalles en el modal
                    document.getElementById("modal-content").innerHTML = data;
                    modal.style.display = "block";
                });
        });
    });

    // Agregar event listener al botón de cierre
    closeButton.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Cerrar el modal al hacer clic fuera de él
    window.addEventListener("click", (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
});