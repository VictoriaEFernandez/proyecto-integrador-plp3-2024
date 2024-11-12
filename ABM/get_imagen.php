<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Preparar la consulta
    $stmt = $conn->prepare("SELECT Foto_blob FROM alojamientos WHERE AlojamientoId = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imagen);
        $stmt->fetch();
        
        if ($imagen) {
            // Detectar el tipo de imagen
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tipo_imagen = $finfo->buffer($imagen);
            
            // Enviar headers apropiados
            header("Content-Type: $tipo_imagen");
            header('Cache-Control: max-age=86400'); // Cache por 24 horas
            
            // Enviar la imagen
            echo $imagen;
        } else {
            // Si no hay imagen, redirigir a una imagen por defecto
            header('Location: imagenes/default-alojamiento.jpg');
        }
    } else {
        // Si no se encuentra el registro, mostrar imagen por defecto
        header('Location: imagenes/default-alojamiento.jpg');
    }
    
    $stmt->close();
} else {
    // Si no se proporciona ID, mostrar imagen por defecto
    header('Location: imagenes/default-alojamiento.jpg');
}

$conn->close();
?>