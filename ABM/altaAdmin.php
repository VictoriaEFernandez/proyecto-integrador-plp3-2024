<?php
session_start();
include_once('../conexion.php');

// Clave única para alta de administradores
$clave_unica = "claveSuperSecreta123";
$clave_correcta = false;
$mensaje = '';
$tipo_mensaje = ''; // Para distinguir entre errores y éxitos

// Verificación de la conexión a la base de datos
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificación de la clave
if (isset($_POST['clave'])) {
    if ($_POST['clave'] === $clave_unica) {
        $clave_correcta = true;
        // Mantener la clave correcta en la sesión para el formulario siguiente
        $_SESSION['clave_validada'] = true;
    } else {
        $mensaje = "Clave incorrecta. No se puede crear un nuevo administrador.";
        $tipo_mensaje = 'error';
    }
}

// Verificar si la clave fue validada previamente
if (isset($_SESSION['clave_validada'])) {
    $clave_correcta = true;
}

// Procesar el formulario de registro
if ($clave_correcta && isset($_POST['nombre'])) {
    try {
        // Validación de campos
        if (empty($_POST['nombre']) || empty($_POST['apellido']) || 
            empty($_POST['correo']) || empty($_POST['telefono']) || 
            empty($_POST['contrasena'])) {
            throw new Exception("Todos los campos son obligatorios");
        }

        // Sanitización de datos
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $apellido = filter_var($_POST['apellido'], FILTER_SANITIZE_STRING);
        $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
        $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
        $contrasena = $_POST['contrasena'];
        $rolID = 2; // Rol de administrador

        // Validación adicional del correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo electrónico no es válido");
        }

        // Cifrado de la contraseña
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Verificar si el correo ya existe
        $check_email = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE CorreoElectronico = ?");
        $check_email->bind_param("s", $correo);
        $check_email->execute();
        $check_email->bind_result($count);
        $check_email->fetch();
        $check_email->close();

        if ($count > 0) {
            throw new Exception("El correo electrónico ya está registrado");
        }

        // Preparar la consulta SQL
        $stmt = $conn->prepare("INSERT INTO usuarios (Nombre, Apellido, CorreoElectronico, Contrasena, Telefono, RolID, FechaRegistro) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        // Asignar los parámetros y ejecutar
        $stmt->bind_param("sssssi", $nombre, $apellido, $correo, $contrasena_cifrada, $telefono, $rolID);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $mensaje = "Administrador creado exitosamente";
        $tipo_mensaje = 'exito';
        
        $stmt->close();

    } catch (Exception $e) {
        $mensaje = $e->getMessage();
        $tipo_mensaje = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Administrador</title>
    <style>
        .mensaje-error { color: red; padding: 10px; }
        .mensaje-exito { color: green; padding: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 150px; }
    </style>
</head>
<body>
    <h2>Alta de Nuevo Administrador</h2>

    <?php if ($mensaje): ?>
        <div class="mensaje-<?php echo $tipo_mensaje; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <?php if (!$clave_correcta): ?>
        <form action="altaAdmin.php" method="post">
            <div class="form-group">
                <label for="clave">Clave única:</label>
                <input type="password" id="clave" name="clave" required>
            </div>
            <button type="submit">Validar Clave</button>
        </form>
    <?php else: ?>
        <form action="altaAdmin.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>

            <button type="submit">Crear Administrador</button>
        </form>
    <?php endif; ?>
</body>
</html>