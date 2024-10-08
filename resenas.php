<body>
    <link rel="icon" href="iconos/flavicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/estilo-index">
    <!-- Sección para dejar reseñas -->
    <section class="seccion-resenas">
        <h2>Deja tu Reseña</h2>
        <form id="reseña-form">
            <div class="formulario-resen">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="formulario-resen">
                <label for="review">Reseña:</label>
                <textarea id="review" name="review" rows="4" required></textarea>
            </div>
            <div class="formulario-resen">
                <label for="rating">Puntuación:</label>
                <select id="rating" name="rating" required>
                    <option value="5">5 - Excelente</option>
                    <option value="4">4 - Muy Bueno</option>
                    <option value="3">3 - Bueno</option>
                    <option value="2">2 - Regular</option>
                    <option value="1">1 - Malo</option>
                </select>
            </div>
            <button type="button" id="enviar-resena" class="boton-resenas">Enviar Reseña</button>
        </form>
        <div id="mensaje" style="display: none;"></div>
    </section>
</body>
