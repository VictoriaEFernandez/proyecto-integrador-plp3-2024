<?php
include_once('../conexion.php');

// Agregar proveedor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'agregar') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    // Subir la foto si se proporciona
    $foto = NULL;
    if ($_FILES['foto']['tmp_name']) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    }

    $query = "INSERT INTO proveedores (Nombre, Apellido, Telefono, Email, Direccion, Foto_blob)
              VALUES ('$nombre', '$apellido', '$telefono', '$email', '$direccion', '$foto')";

    if (mysqli_query($conn, $query)) {
        header('Location: gestionarPropietarios.php'); // Redirige para refrescar la lista
    } else {
        echo "Error al agregar proveedor: " . mysqli_error($conn);
    }
}

// Editar proveedor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'editar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    // Subir la foto si se proporciona
    $foto = NULL;
    if ($_FILES['foto']['tmp_name']) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    }

    $query = "UPDATE proveedores SET 
              Nombre = '$nombre', 
              Apellido = '$apellido', 
              Telefono = '$telefono', 
              Email = '$email', 
              Direccion = '$direccion'";

    if ($foto) {
        $query .= ", Foto_blob = '$foto'";
    }

    $query .= " WHERE ProveedorId = $id";

    if (mysqli_query($conn, $query)) {
        header('Location: gestionarPropietarios.php'); // Redirige a la lista de proveedores
    } else {
        echo "Error al actualizar proveedor: " . mysqli_error($conn);
    }
}

// Eliminar proveedor
if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM proveedores WHERE ProveedorId = $id";

    if (mysqli_query($conn, $query)) {
        header('Location: gestionarPropietarios.php'); // Redirige a la lista de proveedores
    } else {
        echo "Error al eliminar proveedor: " . mysqli_error($conn);
    }
}

// Obtener los proveedores
$query = "SELECT * FROM proveedores";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Proveedores</title>
    <link rel="stylesheet" href="css/estilosABMPropietarios.css">
    </head>
<body>

    <header>
        <h1>Gestionar Proveedores</h1>
    </header>

    <section>
        <!-- Formulario para agregar proveedor -->
        <h2>Agregar Nuevo Proveedor</h2>
        <form action="gestionarPropietarios.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="agregar">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" required><br>

            <label for="foto">Foto:</label>
            <input type="file" name="foto" accept="image/*"><br><br>

            <button type="submit">Agregar Proveedor</button>
        </form>
    </section>

    <section>
        <!-- Mostrar los proveedores -->
        <h2>Lista de Proveedores</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['ProveedorId']; ?></td>
                            <td><?php echo $row['Nombre']; ?></td>
                            <td><?php echo $row['Apellido']; ?></td>
                            <td><?php echo $row['Telefono']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo $row['Direccion']; ?></td>
                            <td>
                                <?php if ($row['Foto_blob']): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Foto_blob']); ?>" alt="Foto Proveedor" width="50">
                                <?php else: ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Enlaces para editar y eliminar -->
                                <a href="gestionarPropietarios.php?action=editar&id=<?php echo $row['ProveedorId']; ?>">Editar</a>
                                <a href="gestionarPropietarios.php?action=eliminar&id=<?php echo $row['ProveedorId']; ?>" onclick="return confirm('¿Estás seguro de eliminar este proveedor?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay proveedores registrados.</p>
        <?php endif; ?>
    </section>

    <?php
    // Si se está editando un proveedor, mostrar el formulario con los datos del proveedor seleccionado
    if (isset($_GET['action']) && $_GET['action'] == 'editar' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM proveedores WHERE ProveedorId = $id";
        $result = mysqli_query($conn, $query);
        $proveedor = mysqli_fetch_assoc($result);
        ?>
        <section>
            <h2>Editar Proveedor</h2>
            <form action="gestionarPropietarios.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="editar">
                <input type="hidden" name="id" value="<?php echo $proveedor['ProveedorId']; ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $proveedor['Nombre']; ?>" required><br>

                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" value="<?php echo $proveedor['Apellido']; ?>" required><br>

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo $proveedor['Telefono']; ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $proveedor['Email']; ?>" required><br>

                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" value="<?php echo $proveedor['Direccion']; ?>" required><br>

                <label for="foto">Foto:</label>
                <input type="file" name="foto" accept="image/*"><br><br>

                <button type="submit">Actualizar Proveedor</button>
            </form>
        </section>
    <?php } ?>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
