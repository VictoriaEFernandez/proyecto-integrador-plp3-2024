<?php
// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar los datos recibidos
    $nombre = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $resena = isset($_POST['review']) ? $conn->real_escape_string($_POST['review']) : '';
    $puntuacion = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

    // Validaciones del lado del servidor
    $errores = [];
    
    if (strlen($nombre) < 2) {
        $errores[] = "El nombre debe tener al menos 2 caracteres";
    }
    
    if (strlen($resena) < 10) {
        $errores[] = "La reseña debe tener al menos 10 caracteres";
    }
    
    if ($puntuacion < 1 || $puntuacion > 5) {
        $errores[] = "La puntuación debe estar entre 1 y 5";
    }

    // Si no hay errores, proceder con la inserción
    if (empty($errores)) {
        $sql = "INSERT INTO reseñas (Nombre, Reseña, Puntuación, Fecha) 
                VALUES ('$nombre', '$resena', $puntuacion, NOW())";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('¡Gracias por tu reseña!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        } else {
            $mensaje_error = "Error al guardar la reseña: " . $conn->error;
        }
    } else {
        $mensaje_error = implode(", ", $errores);
    }
}

// Obtener las reseñas existentes
$sql_select = "SELECT * FROM reseñas ORDER BY Fecha DESC";
$resultado = $conn->query($sql_select);
?>

<!-- Sección para mostrar mensajes de error si existen -->
<?php if (isset($mensaje_error)): ?>
    <div class="error-mensaje">
        <?php echo $mensaje_error; ?>
    </div>
<?php endif; ?>

<!-- Sección para dejar reseñas -->
 <link rel="stylesheet" href="css/estilos-resenas.css">
<section class="seccion-resenas">
    <h2>Deja tu Reseña</h2>
    <form id="resena-form" method="POST" action="index.php">
        <div class="formulario-resen">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="formulario-resen">
            <label for="review">Reseña:</label>
            <textarea id="review" name="review" rows="4" required></textarea>
        </div>
        
        <div class="formulario-resen">
            <label for="rating">Puntuación:</label>
            <select id="rating" name="rating" required>
                <option value="5">5 - Excelente</option>
                <option value="4">4 - Muy Bueno</option>
                <option value="3">3 - Bueno</option>
                <option value="2">2 - Regular</option>
                <option value="1">1 - Malo</option>
            </select>
        </div>
        
        <button type="submit" class="boton-resenas">Enviar Reseña</button>
    </form>

    <!-- Sección para mostrar las reseñas existentes -->
    <div class="resenas-existentes">
        <h3>Reseñas de Nuestros Clientes</h3>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while($row = $resultado->fetch_assoc()): ?>
                <div class="resena-item">
                    <div class="resena-header">
                        <strong><?php echo htmlspecialchars($row['Nombre']); ?></strong>
                        <span class="puntuacion">
                            <?php 
                            for($i = 1; $i <= 5; $i++) {
                                echo $i <= $row['Puntuación'] ? '★' : '☆';
                            }
                            ?>
                        </span>
                    </div>
                    <p class="resena-texto"><?php echo nl2br(htmlspecialchars($row['Reseña'])); ?></p>
                    <small class="resena-fecha">
                        <?php echo date('d/m/Y', strtotime($row['Fecha'])); ?>
                    </small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aún no hay reseñas. ¡Sé el primero en dejar una!</p>
        <?php endif; ?>
    </div>
</section>
<script src="javascript/index.js"></script>
