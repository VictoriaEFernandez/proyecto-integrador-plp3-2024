<?php include 'cabecera.php'; ?>

<body class="bodyreserva">
    <title>Formulario de Reserva</title>
    <link rel="stylesheet" href="css/estilo-reserva.css">
    <div class="contenedor-reserva">
        <h1>Formulario de Reserva</h1>

        <!-- Formulario de Datos del Cliente -->
        <section class="form-section">
            <h2>Datos del Cliente</h2>
            <form id="reserva-form">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="medio-pago">Selecciona tu Medio de Pago:</label>
                <select id="medio-pago" name="medio-pago" required>
                    <option value="transferencia">Transferencia Bancaria</option>
                    <option value="efectivo">Efectivo</option>
                </select>

                <!-- Botón para Confirmar la Reserva -->
                <section class="form-section">
                    <button type="button" id="confirmar-reserva">Confirmar Reserva</button>
                </section>
            </form>
        </section>

        <!-- Listado de Productos -->
        <section class="form-section">
            <h2>Detalle de la Reserva</h2>
            <ul id="detalle-reserva">
                <li>Ubicación: <span id="ubicacion"></span></li>
                <li>Tipo de Alojamiento: <span id="tipoAlojamiento"></span></li>
                <li>Habitación: <span id="habitacion"></span></li>
                <li>Fecha de Entrada: <span id="fechaEntrada"></span></li>
                <li>Fecha de Salida: <span id="fechaSalida"></span></li>
                <li>Total a Pagar: $<span id="montoTotal"></span></li>
            </ul>
        </section>
    </div>

    <script src="javascript/reservas.js"></script>
</body>
