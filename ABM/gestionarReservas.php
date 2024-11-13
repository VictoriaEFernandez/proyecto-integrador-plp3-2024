<?php
include_once('../conexion.php');
include('inicio.php'); 
// Verificar si se ha recibido una solicitud de modificación o eliminación
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Eliminar una reserva
    if ($action == 'eliminar' && isset($_GET['id'])) {
        $reservaId = $_GET['id'];

        $sqlDelete = "DELETE FROM reservas WHERE ReservaId = ?";
        $stmt = $conn->prepare($sqlDelete);
        $stmt->bind_param("i", $reservaId);
        
        if ($stmt->execute()) {
            $mensaje = "Reserva eliminada correctamente.";
        } else {
            $mensaje = "Error al eliminar la reserva.";
        }
    }
    // Modificar una reserva
    elseif ($action == 'modificar' && isset($_GET['id'])) {
        $reservaId = $_GET['id'];

        // Obtener los datos de la reserva a modificar
        $sql = "SELECT * FROM reservas WHERE ReservaId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $reservaId);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $reserva = $resultado->fetch_assoc();
        } else {
            $mensaje = "Reserva no encontrada.";
        }

        // Actualizar la reserva si se envía el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fechaCheckIn = $_POST['fechaCheckIn'];
            $fechaCheckOut = $_POST['fechaCheckOut'];
            $precioTotal = $_POST['precioTotal'];
            $metodoPago = $_POST['metodoPago'];

            $sqlUpdate = "UPDATE reservas SET UsuarioID = ?, AlojamientoId = ?, FechaCheckIn = ?, FechaCheckOut = ?, PrecioTotal = ?, MetodoPago = ? WHERE ReservaId = ?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("iissdsi", $usuarioId, $alojamientoId, $fechaCheckIn, $fechaCheckOut, $precioTotal, $metodoPago, $reservaId);
            if ($stmt->execute()) {
                header('Location: ' . $_SERVER['PHP_SELF']); // Redirigir a la misma página
                exit;
            } else {
                $mensaje = "Error al actualizar la reserva.";
            }
        }
    }
}

// Mostrar las reservas en una tabla
$sql = "SELECT * FROM reservas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilosReservas.css">
    <title>ABM de Reservas</title>
</head>
<body>

<h1>Gestión de Reservas</h1>

<?php if (isset($mensaje)) { echo "<p>$mensaje</p>"; } ?>

<table border="1">
    <thead>
        <tr>
            <th>Reserva ID</th>
            <th>Fecha CheckIn</th>
            <th>Fecha CheckOut</th>
            <th>Precio Total</th>
            <th>Fecha Registro</th>
            <th>Método de Pago</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['ReservaId']; ?></td>
            <td><?php echo $row['FechaCheckIn']; ?></td>
            <td><?php echo $row['FechaCheckOut']; ?></td>
            <td><?php echo $row['PrecioTotal']; ?></td>
            <td><?php echo $row['FechaRegistro']; ?></td>
            <td><?php echo $row['MetodoPago']; ?></td>
            <td>
                <!-- Botones de acción para modificar y eliminar -->
                <a href="?action=modificar&id=<?php echo $row['ReservaId']; ?>">Modificar</a> | 
                <a href="?action=eliminar&id=<?php echo $row['ReservaId']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta reserva?');">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
// Si se selecciona modificar, mostrar el formulario
if (isset($reserva)) {
?>

<h2>Modificar Reserva</h2>
<form action="?action=modificar&id=<?php echo $reserva['ReservaId']; ?>" method="POST">
    <label for="usuarioId">Usuario ID</label>
    <input type="number" name="usuarioId" value="<?php echo $reserva['UsuarioID']; ?>" required>

    <label for="alojamientoId">Alojamiento ID</label>
    <input type="number" name="alojamientoId" value="<?php echo $reserva['AlojamientoId']; ?>" required>

    <label for="fechaCheckIn">Fecha de Entrada</label>
    <input type="date" name="fechaCheckIn" value="<?php echo $reserva['FechaCheckIn']; ?>" required>

    <label for="fechaCheckOut">Fecha de Salida</label>
    <input type="date" name="fechaCheckOut" value="<?php echo $reserva['FechaCheckOut']; ?>" required>

    <label for="precioTotal">Precio Total</label>
    <input type="number" step="0.01" name="precioTotal" value="<?php echo $reserva['PrecioTotal']; ?>" required>

    <label for="metodoPago">Método de Pago</label>
    <input type="text" name="metodoPago" value="<?php echo $reserva['MetodoPago']; ?>" required>

    <button type="submit">Actualizar Reserva</button>
</form>

<?php } ?>

</body>
</html>
