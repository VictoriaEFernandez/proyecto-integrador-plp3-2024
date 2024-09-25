<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Alojamiento</title>
    <link rel="stylesheet" href="css/estilo-paginaResultados.css">
    <link rel="icon" href="iconos/flavicon.png" type="image/x-icon">

</head>
<body>
    <main class="resultados-container">
        <!-- Habitaciones disponibles -->
        <section class="habitaciones-disponibles">
            <h2>Habitaciones Disponibles</h2>
            <div class="tarjetas-habitaciones" id="tarjetasHabitaciones">
                <!-- Aquí se cargarán dinámicamente las tarjetas de habitaciones -->
            </div>
        </section>

        <!-- Sección para más información del hotel -->
        <section class="ver-mas-info">
            <h3>Ver más info del hotel</h3>
            <p id="descripcionHotel">Aquí aparecerá la descripción del hotel seleccionado.</p>
        </section>

        <!-- Descripción de la habitación seleccionada -->
        <section class="descripcion-habitacion">
            <h3>Descripción de la Habitación Seleccionada</h3>
            <p id="descripcionHabitacion">Aquí aparecerá la descripción de la habitación seleccionada.</p>
        </section>

        <!-- Botón de Reservar -->
        <section class="reservar">
            <button id="botonReservar" class="btn-reservar">Reservar</button>
        </section>
    </main>

    <!-- El archivo JS cargará dinámicamente los datos -->
    <script src="javascript/pagina-resultados.js"></script>
</body>
</html>
