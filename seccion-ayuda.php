<body class="ayuda-body">
    <title>Ayuda y Soporte</title>
    <?php include 'cabecera.php'; ?>
    <link rel="stylesheet" href="estilos-ayuda.css">
    <div class="contenedor-ayuda">
        <h1>Ayuda y Soporte</h1>

        <!-- Formulario de contacto -->
        <section class="formulario-contacto">
            <h2>¿Necesitas ayuda? Contáctanos</h2>
            <form action="#" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>

                <label for="mensaje">Describe tu problema o pregunta:</label>
                <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </section>

        <!-- Información de contacto -->
        <section class="informacion-contacto">
            <h2>Información de Contacto</h2>
            <p>Correo electrónico: soporte@tuempresa.com</p>
            <p>Teléfono: +123 456 7890</p>
        </section>

        <!-- Consultas rápidas -->
        <section class="consultas-rapidas">
            <h2>Consultas Rápidas</h2>
            <ul>
                <li><a href="#">¿Cómo realizo una reserva?</a></li>
                <li><a href="#">¿Cómo puedo cancelar mi reserva?</a></li>
                <li><a href="#">¿Qué métodos de pago aceptan?</a></li>
                <li><a href="#">¿Cómo contacto con el servicio al cliente?</a></li>
            </ul>
        </section>

        <!-- Sección de preguntas frecuentes -->
        <section class="faq">
            <h2>Preguntas Frecuentes (FAQ)</h2>
            <div>
                <h3>¿Cómo puedo modificar mi reserva?</h3>
                <p>Puedes modificar tu reserva desde tu perfil o contactando a nuestro soporte.</p>
            </div>
            <div>
                <h3>¿Puedo obtener un reembolso?</h3>
                <p>Los reembolsos están sujetos a las políticas de cancelación de cada alojamiento.</p>
            </div>
            <div>
                <h3>¿Qué hago si tengo problemas con mi reserva?</h3>
                <p>Si tienes problemas, contáctanos a través del formulario o llama a nuestro número de soporte.</p>
            </div>
        </section>
    </div>

</body>
</html>
