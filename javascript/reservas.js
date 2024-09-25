document.getElementById('confirmar-reserva').addEventListener('click', function(event) {
    // Obtener los valores de los campos
    const nombre = document.getElementById('nombre').value;
    const direccion = document.getElementById('direccion').value;
    const telefono = document.getElementById('telefono').value;
    const email = document.getElementById('email').value;
    const medioPago = document.getElementById('medio-pago').value;

    // Variable para manejar los errores
    let errores = [];

    // Validar campos obligatorios
    if (nombre.trim() === '') errores.push("El nombre completo es obligatorio.");
    if (direccion.trim() === '') errores.push("La dirección es obligatoria.");
    if (telefono.trim() === '' || !/^\d{7,15}$/.test(telefono)) errores.push("El teléfono debe contener entre 7 y 15 dígitos.");
    if (email.trim() === '' || !/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(email)) errores.push("El e-mail es inválido.");

    // Mostrar errores o enviar el formulario
    if (errores.length > 0) {
        alert("Error en el formulario:\n" + errores.join("\n"));
    } else {
        alert("Formulario enviado correctamente.");
        // Aquí puedes hacer la lógica para enviar el formulario, como un fetch o un submit
        document.getElementById('reserva-form').submit(); // Envía el formulario si no hay errores
    }
});

// Función para obtener los parámetros de la URL
function getQueryParams() {
    const params = {};
    window.location.search.substring(1).split("&").forEach(param => {
        const [key, value] = param.split("=");
        params[decodeURIComponent(key)] = decodeURIComponent(value || '');
    });
    return params;
}

// Obtener los datos de la URL
const params = getQueryParams();
const tipoAlojamiento = params.tipo;
const ubicacion = params.ubicacion;
const habitacion = params.habitacion;
const fechaEntrada = params.checkin;
const fechaSalida = params.checkout;
const montoTotal = params.total;

// Mostrar los detalles en la sección de "Listado de Productos"
document.getElementById('ubicacion').textContent = ubicacion;
document.getElementById('tipoAlojamiento').textContent = tipoAlojamiento;
document.getElementById('habitacion').textContent = habitacion;
document.getElementById('fechaEntrada').textContent = fechaEntrada;
document.getElementById('fechaSalida').textContent = fechaSalida;
document.getElementById('montoTotal').textContent = montoTotal;

