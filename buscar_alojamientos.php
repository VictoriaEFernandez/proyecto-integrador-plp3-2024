<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar si se recibieron parámetros de búsqueda
$fecha_checkin = $_GET['checkin'] ?? '';
$fecha_checkout = $_GET['checkout'] ?? '';
$tipo_alojamiento = $_GET['tipo_alojamiento'] ?? '';

// Verificar que todos los parámetros necesarios estén presentes
if (empty($fecha_checkin) || empty($fecha_checkout)) {
    echo "<p>Por favor, completa todos los campos para realizar la búsqueda.</p>";
    exit; // Detener la ejecución si falta algún parámetro
}

// Construir la consulta SQL con filtros
$query = "SELECT a.AlojamientoId, a.Descripcion, a.Ubicacion, a.Precio, a.Capacidad, a.Foto_blob
          FROM alojamientos a
          LEFT JOIN reservas r ON a.AlojamientoId = r.AlojamientoId
          AND (r.FechaCheckIn BETWEEN ? AND ? OR r.FechaCheckOut BETWEEN ? AND ?)
          WHERE r.ReservaId IS NULL OR (r.FechaCheckIn > ? OR r.FechaCheckOut < ?)";

// Si se selecciona tipo de alojamiento, agregar a la consulta
if (!empty($tipo_alojamiento)) {
    $query .= " AND a.TipoAlojamientoId = ?";
}

// Preparar la consulta SQL
$stmt = $conn->prepare($query);

// Crear el array de parámetros
$params = [$fecha_checkin, $fecha_checkout, $fecha_checkin, $fecha_checkout, $fecha_checkin, $fecha_checkout];

// Si tipo de alojamiento está presente, agregarlo a los parámetros
if (!empty($tipo_alojamiento)) {
    $params[] = $tipo_alojamiento;
}

// Crear el tipo de datos para bind_param basado en el número de parámetros
$types = str_repeat('s', count($params));  // 's' por cada parámetro

// Vincular los parámetros con la consulta preparada
$stmt->bind_param($types, ...$params);

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda de Alojamientos</title>
    <link rel="stylesheet" href="css/estilos-BuscarAlojamiento.css">
</head>
<body>

    <header>
        <div class="header-container">
            <h1>Resultados de Búsqueda de Alojamientos</h1>
        </div>
    </header>

    <main>
        <?php if ($result->num_rows > 0): ?>
            <h2>Alojamientos Disponibles</h2>
            <div class="alojamientos-container">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="alojamiento-card">
                        <div class="alojamiento-img">
                            <?php if ($row['Foto_blob']): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Foto_blob']); ?>" alt="Foto Alojamiento">
                            <?php else: ?>
                                <p>No hay foto disponible</p>
                            <?php endif; ?>
                        </div>
                        <div class="alojamiento-info">
                            <p><strong>Descripción:</strong> <?php echo $row['Descripcion']; ?></p>
                            <p><strong>Ubicación:</strong> <?php echo $row['Ubicacion']; ?></p>
                            <p><strong>Precio:</strong> $<?php echo number_format($row['Precio'], 2); ?></p>
                            <p><strong>Capacidad:</strong> <?php echo $row['Capacidad']; ?> personas</p>
                            <form action="reservar.php" method="POST">
                                <input type="hidden" name="AlojamientoId" value="<?php echo $row['AlojamientoId']; ?>">
                                <input type="hidden" name="checkin" value="<?php echo $fecha_checkin; ?>">
                                <input type="hidden" name="checkout" value="<?php echo $fecha_checkout; ?>">
                                <button type="submit" class="btn-reservar">Reservar</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-results">No hay alojamientos disponibles para las fechas seleccionadas.</p>
        <?php endif; ?>
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

