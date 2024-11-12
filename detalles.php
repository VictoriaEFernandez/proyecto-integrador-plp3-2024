<?php
include 'cabecera.php';
include_once('conexion.php');

if (isset($_GET['id'])) {
    $alojamientoId = $_GET['id'];

    $query = "SELECT a.Descripcion, a.Ubicacion, a.Precio, a.Foto, a.Foto_blob,
                     a.Capacidad, a.Descripcion AS DescripcionLarga, a.Servicios, a.Estrellas,
                    p.Nombre AS ProveedorNombre, t.Descripcion AS TipoAlojamiento
             FROM alojamientos a
             INNER JOIN proveedores p ON a.ProveedorId = p.ProveedorId
             INNER JOIN tipos_alojamientos t ON a.TipoAlojamientoId = t.TipoAlojamientoId
             WHERE a.AlojamientoId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $alojamientoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $alojamiento = $result->fetch_assoc();
    ?>

    <div class="alojamiento-detalles">
        <h2><?= $alojamiento['Descripcion'] ?></h2>
        <p><strong>Proveedor:</strong> <?= $alojamiento['ProveedorNombre'] ?></p>
        <p><strong>Tipo:</strong> <?= $alojamiento['TipoAlojamiento'] ?></p>
        <p><strong>Ubicación:</strong> <?= $alojamiento['Ubicacion'] ?></p>
        <p><strong>Precio:</strong> $<?= number_format($alojamiento['Precio'], 2) ?></p>
        <p><strong>Capacidad:</strong> <?= $alojamiento['Capacidad'] ?></p>
        <p><strong>Descripción:</strong> <?= $alojamiento['DescripcionLarga'] ?></p>
        <p><strong>Servicios:</strong> <?= $alojamiento['Servicios'] ?></p>
        <?php if ($alojamiento['Estrellas']): ?>
            <p><strong>Estrellas:</strong> <?= $alojamiento['Estrellas'] ?></p>
        <?php endif; ?>
        <?php if ($alojamiento['Foto_blob']): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($alojamiento['Foto_blob']) ?>" alt="Foto del alojamiento" class="foto-alojamiento">
        <?php else: ?>
            <p>No hay foto disponible</p>
        <?php endif; ?>
    </div>

    <?php
    $stmt->close();
} else {
    echo "No se ha proporcionado un ID de alojamiento válido.";
}
$conn->close();
?>