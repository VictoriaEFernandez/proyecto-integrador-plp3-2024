<link rel="icon" href="iconos/flavicon.png" type="image/x-icon">
<body class="ayuda-body">
    <title>Ayuda y Soporte</title>
    <link rel="stylesheet" href="css/estilos-seccionayuda.css">
    <?php include 'cabecera.php'; ?>
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
            <table>
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>¿Cómo puedo modificar mi reserva?</td>
                        <td>Puedes modificar tu reserva desde tu perfil o contactando a nuestro soporte.</td>
                    </tr>
                    <tr>
                        <td>¿Puedo obtener un reembolso?</td>
                        <td>Los reembolsos están sujetos a las políticas de cancelación de cada alojamiento.</td>
                    </tr>
                    <tr>
                        <td>¿Qué hago si tengo problemas con mi reserva?</td>
                        <td>Si tienes problemas, contáctanos a través del formulario o llama a nuestro número de soporte.</td>
                    </tr>
                    <!-- Agrega más preguntas y respuestas aquí -->
                </tbody>
            </table>
        </section>
    </div>
    <script src="javascript/ayuda.js"></script>

</body>


