<?php
session_start(); // Iniciar sesión

// Mostrar el mensaje si está presente en la URL (cuando el usuario hace clic en salir)
if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'debe_iniciar_sesion') {
    echo '<p style="color: red; font-weight: bold;">PARA HACER RESERVAS TIENES QUE ESTAR LOGEADO</p>';
}

// Verificar si la sesión está iniciada (si el usuario no está logueado, redirigir al login)
if (!isset($_SESSION['nombre'])) {
    $usuarioLogueado = false; // Usuario no está logueado
    $mensajeLogin = "Para realizar búsquedas y reservas debes iniciar sesión.";
} else {
    $usuarioLogueado = true; // Usuario está logueado
    $nombreUsuario = $_SESSION['nombre'];  // Accede al nombre del usuario desde la sesión
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar si el formulario fue enviado y obtener los valores de la búsqueda
if (isset($_POST['ubicacion']) && isset($_POST['checkin']) && isset($_POST['checkout']) && $usuarioLogueado) {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    
    // Consultar los alojamientos disponibles para la búsqueda
    $sql = "SELECT a.AlojamientoId, a.Descripcion, a.Ubicacion, a.Precio, a.Capacidad, a.Foto
            FROM alojamientos a
            WHERE a.Ubicacion LIKE ? AND a.FechaRegistro <= ? AND a.FechaRegistro >= ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $ubicacion, $checkin, $checkout);
    $stmt->execute();
    $result = $stmt->get_result();

    $alojamientosDisponibles = [];
    while ($row = $result->fetch_assoc()) {
        $alojamientosDisponibles[] = $row;
    }
}
// Consulta para obtener las imágenes de la tabla Alojamiento
$sql = "SELECT Foto_blob FROM alojamientos";
$result = $conn->query($sql);

$imagenes = [];
if ($result->num_rows > 0) {
    // Guardar las imágenes en el array
    while ($row = $result->fetch_assoc()) {
        // Convertir la imagen BLOB en base64
        $foto_base64 = base64_encode($row['Foto_blob']);
        $imagenes[] = 'data:image/jpeg;base64,' . $foto_base64; // Asumimos que la imagen es JPEG
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oasis Urbano</title>
    <link rel="stylesheet" href="css/estilo-index.css">

    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Dosis:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Dosis:wght@200..800&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="icon" href="iconos/flavicon.png" type="image/x-icon">
</head>
<body class="principal-body">
    <!-- Cabecera -->
    <?php include 'cabecera.php'; ?>

    <!-- Bienvenida al usuario -->
    <?php if ($usuarioLogueado): ?>
        <section class="bienvenida">
            <h1>¡Bienvenido!</h1>
            <p>Puedes hacer tus reservas desde esta página. Explora nuestras opciones de alojamiento.</p>
            <!-- Botón de salir -->
            <a href="logout.php" class="btn-salir">Salir</a>
        </section>
    <?php endif; ?>

    <!-- Inicial -->
    <main>
    <section class="inicial">
        <header class="inicial-header">    
            <h1>Oasis Urbano</h1>
            <h2>Explora tu lugar para hospedarte</h2>
        </header>

        <!-- Mostrar mensaje si no está logueado -->
        <?php if (!$usuarioLogueado): ?>
            <p style="color: red; font-weight: bold;"><?php echo $mensajeLogin; ?></p>
        <?php endif; ?>

        <form id="form-busqueda" action="buscar_alojamientos.php" method="POST">
        <section class="inicial-content">
            <fieldset>
                <label for="checkin">Fecha de Entrada</label>
                <input type="date" id="checkin" name="checkin" 
                <?php echo !$usuarioLogueado ? 'disabled' : ''; ?> required>

                <label for="checkout">Fecha de Salida</label>
                <input type="date" id="checkout" name="checkout" 
                <?php echo !$usuarioLogueado ? 'disabled' : ''; ?> required>

                <button type="submit" class="boton" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>Buscar</button>
            </fieldset>
        </section>
        </form>

    </section>
    </main>

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
        <div class="container mt-5">
        <div class="galeria-images row">
            <?php if (empty($imagenes)) { ?>
                <p>No hay imágenes disponibles.</p>
            <?php } else {
                // Mostrar las imágenes obtenidas desde la base de datos
                foreach ($imagenes as $imagen) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <img src="<?php echo $imagen; ?>" alt="Imagen de Alojamiento" class="img-fluid rounded">
                    </div>
                    <?php
                }
            } ?>
        </div>
    </div>
        <?php include 'resenas.php'; ?>
    </section>
</main>

<!-- Pie de Página -->
<footer class="footer">
    <p>&copy; 2024 Oasis Urbano. Todos los derechos reservados.</p>
</footer>
<script>
    // Inyectar la variable PHP en un atributo de un elemento HTML
    document.documentElement.setAttribute('data-usuario-logueado', <?php echo isset($_SESSION['nombre']) ? 'true' : 'false'; ?>);
</script>

<script src="javascript/index.js"></script>
</body>
</html>
