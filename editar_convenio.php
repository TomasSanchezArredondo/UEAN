<?php
include 'conexion.php';
include './navbar.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID del convenio no proporcionado.";
    exit;
}

// Consulta ajustada para ambas tablas
$query = "
    SELECT 
        co.id, 
        e.nombre AS entidad, 
        co.tipo_convenio, 
        co.firma_convenio, 
        co.adendas_cantidad, 
        co.observaciones, 
        co.convenio_file, 
        co.fecha_firma_convenio 
    FROM convenio_otros co
    INNER JOIN entidad e ON co.id_entidad = e.id
    WHERE co.id = ?
    UNION ALL
    SELECT 
        cpb.id, 
        e.nombre AS entidad, 
        cpb.tipo_convenio, 
        NULL AS firma_convenio, 
        NULL AS adendas_cantidad, 
        cpb.observaciones, 
        cpb.convenio_file, 
        cpb.fecha_firma_convenio 
    FROM convenios_pasantia_beneficios cpb
    INNER JOIN entidad e ON cpb.id_entidad = e.id
    WHERE cpb.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $id);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();

if (!$datos) {
    echo "Convenio no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Convenio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Convenio</h2>
    <form action="procesar_edicion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($datos['id']) ?>">
        
        <!-- Campos de edición -->
        <div class="mb-3">
            <label for="entidad" class="form-label">Entidad</label>
            <input type="text" id="entidad" name="entidad" class="form-control" value="<?= htmlspecialchars($datos['entidad']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="tipo_convenio" class="form-label">Tipo de Convenio</label>
            <input type="text" id="tipo_convenio" name="tipo_convenio" class="form-control" value="<?= htmlspecialchars($datos['tipo_convenio']) ?>" required>
        </div>

        <?php if ($datos['firma_convenio'] !== null): ?>
            <div class="mb-3">
                <label for="firma_convenio" class="form-label">Firma del Convenio</label>
                <input type="text" id="firma_convenio" name="firma_convenio" class="form-control" value="<?= htmlspecialchars($datos['firma_convenio']) ?>">
            </div>
        <?php endif; ?>

        <?php if ($datos['adendas_cantidad'] !== null): ?>
            <div class="mb-3">
                <label for="adendas_cantidad" class="form-label">Cantidad de Adendas</label>
                <input type="number" id="adendas_cantidad" name="adendas_cantidad" class="form-control" value="<?= htmlspecialchars($datos['adendas_cantidad']) ?>">
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea id="observaciones" name="observaciones" class="form-control"><?= htmlspecialchars($datos['observaciones']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha_firma_convenio" class="form-label">Fecha de Firma</label>
            <input type="date" id="fecha_firma_convenio" name="fecha_firma_convenio" class="form-control" value="<?= htmlspecialchars($datos['fecha_firma_convenio']) ?>">
        </div>

        <div class="mb-3">
            <label for="convenio_file" class="form-label">Archivo del Convenio</label>
            <input type="file" id="convenio_file" name="convenio_file" class="form-control">
            <?php if (!empty($datos['convenio_file'])): ?>
                <a href="<?= htmlspecialchars($datos['convenio_file']) ?>" target="_blank" class="btn btn-link">Ver archivo actual</a>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
</body>
</html>
