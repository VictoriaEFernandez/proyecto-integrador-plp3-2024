<?php
include 'cabecera.php';
include_once('conexion.php');

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener precios mínimo y máximo
$queryPreciosMinMax = "SELECT MIN(Precio) AS PrecioMinimo, MAX(Precio) AS PrecioMaximo 
                       FROM alojamientos";
$resultPreciosMinMax = $conn->query($queryPreciosMinMax);
$preciosMinMax = $resultPreciosMinMax->fetch_assoc();
$precioMinimo = $preciosMinMax['PrecioMinimo'];
$precioMaximo = $preciosMinMax['PrecioMaximo'];

// Procesar los resultados de alojamientos
$precioMin = isset($_GET['precio-min']) ? floatval($_GET['precio-min']) : $precioMinimo;
$precioMax = isset($_GET['precio-max']) ? floatval($_GET['precio-max']) : $precioMaximo;

$queryAlojamientos = "SELECT a.AlojamientoId, a.Descripcion, a.Ubicacion, a.Precio, 
                              a.Foto, a.Foto_blob, p.Nombre AS ProveedorNombre, 
                              t.Descripcion AS TipoAlojamiento
                      FROM alojamientos a
                      INNER JOIN proveedores p ON a.ProveedorId = p.ProveedorId
                      INNER JOIN tipos_alojamientos t ON a.TipoAlojamientoId = t.TipoAlojamientoId
                      WHERE a.Precio BETWEEN $precioMin AND $precioMax";
$resultAlojamientos = $conn->query($queryAlojamientos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuestros Alojamientos</title>
    <link rel="icon" href="iconos/flavicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/estilos-alojamientos.css">
    <link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>
<body class="alojamientos">
    <main>
        <section class="seccion-filtros">
            <h2>Filtrar Alojamientos</h2>
            <form id="formulario-filtro" method="GET" action="">
                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo">
                    <option value="">Todos</option>
                    <option value="hotel" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'hotel' ? 'selected' : ''; ?>>Hotel</option>
                    <option value="apartamento" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'apartamento' ? 'selected' : ''; ?>>Departamento</option>
                    <option value="casa" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'casa' ? 'selected' : ''; ?>>Casa</option>
                </select>

                <label for="precio-min">Precio mínimo:</label>
                <input type="input" id="precio-min" name="precio-min" min="<?php echo $precioMinimo; ?>" max="<?php echo $precioMaximo; ?>" value="">
                <span id="precio-min-value"></span>

                <label for="precio-max">Precio máximo:</label>
                <input type="input" id="precio-max" name="precio-max" min="<?php echo $precioMinimo; ?>" max="<?php echo $precioMaximo; ?>" value="">
                <span id="precio-max-value"></span>

                <button type="submit" class="boton-filtro">Buscar</button>
            </form>
        </section>

        <section class="lista-alojamientos">
    <h2>Alojamientos Disponibles</h2>
    <div class="alojamientos-container">
        <?php if ($resultAlojamientos->num_rows > 0): ?>
            <?php while ($alojamiento = $resultAlojamientos->fetch_assoc()): ?>
                <div class="alojamiento-item" data-id="<?= $alojamiento['AlojamientoId'] ?>">
                    <h3><?= $alojamiento['Descripcion'] ?></h3>
                    <p><strong>Proveedor:</strong> <?= $alojamiento['ProveedorNombre'] ?></p>
                    <p><strong>Tipo:</strong> <?= $alojamiento['TipoAlojamiento'] ?></p>
                    <p><strong>Ubicación:</strong> <?= $alojamiento['Ubicacion'] ?></p>
                    <p><strong>Precio:</strong> $<?= number_format($alojamiento['Precio'], 2) ?></p>
                    <?php if ($alojamiento['Foto_blob']): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($alojamiento['Foto_blob']) ?>" alt="Foto del alojamiento" class="foto-alojamiento">
                    <?php else: ?>
                        <p>No hay foto disponible</p>
                    <?php endif; ?>
                    <button class="boton-ver-detalles">Ver detalles</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No se encontraron alojamientos disponibles.</p>
        <?php endif; ?>
    </div>
</section>
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-content">
            <!-- Aquí se mostrará la información del alojamiento -->
        </div>
    </div>
</div>

    <footer class="pie-alojamientos">
        <p>&copy; 2024 Oasis Urbano. Todos los derechos reservados.</p>
    </footer>

    <script src="javascript/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>