<body class="bodyreserva">
    <title>Formulario de Reserva</title>
    <?php include 'cabecera.php'; ?>
    <link rel="stylesheet" href="estilos-reservas.css"> 
    <div class="contenedor-reserva">
        <h1>Formulario de Reserva</h1>
        
        <!-- Formulario de Datos del Cliente -->
        <section class="form-section">
            <h2>Datos del Cliente</h2>
            <form>
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </form>
        </section>

        <!-- Medio de Pago -->
        <section class="formulario-reserva">
            <h2>Medio de Pago</h2>
            <form>
                <label for="medio-pago">Selecciona tu Medio de Pago:</label>
                <select id="medio-pago" name="medio-pago" required>
                    <option value="tarjeta">Tarjeta de Crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="transferencia">Transferencia Bancaria</option>
                    <option value="Efectivo">Efectivo</option>
                </select>
            </form>
        </section>

        <!-- Listado de Productos -->
        <section class="form-section">
            <h2>Listado de Productos</h2>
            <p><strong>Alojamiento Reservado:</strong></p>
            <p>Nombre del Alojamiento: Hotel Oasis</p>
            <p>Fecha de Entrada: 01/12/2024</p>
            <p>Fecha de Salida: 05/12/2024</p>
            <p>Detalles: Habitación doble con vista al mar.</p>
        </section>

        <!-- Botón para Confirmar la Reserva -->
        <section class="form-section">
            <button type="submit">Confirmar Reserva</button>
        </section>
    </div>
</body>
</html>
