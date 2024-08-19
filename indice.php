<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oasis Urbano</title>
</head>
<!-- Cabecera-->
<body>
    <?php include 'cabecera.php'; ?>
</body>
<br>
<!--Inicial-->
<body>
    <main>
        <section class="inicial" >
            <header class="inicial-header">    
                <h1>Oasis Urbano</h1>
                <h2>Explora tu lugar para hospedarte</h2>
            </header>
            <section class="inicial-content">
                <div class="buttons">
                    <button type="button">Cabanas</button>
                    <button type="button">Hotel</button>
                    <button type="button">Departamentos</button>
                </div>
                <form class="busqueda">
                    <fieldset>
                        <legend>Buscar Alojamiento</legend>
                        <label for="ubicacion">Ubicacion</label>
                        <input type="text" id="ubicacion" placeholder="Ingresa Ubicacion">
                        
                        <label for="checkin">Fecha de Entrada</label>
                        <input type="date" id="checkin">
                        
                        <label for="checkout ">Fecha de Salida</label>
                        <input type="date" id="checkout">
                        
                        <label for="huespedes">Huespedes</label>
                        <input type="number" id="huespedes">
                        <button type="submit">Buscar</button>
                    </fieldset>
                </form>
            </section>
        </section>
    </main>
</body>
<br>
<body>
    <section class="servicios">
        <h2>Servicios que Ofrecemos</h2>
        <ul>
            <li>Tranquilidad</li>
            <li>Seguridad</li>
            <li>Comodidad</li>
            <li>Accesibilidad</li>
        </ul>
    </section>
</body>
<br>
<body>
    <section>
        <h2>Galería de Imágenes</h2>
        <div>
            <img src="img/img1.jpeg" alt="Imagen 1" width="200" height="150">
            <img src="img/img2.jpeg" alt="Imagen 2" width="200" height="150">
            <img src="img/img3.jpeg" alt="Imagen 3" width="200" height="150">
            <img src="img/img4.jpeg" alt="Imagen 4" width="200" height="150">
        </div>
    </section>
</body>
<br>
<!--Pie de Pagina-->
<body>
    <footer>
        <p>&copy; 2024 Oasis Urbano. Todos los derechos reervados </p>
    </footer>
</body>
</html>