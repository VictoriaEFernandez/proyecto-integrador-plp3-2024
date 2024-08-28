<body class="alojamientos">
    <title>Nuestros Alojamientos</title>
    <?php include 'cabecera.php'; ?>
    <link rel="stylesheet" href="css/estilos-alojamientos.css">
    <link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <main>
        <section class="seccion-filtros">
            <h2>Filtrar Alojamientos</h2>
            <form id="formulario-filtro">
                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo">
                    <option value="">Todos</option>
                    <option value="hotel">Hotel</option>
                    <option value="apartamento">Apartamento</option>
                    <option value="casa">Casa</option>
                </select>

                <label for="ubicacion">Ubicación:</label>
                <input type="text" id="ubicacion" name="ubicacion" placeholder="Ciudad o zona">

                <label for="precio">Precio máximo:</label>
                <input type="number" id="precio" name="precio" placeholder="$">

                <button type="submit" class="boton-filtro">Buscar</button>
            </form>
        </section>

        <section class="lista-alojamientos">
            <h2>Alojamientos Disponibles</h2>
            <div class="tarjetas">
                <div class="tarjeta">
                    <img src="img/lugar1.jpeg" alt="Alojamiento 1">
                    <h3>Nombre del Alojamiento 1</h3>
                    <p>Precio: $176 por noche</p>
                    <p>Descripción breve del alojamiento.</p>
                    <a href="detalle.php" class="boton">Ver más detalles</a>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar2.jpeg" alt="Alojamiento 2">
                    <h3>Nombre del Alojamiento 2</h3>
                    <p>Precio: $177 por noche</p>
                    <p>Descripción breve del alojamiento.</p>
                    <a href="#" class="boton">Ver más detalles</a>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar3.jpeg" alt="Alojamiento 3">
                    <h3>Nombre del Alojamiento 3</h3>
                    <p>Precio: $190 por noche</p>
                    <p>Descripción breve del alojamiento.</p>
                    <a href="#" class="boton">Ver más detalles</a>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar4.jpeg" alt="Alojamiento 4">
                    <h3>Nombre del Alojamiento 4</h3>
                    <p>Precio: $200 por noche</p>
                    <p>Descripción breve del alojamiento.</p>
                    <a href="#" class="boton">Ver más detalles</a>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar5.jpeg" alt="Alojamiento 5">
                    <h3>Nombre del Alojamiento 5</h3>
                    <p>Precio: $250 por noche</p>
                    <p>Descripción breve del alojamiento.</p>
                    <a href="#" class="boton">Ver más detalles</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="pie-alojamientos">
        <p>&copy; 2024 Tu Empresa. Todos los derechos reservados.</p>
    </footer>
</body>
