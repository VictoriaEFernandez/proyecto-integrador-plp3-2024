<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oasis Urbano</title>
    <link rel="stylesheet" href="estilos-index.css">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Dosis:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Dosis:wght@200..800&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>
<body class="principal-body">
    <!-- Cabecera -->
    <?php include 'cabecera.php'; ?>

    <!-- Inicial -->
    <main>
        <section class="inicial">
            <header class="inicial-header">    
                <h1>Oasis Urbano</h1>
                <h2>Explora tu lugar para hospedarte</h2>
            </header>
            <section class="inicial-content">
                <div class="inicial-buttons">
                    <button type="button">Cabañas</button>
                    <button type="button">Hotel</button>
                    <button type="button">Departamentos</button>
                </div>
                <form class="inicial-busqueda">
                    <fieldset>
                        <legend>Buscar Alojamiento</legend>
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" id="ubicacion" placeholder="Ingresa Ubicación">
                        
                        <label for="checkin">Fecha de Entrada</label>
                        <input type="date" id="checkin">
                        
                        <label for="checkout">Fecha de Salida</label>
                        <input type="date" id="checkout">
                        
                        <label for="huespedes">Huéspedes</label>
                        <input type="number" id="huespedes">
                        <button type="submit">Buscar</button>
                    </fieldset>
                </form>
            </section>
        </section>

        <!-- Sección de Servicios -->
        <section class="servicios">
            <h2>Servicios que Ofrecemos</h2>
            <div class="servicio">
                <h3>Tranquilidad</h3>
                <p>Disfruta de un ambiente relajante y sin preocupaciones durante tu estadía.</p>
            </div>
            <div class="servicio">
                <h3>Seguridad</h3>
                <p>Contamos con medidas de seguridad para garantizar tu bienestar.</p>
            </div>
            <div class="servicio">
                <h3>Comodidad</h3>
                <p>Confort y comodidad en todas nuestras instalaciones para tu satisfacción.</p>
            </div>
            <div class="servicio">
                <h3>Accesibilidad</h3>
                <p>Acceso fácil y conveniente para todos nuestros huéspedes.</p>
            </div>
        </section>

        <!-- Galería de Imágenes -->
        <section class="galeria">
            <h2>Galería de Imágenes</h2>
            <div class="galeria-images">
                <img src="img/img1.jpeg" alt="Imagen 1">
                <img src="img/img2.jpeg" alt="Imagen 2">
                <img src="img/img3.jpeg" alt="Imagen 3">
                <img src="img/img4.jpeg" alt="Imagen 4">
            </div>
            <?php include 'resenas.php'; ?>
        </section>
    </main>

    <!-- Pie de Página -->
    <footer class="footer">
        <p>&copy; 2024 Oasis Urbano. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
