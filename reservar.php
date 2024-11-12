<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos enviados desde el formulario
    $usuario_id = 1; // Este debería ser el ID del usuario logueado (ejemplo estático)
    $alojamiento_id = $_POST['AlojamientoId'];
    $fecha_checkin = $_POST['checkin'];
    $fecha_checkout = $_POST['checkout'];

    // Obtener los datos del alojamiento seleccionado
    $query_alojamiento = "SELECT * FROM alojamientos WHERE AlojamientoId = ?";
    $stmt_alojamiento = $conn->prepare($query_alojamiento);
    $stmt_alojamiento->bind_param("i", $alojamiento_id);
    $stmt_alojamiento->execute();
    $result_alojamiento = $stmt_alojamiento->get_result();
    $alojamiento = $result_alojamiento->fetch_assoc();

    // Calcular el precio total
    $precio_noche = $alojamiento['Precio']; 

    // Calcular el número de noches
    $fecha_checkin_obj = new DateTime($fecha_checkin);
    $fecha_checkout_obj = new DateTime($fecha_checkout);
    $intervalo = $fecha_checkin_obj->diff($fecha_checkout_obj);
    $numero_noches = $intervalo->days;

    // Calcular el precio total
    $precio_total = $precio_noche * $numero_noches;

    // Insertar los datos de la reserva en la base de datos
    $query = "INSERT INTO reservas (UsuarioID, AlojamientoId, FechaCheckIn, FechaCheckOut, PrecioTotal, FechaRegistro) 
              VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissd", $usuario_id, $alojamiento_id, $fecha_checkin, $fecha_checkout, $precio_total);
    $stmt->execute();

    // Generar el contenido del archivo .txt
    $reserva_txt = "Reserva de Alojamiento\n";
    $reserva_txt .= "=====================\n";
    $reserva_txt .= "Alojamiento: " . $alojamiento['Descripcion'] . "\n";
    $reserva_txt .= "Ubicación: " . $alojamiento['Ubicacion'] . "\n";
    $reserva_txt .= "Capacidad: " . $alojamiento['Capacidad'] . " personas\n";
    $reserva_txt .= "Precio Total: $" . number_format($precio_total, 2) . "\n";
    $reserva_txt .= "Fecha de Check-in: " . $fecha_checkin . "\n";
    $reserva_txt .= "Fecha de Check-out: " . $fecha_checkout . "\n";
    $reserva_txt .= "Fecha de Reserva: " . date('Y-m-d H:i:s') . "\n";

    // Crear el archivo .txt
    file_put_contents("reserva_$usuario_id.txt", $reserva_txt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada</title>
    <link rel="stylesheet" href="css/estilosReserva.css">
</head>
<body>
    <header>
        <h1>Confirmación de Reserva</h1>
    </header>

    <main>
        <div class="reserva-container">
            <h2>Detalles de la Reserva</h2>
            <div class="detalle-reserva">
                <p><strong>Alojamiento:</strong> <?php echo $alojamiento['Descripcion']; ?></p>
                <p><strong>Ubicación:</strong> <?php echo $alojamiento['Ubicacion']; ?></p>
                <p><strong>Capacidad:</strong> <?php echo $alojamiento['Capacidad']; ?> personas</p>
                <p><strong>Precio Total:</strong> $<?php echo number_format($precio_total, 2); ?></p>
                <p><strong>Fecha de Check-in:</strong> <?php echo $fecha_checkin; ?></p>
                <p><strong>Fecha de Check-out:</strong> <?php echo $fecha_checkout; ?></p>
            </div>

            <form action="reserva.php" method="POST">
                <button type="submit" class="btn-descargar">
                    <a href="reserva_<?php echo $usuario_id; ?>.txt" download="reserva_<?php echo $usuario_id; ?>.txt">Descargar Reserva en formato .txt</a>
                </button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Oasis Urbano. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
