<?php 
include_once('../conexion.php'); 
include('inicio.php'); 

// Verificar conexión 
if ($conn->connect_error) { 
    die("Error de conexión: " . $conn->connect_error); 
} 

// Función para obtener los proveedores y tipos de alojamiento 
function obtenerProveedores($conn) { 
    $query = "SELECT * FROM proveedores"; 
    return $conn->query($query); 
} 

function obtenerTiposAlojamiento($conn) { 
    $query = "SELECT * FROM tipos_alojamientos"; 
    return $conn->query($query); 
} 

// Proceso de guardar o actualizar alojamiento
if (isset($_POST['guardar']) || isset($_POST['actualizar'])) { 
    // Validar que los campos requeridos no estén vacíos 
    if (empty($_POST['proveedor']) || empty($_POST['tipo']) || empty($_POST['descripcion']) || empty($_POST['ubicacion']) || empty($_POST['precio']) || empty($_POST['servicios'])) { 
        echo "Error: Todos los campos son requeridos"; 
        exit; 
    }

    $proveedor = $conn->real_escape_string($_POST['proveedor']); 
    $tipo = $conn->real_escape_string($_POST['tipo']); 
    $descripcion = $conn->real_escape_string($_POST['descripcion']); 
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']); 
    $precio = $conn->real_escape_string($_POST['precio']); 
    $servicios = $conn->real_escape_string($_POST['servicios']); 
    $capacidad = !empty($_POST['capacidad']) ? $conn->real_escape_string($_POST['capacidad']) : null; 
    $estrellas = !empty($_POST['estrellas']) ? $conn->real_escape_string($_POST['estrellas']) : null; 

    // Si se está actualizando un alojamiento
    if (isset($_POST['actualizar'])) {
        $alojamientoId = $_GET['id']; // Obtener el ID del alojamiento a actualizar
        // Actualizar el alojamiento en la base de datos
        $queryAlojamiento = "UPDATE alojamientos SET ProveedorId=?, TipoAlojamientoId=?, Descripcion=?, Ubicacion=?, Precio=?, Servicios=?, Capacidad=?, Estrellas=? WHERE AlojamientoId=?";
        $stmt = $conn->prepare($queryAlojamiento);
        $stmt->bind_param("iissdsiii", $proveedor, $tipo, $descripcion, $ubicacion, $precio, $servicios, $capacidad, $estrellas, $alojamientoId);
        
        if ($stmt->execute()) {
            // Manejar la carga de fotos
            if (!empty($_FILES['fotos']['name'][0])) { 
                foreach ($_FILES['fotos']['tmp_name'] as $index => $tmpName) { 
                    if (is_uploaded_file($tmpName)) { 
                        // Leer el contenido del archivo y preparar para guardar
                        $fotoBlob = file_get_contents($tmpName); 

                        // Guardar la imagen en la base de datos
                        // Aquí se puede decidir si se quiere reemplazar la imagen existente o agregar una nueva lógica.
                        $queryFoto = "UPDATE alojamientos SET Foto_blob = ? WHERE AlojamientoId = ?"; 
                        $stmtFoto = $conn->prepare($queryFoto); 
                        $stmtFoto->bind_param("si", $fotoBlob, $alojamientoId); 

                        if (!$stmtFoto->execute()) { 
                            echo "Error al guardar la imagen: " . $stmtFoto->error; 
                        }
                        $stmtFoto->close(); 
                    } else { 
                        echo "Error al procesar la imagen."; 
                    } 
                } 
            } 

            echo "<script>alert('Alquiler actualizado exitosamente.'); window.location.href='gestionarAlquileres.php';</script>"; 

        } else { 
            echo "Error al actualizar el alquiler: " . $stmt->error; 
        } 
        
        // Cerrar el statement para actualizar
        $stmt->close(); 

    } else {
        // Si se está guardando un nuevo alojamiento
        // Insertar alojamiento en la base de datos
        $queryAlojamiento = "INSERT INTO alojamientos (ProveedorId, TipoAlojamientoId, Descripcion, Ubicacion, Precio, Servicios, Capacidad, Estrellas, FechaRegistro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())"; 
        
        // Usar prepared statements para prevenir SQL injection 
        $stmt = $conn->prepare($queryAlojamiento); 
        $stmt->bind_param("iissdsii", $proveedor, $tipo, $descripcion, $ubicacion, $precio, $servicios, $capacidad, $estrellas); 
        
        if ($stmt->execute()) { 
            // Obtener el ID del alojamiento recién creado
            $alojamientoId = $conn->insert_id; 

            // Manejar la carga de fotos
            if (!empty($_FILES['fotos']['name'][0])) { 
                foreach ($_FILES['fotos']['tmp_name'] as $index => $tmpName) { 
                    if (is_uploaded_file($tmpName)) { 
                        // Leer el contenido del archivo y preparar para guardar
                        $fotoBlob = file_get_contents($tmpName); 

                        // Guardar la imagen en la base de datos
                        // Asegúrate de que el campo Foto_blob esté configurado correctamente en tu base de datos
                        $queryFoto = "UPDATE alojamientos SET Foto_blob = ? WHERE AlojamientoId = ?"; 
                        $stmtFoto = $conn->prepare($queryFoto); 
                        $stmtFoto->bind_param("si", $fotoBlob, $alojamientoId); 

                        if (!$stmtFoto->execute()) { 
                            echo "Error al guardar la imagen: " . $stmtFoto->error; 
                        }
                        $stmtFoto->close(); 
                    } else { 
                        echo "Error al procesar la imagen."; 
                    } 
                } 
            } 

            echo "<script>alert('Alquiler agregado exitosamente.'); window.location.href='gestionarAlquileres.php';</script>"; 

        } else { 
            echo "Error al guardar el alquiler: " . $stmt->error; 
        } 
        
        // Cerrar el statement para insertar
        $stmt->close();  
    }
} 

// Proceso para eliminar un alojamiento
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) { 
    // Confirmar que se ha recibido un ID válido para eliminar.
    $alojamientoId = $_GET['eliminar'];  

    // Preparar y ejecutar la eliminación utilizando prepared statements para mayor seguridad.
    if ($stmtEliminar =  $conn->prepare("DELETE FROM alojamientos WHERE AlojamientoId=?")) {
        $stmtEliminar->bind_param("i", $alojamientoId);
        if ($stmtEliminar->execute()) {
            echo "<script>alert('Alquiler eliminado exitosamente.'); window.location.href='gestionarAlquileres.php';</script>";
        } else {
            echo "Error al eliminar el alquiler: " . $stmtEliminar->error;
        }
    }
}

// Obtener los alojamientos disponibles
$queryAlojamientos = "SELECT * FROM alojamientos";  
$resultAlojamientos =  $conn->query($queryAlojamientos);  

// Obtener datos para el formulario (si estamos editando)
$alojamiento = null;  

if (isset($_GET['id'])) {  
    $alojamientoId = $_GET['id'];  
    $queryAlojamiento = "SELECT * FROM alojamientos WHERE AlojamientoId='$alojamientoId'";  
    $resultAlojamiento =  $conn->query($queryAlojamiento);  
    $alojamiento =  $resultAlojamiento->fetch_assoc();  
}

$proveedores = obtenerProveedores($conn);  
$tiposAlojamiento = obtenerTiposAlojamiento($conn);  
?>  


<!DOCTYPE html>  
<html lang="es">  
<head>  
<meta charset="UTF-8">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
<title>Gestión de Alquileres</title>  
<link rel="stylesheet" href="css/estiloGestionarAlojamientos.css">
</head>  
<body>  
<h2><?= isset($alojamiento) ? 'Editar Alquiler' : 'Gestión de Alquileres' ?></h2>  

<form action="gestionarAlquileres.php<?= isset($alojamiento) ? '?id=' . htmlspecialchars($alojamiento['AlojamientoId']) : '' ?>" method="POST" enctype="multipart/form-data">  
<label for="proveedor">Proveedor:</label>  
<select name="proveedor" id="proveedor" required>  
<?php while ($row = mysqli_fetch_assoc($proveedores)): ?>  
<option value="<?= htmlspecialchars($row['ProveedorId']) ?>" <?= (isset($alojamiento) && htmlspecialchars($row['ProveedorId']) == htmlspecialchars($alojamiento['ProveedorId'])) ? 'selected' : '' ?>> <?= htmlspecialchars($row['Nombre'] . ' ' .  htmlspecialchars($row['Apellido']) ) ?> </option>  
<?php endwhile; ?>  
</select>  

<label for="tipo">Tipo de Alojamiento:</label>  
<select name="tipo" id="tipo" required>  
<?php while ($row = mysqli_fetch_assoc($tiposAlojamiento)): ?>  
<option value="<?= htmlspecialchars($row['TipoAlojamientoId']) ?>" <?= (isset($alojamiento) && htmlspecialchars($row['TipoAlojamientoId']) == htmlspecialchars($alojamiento['TipoAlojamientoId'])) ? 'selected' : '' ?>> <?= htmlspecialchars($row['Descripcion']) ?> </option>  
<?php endwhile; ?>  
</select>  

<label for="descripcion">Descripción:</label>  
<textarea name="descripcion" id="descripcion" required><?= isset($alojamiento) ? htmlspecialchars($alojamiento['Descripcion']) : '' ?></textarea>  

<label for="ubicacion">Ubicación:</label>  
<input type="text" name="ubicacion" id="ubicacion" value="<?= isset($alojamiento) ? htmlspecialchars($alojamiento['Ubicacion']) : '' ?>" required>  

<label for="precio">Precio:</label>  
<input type="number" name="precio" id="precio" value="<?= isset($alojamiento) ? htmlspecialchars($alojamiento['Precio']) : '' ?>" required>  

<label for="servicios">Servicios:</label>  
<input type="text" name="servicios" id="servicios" value="<?= isset($alojamiento) ? htmlspecialchars($alojamiento['Servicios']) : '' ?>" required>  

<label for="capacidad">Capacidad:</label>  
<input type="number" name="capacidad" id="capacidad" value="<?= isset($alojamiento) ? htmlspecialchars($alojamiento['Capacidad']) : '' ?>">  

<label for="estrellas">Estrellas:</label>  
<input type="number" name="estrellas" id="estrellas" value="<?= isset($alojamiento) ? htmlspecialchars($alojamiento['Estrellas']) : '' ?>">  

<label for="fotos">Fotos:</label>  
<input type="file" name="fotos[]" multiple>  

<button type="submit" name="<?= isset($alojamiento) ? 'actualizar' : 'guardar' ?>"> <?= isset($alojamiento) ? 'Actualizar Alquiler' : 'Guardar Alquiler' ?> </button>  
</form>  

<h3>Alquileres Disponibles</h3>  
<table border="1">  
<tr>  
<th>ID</th>  
<th>Proveedor</th>  
<th>Tipo</th>  
<th>Descripción</th>
<th>Ubicación</th>
<th>Precio</th>
<th>Servicios</th>
<th>Capacidad</th>
<th>Estrellas</th>
<th>Foto</th>
<th>Acciones</th>
</tr>

<?php while ($alquiler = mysqli_fetch_assoc($resultAlojamientos)): ?>   
<tr>
<td><?= htmlspecialchars($alquiler['AlojamientoId']) ?></td>
<td><?= htmlspecialchars($alquiler['ProveedorId']) ?></td>
<td><?= htmlspecialchars($alquiler['TipoAlojamientoId']) ?></td>
<td><?= htmlspecialchars($alquiler['Descripcion']) ?></td>
<td><?= htmlspecialchars($alquiler['Ubicacion']) ?></td>
<td><?= htmlspecialchars($alquiler['Precio']) ?></td>
<td><?= htmlspecialchars($alquiler['Servicios']) ?></td>
<td><?= htmlspecialchars($alquiler['Capacidad']) ?></td>
<td><?= htmlspecialchars($alquiler['Estrellas']) ?></td>
<td>
<?php if (!empty($alquiler['Foto_blob'])): ?>
<img src="data:image/jpeg;base64,<?= base64_encode($alquiler['Foto_blob']) ?>" alt="Imagen" width="80px" height="80px">
<?php else: ?>
No hay imagen disponible
<?php endif; ?>
</td>
<td>
    <a href="?id=<?= htmlspecialchars($alquiler['AlojamientoId']) ?>">Editar</a>
    | <a href="?eliminar=<?= htmlspecialchars($alquiler['AlojamientoId']) ?>" onclick="return confirm('¿Estás seguro de eliminar?')">Eliminar</a>
</td>

</tr>
<?php endwhile; ?>
</table>

</body>
</html>