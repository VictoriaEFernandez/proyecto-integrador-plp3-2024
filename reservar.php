<?php
// Aseguramos que la sesión esté iniciada
session_start(); 

// Incluir la conexión a la base de datos
include 'conexion.php';

// Inicializar variables
$alojamiento = null;
$precio_total = 0;
$reserva_txt_path = "";
$cantidad_personas = 0;
$error_mensaje = "";
$fecha_checkin = "";
$fecha_checkout = "";
$alojamiento_id = "";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alojamiento_id = $_POST['AlojamientoId'];
    $fecha_checkin = $_POST['checkin'];
    $fecha_checkout = $_POST['checkout'];
    $cantidad_personas = isset($_POST['cantidad_personas']) ? intval($_POST['cantidad_personas']) : 0;

    // Obtener datos del alojamiento
    $query_alojamiento = "SELECT * FROM alojamientos WHERE AlojamientoId = ?";
    $stmt_alojamiento = $conn->prepare($query_alojamiento);
    $stmt_alojamiento->bind_param("i", $alojamiento_id);
    $stmt_alojamiento->execute();
    $result_alojamiento = $stmt_alojamiento->get_result();
    $alojamiento = $result_alojamiento->fetch_assoc();

    if ($alojamiento) {
        $precio_noche = $alojamiento['Precio'];
        $capacidad_maxima = $alojamiento['Capacidad'];

        // Verificar que la cantidad de personas no exceda la capacidad
        if ($cantidad_personas > $capacidad_maxima) {
            $error_mensaje = "La cantidad de personas excede la capacidad máxima del alojamiento.";
        } else {
            // Calcular el número de noches
            $fecha_checkin_obj = new DateTime($fecha_checkin);
            $fecha_checkout_obj = new DateTime($fecha_checkout);
            $intervalo = $fecha_checkin_obj->diff($fecha_checkout_obj);
            $numero_noches = $intervalo->days;

            // Calcular el precio total
            $precio_total = $precio_noche * $numero_noches * $cantidad_personas;

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
                    $contenido_txt = "Reserva de Alojamiento\n";
                    $contenido_txt .= "=====================\n";
                    $contenido_txt .= "Alojamiento: " . $alojamiento['Descripcion'] . "\n";
                    $contenido_txt .= "Ubicación: " . $alojamiento['Ubicacion'] . "\n";
                    $contenido_txt .= "Cantidad de Personas: " . $cantidad_personas . "\n";
                    $contenido_txt .= "Capacidad Máxima: " . $alojamiento['Capacidad'] . " personas\n";
                    $contenido_txt .= "Precio por Noche por Persona: $" . number_format($precio_noche, 2) . "\n";
                    $contenido_txt .= "Número de Noches: " . $numero_noches . "\n";
                    $contenido_txt .= "Precio Total: $" . number_format($precio_total, 2) . "\n";
                    $contenido_txt .= "Fecha de Check-in: " . $fecha_checkin . "\n";
                    $contenido_txt .= "Fecha de Check-out: " . $fecha_checkout . "\n";
                    $contenido_txt .= "Método de Pago: " . ucfirst($metodo_pago) . "\n";
                    $contenido_txt .= "Fecha de Reserva: " . date('Y-m-d H:i:s') . "\n";

                    // Guardar el archivo
                    file_put_contents($reserva_txt_path, $contenido_txt);

                    // Cerrar todos los statements antes de enviar headers
                    $stmt->close();
                    $stmt_alojamiento->close();

                    // Establecer headers y enviar archivo
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($reserva_txt_path) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($reserva_txt_path));
                    readfile($reserva_txt_path);
                    
                    // Cerrar la conexión y salir
                    $conn->close();
                    exit();
                }
            }
        }
    }
}

// Incluir la cabecera solo si no estamos generando el TXT
include 'cabecera.php';
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
        <?php if ($error_mensaje): ?>
            <div class="error-mensaje">
                <?php echo htmlspecialchars($error_mensaje); ?>
            </div>
        <?php endif; ?>
        <div class="detalle-reserva">
            <?php if ($alojamiento): ?>
                <p><strong>Alojamiento:</strong> <?php echo htmlspecialchars($alojamiento['Descripcion']); ?></p>
                <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($alojamiento['Ubicacion']); ?></p>
                <p><strong>Capacidad Máxima:</strong> <?php echo htmlspecialchars($alojamiento['Capacidad']); ?> personas</p>
                <p><strong>Precio por Noche por Persona:</strong> $<?php echo number_format($alojamiento['Precio'], 2); ?></p>
                <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($fecha_checkin); ?></p>
                <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($fecha_checkout); ?></p>

                <form action="reservar.php" method="POST">
                    <input type="hidden" name="AlojamientoId" value="<?php echo htmlspecialchars($alojamiento_id); ?>">
                    <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($fecha_checkin); ?>">
                    <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($fecha_checkout); ?>">
                    
                    <div class="form-group">
                        <label for="cantidad_personas">Cantidad de Personas:</label>
                        <input type="number" name="cantidad_personas" id="cantidad_personas" 
                               min="1" max="<?php echo htmlspecialchars($alojamiento['Capacidad']); ?>" 
                               value="<?php echo $cantidad_personas; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="metodo_pago">Método de Pago:</label>
                        <select name="metodo_pago" id="metodo_pago" required>
                            <option value="">Seleccione un método</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="debito">Débito</option>
                        </select>
                    </div>

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

</body>
</html>