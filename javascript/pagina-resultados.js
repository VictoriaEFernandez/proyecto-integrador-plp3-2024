// Función para obtener los parámetros de la URL
function getQueryParams() {
    const params = {};
    window.location.search.substring(1).split("&").forEach(param => {
        const [key, value] = param.split("=");
        params[decodeURIComponent(key)] = decodeURIComponent(value || '');
    });
    return params;
}

// Simulación de datos de alojamientos (lista estática)
const alojamientos = [
    {
        tipo: 'Hotel',
        nombre: 'Refugio Verde',
        ubicacion: 'Verdana',
        descripcionHotel: "Refugio Verde es un hotel eco-friendly ubicado en Verdana. Ofrece habitaciones confortables y una experiencia en contacto con la naturaleza.",
        habitaciones: [
            {
                nombre: 'Habitación Simple',
                capacidad: 1,
                precio: 100,
                descripcion: 'Habitación con cama simple y vista a los jardines.',
            },
            {
                nombre: 'Habitación Doble',
                capacidad: 2,
                precio: 180,
                descripcion: 'Habitación con cama matrimonial, vista al parque y aire acondicionado.',
            },
        ],
    },
    // Otros alojamientos...
];

// Mostrar opciones de habitaciones disponibles
const tarjetasHabitaciones = document.getElementById("tarjetasHabitaciones");
alojamientos.forEach(alojamiento => {
    alojamiento.habitaciones.forEach(habitacion => {
        const tarjeta = document.createElement('div');
        tarjeta.classList.add('tarjeta');
        tarjeta.innerHTML = `
            <h3>${habitacion.nombre}</h3>
            <p>${habitacion.descripcion}</p>
            <p>Capacidad: ${habitacion.capacidad} personas</p>
            <p>Precio por noche: $${habitacion.precio}</p>
            <button class="btn-seleccionar" data-tipo="${alojamiento.tipo}" data-ubicacion="${alojamiento.ubicacion}" data-habitacion="${habitacion.nombre}" data-precio="${habitacion.precio}" data-descripcion-hotel="${alojamiento.descripcionHotel}" data-descripcion-habitacion="${habitacion.descripcion}">Seleccionar</button>
        `;
        tarjetasHabitaciones.appendChild(tarjeta);
    });
});

// Capturar la selección del usuario y mostrar la información del hotel y habitación seleccionada
let habitacionSeleccionada = null;

document.querySelectorAll('.btn-seleccionar').forEach(boton => {
    boton.addEventListener('click', function() {
        habitacionSeleccionada = {
            tipo: this.getAttribute('data-tipo'),
            ubicacion: this.getAttribute('data-ubicacion'),
            habitacion: this.getAttribute('data-habitacion'),
            precio: this.getAttribute('data-precio'),
            descripcionHotel: this.getAttribute('data-descripcion-hotel'),
            descripcionHabitacion: this.getAttribute('data-descripcion-habitacion'),
        };

        // Mostrar la descripción del hotel y de la habitación seleccionada
        document.getElementById('descripcionHotel').innerText = habitacionSeleccionada.descripcionHotel;
        document.getElementById('descripcionHabitacion').innerText = habitacionSeleccionada.descripcionHabitacion;

        alert(`Has seleccionado la ${habitacionSeleccionada.habitacion}`);
    });
});

// Cuando el usuario selecciona una habitación y presiona "Reservar"
document.getElementById("botonReservar").addEventListener("click", function() {
    if (!habitacionSeleccionada) {
        alert("Por favor selecciona una habitación antes de reservar.");
        return;
    }

    const params = getQueryParams();
    const checkin = params.checkin;
    const checkout = params.checkout;

    // Calcular el número de días entre check-in y check-out
    const fechaEntrada = new Date(checkin);
    const fechaSalida = new Date(checkout);
    const diasEstadia = Math.ceil((fechaSalida - fechaEntrada) / (1000 * 60 * 60 * 24)); // Diferencia en días

    // Calcular el monto total a pagar
    const montoTotal = habitacionSeleccionada.precio * diasEstadia;

    // Redirigir al formulario de reserva con los detalles seleccionados
    window.location.href = `reserva.php?tipo=${habitacionSeleccionada.tipo}&ubicacion=${habitacionSeleccionada.ubicacion}&habitacion=${habitacionSeleccionada.habitacion}&checkin=${checkin}&checkout=${checkout}&total=${montoTotal}`;
});


// Filtrar alojamientos según los parámetros ingresados
const alojamientosFiltrados = alojamientos.filter(alojamiento => 
    alojamiento.tipo === tipoSeleccionado && alojamiento.ubicacion === ubicacionSeleccionada
);

// Mostrar el tipo de lugar
document.getElementById("tipoLugar").textContent = tipoSeleccionado;

// Mostrar las habitaciones disponibles
const tarjetasHabitacionesDiv = document.getElementById("tarjetasHabitaciones");
const descripcionHotelP = document.getElementById("descripcionHotel");

if (alojamientosFiltrados.length > 0) {
    // Obtener el primer alojamiento que coincida
    const alojamiento = alojamientosFiltrados[0];
    descripcionHotelP.textContent = alojamiento.descripcionHotel;

    alojamiento.habitaciones.forEach(habitacion => {
        const tarjetaHTML = `
            <div class="tarjeta-habitacion">
                <h4>${habitacion.nombre}</h4>
                <p>Capacidad: ${habitacion.capacidad} Persona(s)</p>
                <p>Precio: $${habitacion.precio} por noche</p>
                <p>Descripción: ${habitacion.descripcion}</p>
                <button class="btn-seleccionar" onclick="seleccionarHabitacion('${habitacion.descripcion}')">Seleccionar</button>
            </div>
        `;
        tarjetasHabitacionesDiv.innerHTML += tarjetaHTML;
    });
} else {
    tarjetasHabitacionesDiv.innerHTML = `<p>No se encontraron alojamientos para los criterios seleccionados.</p>`;
}

// Función para mostrar la descripción de la habitación seleccionada
function seleccionarHabitacion(descripcion) {
    document.getElementById("descripcionHabitacion").textContent = descripcion;
}
