<?php
// Incluir la conexión a la base de datos
include 'conexion.php';
include 'cabecera.php';

// Aseguramos que la sesión esté iniciada
session_start(); 

// Inicializar variables
$alojamiento = null;
$precio_total = 0;
$reserva_txt_path = "";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alojamiento_id = $_POST['AlojamientoId'];
    $fecha_checkin = $_POST['checkin'];
    $fecha_checkout = $_POST['checkout'];

    // Obtener datos del alojamiento
    $query_alojamiento = "SELECT * FROM alojamientos WHERE AlojamientoId = ?";
    $stmt_alojamiento = $conn->prepare($query_alojamiento);
    $stmt_alojamiento->bind_param("i", $alojamiento_id);
    $stmt_alojamiento->execute();
    $result_alojamiento = $stmt_alojamiento->get_result();
    $alojamiento = $result_alojamiento->fetch_assoc();

    $precio_noche = $alojamiento['Precio'];

    // Calcular el número de noches
    $fecha_checkin_obj = new DateTime($fecha_checkin);
    $fecha_checkout_obj = new DateTime($fecha_checkout);
    $intervalo = $fecha_checkin_obj->diff($fecha_checkout_obj);
    $numero_noches = $intervalo->days;

    // Calcular el precio total
    $precio_total = $precio_noche * $numero_noches;

    if (isset($_POST['metodo_pago'])) {
        $metodo_pago = $_POST['metodo_pago'];

        // Insertar la reserva en la base de datos
        $query = "INSERT INTO reservas (UsuarioId, AlojamientoId, FechaCheckIn, FechaCheckOut, PrecioTotal, FechaRegistro, MetodoPago) 
                  VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iissds", $usuarioId, $alojamiento_id, $fecha_checkin, $fecha_checkout, $precio_total, $metodo_pago);
        if ($stmt->execute()) {
            // Generar contenido del archivo .txt
            $reserva_txt_path = "reserva_" . time() . ".txt";
            $reserva_txt = "Reserva de Alojamiento\n";
            $reserva_txt .= "=====================\n";
            $reserva_txt .= "Alojamiento: " . htmlspecialchars($alojamiento['Descripcion']) . "\n";
            $reserva_txt .= "Ubicación: " . htmlspecialchars($alojamiento['Ubicacion']) . "\n";
            $reserva_txt .= "Capacidad: " . htmlspecialchars($alojamiento['Capacidad']) . " personas\n";
            $reserva_txt .= "Precio Total: $" . number_format($precio_total, 2) . "\n";
            $reserva_txt .= "Fecha de Check-in: " . htmlspecialchars($fecha_checkin) . "\n";
            $reserva_txt .= "Fecha de Check-out: " . htmlspecialchars($fecha_checkout) . "\n";
            $reserva_txt .= "Método de Pago: " . ucfirst(htmlspecialchars($metodo_pago)) . "\n";
            $reserva_txt .= "Fecha de Reserva: " . date('Y-m-d H:i:s') . "\n";

            file_put_contents($reserva_txt_path, $reserva_txt);

            // Forzar descarga del archivo
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($reserva_txt_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($reserva_txt_path));

            readfile($reserva_txt_path);
            exit();
        }
    }
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
            <?php if ($alojamiento): ?>
                <p><strong>Alojamiento:</strong> <?php echo htmlspecialchars($alojamiento['Descripcion']); ?></p>
                <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($alojamiento['Ubicacion']); ?></p>
                <p><strong>Capacidad:</strong> <?php echo htmlspecialchars($alojamiento['Capacidad']); ?> personas</p>
                <p><strong>Precio Total:</strong> $<?php echo number_format($precio_total, 2); ?></p>
                <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($fecha_checkin); ?></p>
                <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($fecha_checkout); ?></p>

                <h3>Método de Pago</h3>
                <form action="reservar.php" method="POST">
                    <input type="hidden" name="AlojamientoId" value="<?php echo htmlspecialchars($alojamiento_id); ?>">
                    <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($fecha_checkin); ?>">
                    <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($fecha_checkout); ?>">
                    <select name="metodo_pago" required>
                        <option value="">Seleccione un método</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="debito">Débito</option>
                    </select>
                    <button type="submit">Generar TXT</button>
                </form>
            <?php else: ?>
                <p>No se encontraron detalles del alojamiento.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Oasis Urbano. Todos los derechos reservados.</p>
</footer>

<?php
$conn->close();
?>
</body>
</html>
