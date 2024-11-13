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

 
});
