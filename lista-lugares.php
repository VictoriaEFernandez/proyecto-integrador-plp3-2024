<?php include 'cabecera.php'; ?>
<body class="alojamientos">
    <title>Nuestros Alojamientos</title>
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
                    <option value="apartamento">Departamento</option>
                    <option value="casa">Casa</option>
                </select>
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
                    <h2>Hotel</h2>
                    <h3>Refugio Verde</h3>
                    <p>Precio: Desde $250</p>
                    <a href="tipos-Lugares/hotel1.php" class="boton">Ver Hotel</a>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar2.jpeg" alt="Alojamiento 2">
                    <h2>Casa</h2>
                    <h3>Luz de Luna</h3>
                    <p>Precio: Desde $130</p>
                    <button class="boton">Ver Casa</button>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar3.jpeg" alt="Alojamiento 3">
                    <h2>Departamento</h2>
                    <h3>Descanso Placentero</h3>
                    <p>Precio: Desde $100</p>
                    <button class="boton">Ver Departamento</button>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar4.jpeg" alt="Alojamiento 4">
                    <h2>Casa</h2>
                    <h3>El mirador estelar</h3>
                    <p>Precio: Desde $150</p>
                    <button class="boton">Ver casa</button>
                </div>
                <div class="tarjeta">
                    <img src="img/lugar5.jpeg" alt="Alojamiento 5">
                    <h2>Casa</h2>
                    <h3>El refugio feliz</h3>
                    <p>Precio: Desde $200</p>
                    <button class="boton">Ver Casa</button>
                </div>
            </div>
        </section>
    </main>

    <footer class="pie-alojamientos">
        <p>&copy; 2024 Oasis Urbano. Todos los derechos reservados.</p>
    </footer>
    <script src="javascript/listaLugares.js"></script>
</body>
