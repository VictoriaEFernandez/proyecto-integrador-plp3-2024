<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['nombre'])) {
    echo "Sesión no iniciada. Redirigiendo...";
    header("Location: ../login.php");
    exit();
} 

// Conectar a la base de datos
include('../conexion.php');

// Obtener el nombre del admin de la sesión
$nombreAdmin = $_SESSION['nombre']; 

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['funciones'])) {
        $funcionSeleccionada = $_POST['funciones'];

        // Redirigir a la página correspondiente según la opción seleccionada
        if ($funcionSeleccionada == 'gestionar_alquileres') {
            header("Location: gestionarAlquileres.php");
            exit();
        } elseif ($funcionSeleccionada == 'gestionar_propietarios') {
            header("Location: gestionarPropietarios.php");
            exit();
        } elseif ($funcionSeleccionada == 'gestionar_reservas') { // Corregir la comparación aquí
            header("Location: gestionarReservas.php");
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
    <title>Oasis Urbano - Admin</title>
    <link rel="stylesheet" href="css/estiloIndex.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, Admin </h1>
        <form action="" method="post">
            <label for="funciones">Selecciona una opción:</label>
            <select name="funciones" id="funciones">
                <option value="gestionar_alquileres">Gestionar Alojamientos</option>
                <option value="gestionar_propietarios">Gestionar Propietarios</option>
                <option value="gestionar_reservas">Gestionar Reservas</option> <!-- Asegúrate que este valor coincida con el código -->
            </select>
            <button type="submit">Ir</button>
        </form>
    </div>
</body>
</html>
