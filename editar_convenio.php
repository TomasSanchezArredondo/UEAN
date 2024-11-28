<?php
include('conexion.php');
include './navbar.php';

// Obtener ID y tipo desde la URL
$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? null;

if (!$id || !$tipo) {
    echo "Parámetros inválidos.";
    exit;
}

$datos = [];

// Obtener los datos según el tipo de convenio
if ($tipo === 'otros') {
    $sql = "SELECT * FROM convenio_otros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
} elseif ($tipo === 'pasantia_beneficio') {
    $sql = "SELECT * FROM convenios_pasantia_beneficios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
} else {
    echo "Tipo de convenio inválido.";
    exit;
}

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $datos = $result->fetch_assoc();
} else {
    echo "Convenio no encontrado.";
    exit;
}

$stmt->close();

// Si se envía el formulario, procesar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_entidad = $_POST['id_entidad'];
    $tipo_convenio = $_POST['tipo_convenio'];
    $observaciones = $_POST['observaciones'];
    $fecha_firma_convenio = $_POST['fecha_firma_convenio'] ?? null;
    $convenio_file = $datos['convenio_file']; // Mantener el archivo original si no se sube uno nuevo

    // Manejar la subida del archivo
    if (!empty($_FILES['convenio_file']['name'])) {
        $upload_dir = 'uploads/';
        $file_name = rand(1000, 9999) . '_' . basename($_FILES['convenio_file']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['convenio_file']['tmp_name'], $file_path)) {
            $convenio_file = $file_path;
        } else {
            echo "Error al subir el archivo.";
            exit;
        }
    }

    if ($tipo === 'otros') {
        $firma_convenio = $_POST['firma_convenio'];
        $adendas_cantidad = $_POST['adendas_cantidad'];
        $sql_update = "UPDATE convenio_otros SET id_entidad = ?, tipo_convenio = ?, firma_convenio = ?, adendas_cantidad = ?, observaciones = ?, convenio_file = ?, fecha_firma_convenio = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ississsi", $id_entidad, $tipo_convenio, $firma_convenio, $adendas_cantidad, $observaciones, $convenio_file, $fecha_firma_convenio, $id);
    } elseif ($tipo === 'pasantia_beneficio') {
        $sql_update = "UPDATE convenios_pasantia_beneficios SET id_entidad = ?, tipo_convenio = ?, observaciones = ?, convenio_file = ?, fecha_firma_convenio = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("issssi", $id_entidad, $tipo_convenio, $observaciones, $convenio_file, $fecha_firma_convenio, $id);
    }

    if ($stmt_update->execute()) {
        // Asegurarse de no haber enviado salida antes de usar header()
        echo "<script>window.location.href = 'lista_convenios.php';</script>";
        exit;
    } else {
        echo "Error al actualizar el convenio: " . $conn->error;
    }

    $stmt_update->close();
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
    <h1 class="mb-4 text-center">Editar Convenio</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="id_entidad" class="form-label">Entidad</label>
            <input type="number" class="form-control" id="id_entidad" name="id_entidad" value="<?php echo htmlspecialchars($datos['id_entidad']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="tipo_convenio" class="form-label">Tipo de Convenio</label>
            <input type="text" class="form-control" id="tipo_convenio" name="tipo_convenio" value="<?php echo htmlspecialchars($datos['tipo_convenio']); ?>" required>
        </div>
        <?php if ($tipo === 'otros'): ?>
            <div class="mb-3">
                <label for="firma_convenio" class="form-label">Firma de Convenio</label>
                <select class="form-select" id="firma_convenio" name="firma_convenio">
                    <option value="Sí" <?php echo $datos['firma_convenio'] === 'Sí' ? 'selected' : ''; ?>>Sí</option>
                    <option value="No" <?php echo $datos['firma_convenio'] === 'No' ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="adendas_cantidad" class="form-label">Cantidad de Adendas</label>
                <input type="number" class="form-control" id="adendas_cantidad" name="adendas_cantidad" value="<?php echo htmlspecialchars($datos['adendas_cantidad']); ?>">
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="fecha_firma_convenio" class="form-label">Fecha de Firma</label>
            <input type="date" class="form-control" id="fecha_firma_convenio" name="fecha_firma_convenio" value="<?php echo htmlspecialchars($datos['fecha_firma_convenio']); ?>">
        </div>
        <div class="mb-3">
            <label for="convenio_file" class="form-label">Archivo del Convenio</label>
            <?php if (!empty($datos['convenio_file'])): ?>
                <p>Archivo actual: <a href="<?php echo htmlspecialchars($datos['convenio_file']); ?>" target="_blank">Ver archivo</a></p>
            <?php endif; ?>
            <input type="file" class="form-control" id="convenio_file" name="convenio_file">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="lista_convenios.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>