<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener los datos de los proveedores
$sql = "SELECT ProveedorId, Nombre, Apellido, Foto, Foto_blob, Email, Telefono FROM proveedores";
$result = $conn->query($sql);

$propietarios = [];
if ($result->num_rows > 0) {
    // Guardar los datos de los propietarios en un array
    while($row = $result->fetch_assoc()) {
        // Si la imagen está en BLOB, la convertimos a base64
        if ($row['Foto_blob']) {
            $foto_base64 = base64_encode($row['Foto_blob']);
            $foto = 'data:image/jpeg;base64,' . $foto_base64; // Suponiendo que la imagen es JPEG
        } else {
            // Si no hay foto, usamos una imagen predeterminada
            $foto = 'imgPropietarios/default.png';
        }

        // Agregamos los datos al array
        $propietarios[] = [
            'ProveedorId' => $row['ProveedorId'],
            'Nombre' => $row['Nombre'],
            'Apellido' => $row['Apellido'],
            'Foto' => $foto,
            'Email' => $row['Email'],
            'Telefono' => $row['Telefono']
        ];
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjetas de Propietarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos-propietarios.css">
    <?php include 'cabecera.php'; ?>
    <link rel="icon" href="iconos/flavicon.png" type="image/x-icon">
</head>
<body>
    <div class="container mt-5">
        <input type="text" id="filtro" placeholder="Buscar propietario por nombre..." class="form-control mb-4">
        <div class="row row-cols-1 row-cols-md-3 g-4" id="propietarios">
            <?php if (empty($propietarios)) { ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">No se encontraron propietarios.</div>
                </div>
            <?php } else {
                foreach ($propietarios as $propietario) {
                    ?>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <img src="<?php echo $propietario['Foto']; ?>" class="card-img-top" alt="Avatar de <?php echo $propietario['Nombre']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $propietario['Nombre'] . ' ' . $propietario['Apellido']; ?></h5>
                                <p class="card-text">Correo: <?php echo $propietario['Email']; ?></p>
                                <p class="card-text">Teléfono: <?php echo $propietario['Telefono']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>

    <script src="javascript/propietarios.js"></script>
</body>
</html>
