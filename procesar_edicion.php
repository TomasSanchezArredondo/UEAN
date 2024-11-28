<?php
include 'conexion.php';

// Verificar si se recibieron los datos necesarios
$id = $_POST['id'] ?? null;
$entidad = $_POST['entidad'] ?? null;
$tipo_convenio = $_POST['tipo_convenio'] ?? null;
$firma_convenio = $_POST['firma_convenio'] ?? null;
$adendas_cantidad = $_POST['adendas_cantidad'] ?? null;
$observaciones = $_POST['observaciones'] ?? null;
$fecha_firma_convenio = $_POST['fecha_firma_convenio'] ?? null;

// Verificar que el ID esté presente
if (!$id) {
    echo "ID no proporcionado.";
    exit;
}

$fecha_firma_convenio = !empty($fecha_firma_convenio) && $fecha_firma_convenio !== '0000-00-00'
    ? $fecha_firma_convenio
    : null;

// Validar el formato de la fecha antes de la consulta
if (!empty($fecha_firma_convenio) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_firma_convenio)) {
    echo "Formato de fecha inválido.";
    exit;
}


// Manejar archivo si se subió
$convenio_file = null;
if (isset($_FILES['convenio_file']) && $_FILES['convenio_file']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $filename = basename($_FILES['convenio_file']['name']);
    $target_file = $upload_dir . time() . '_' . $filename;

    if (move_uploaded_file($_FILES['convenio_file']['tmp_name'], $target_file)) {
        $convenio_file = $target_file;
    } else {
        echo "Error al subir el archivo.";
        exit;
    }
}

// Identificar la tabla según el ID
$query_check = "
    SELECT 'otros' AS tabla FROM convenio_otros WHERE id = ? 
    UNION ALL
    SELECT 'pasantias' AS tabla FROM convenios_pasantia_beneficios WHERE id = ?
";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("ii", $id, $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$tabla = $result_check->fetch_assoc()['tabla'];

if (!$tabla) {
    echo "Convenio no encontrado.";
    exit;
}

// Preparar consulta de actualización
if ($tabla === 'otros') {
    $query_update = "
    UPDATE convenio_otros
    SET 
        tipo_convenio = ?,
        firma_convenio = ?,
        adendas_cantidad = ?,
        observaciones = ?,
        fecha_firma_convenio = ?,
        convenio_file = IFNULL(?, convenio_file)
    WHERE id = ?
";
$stmt_update = $conn->prepare($query_update);
$stmt_update->bind_param(
    "ssisisi",
    $tipo_convenio,
    $firma_convenio,
    $adendas_cantidad,
    $observaciones,
    $fecha_firma_convenio,
    $convenio_file,
    $id
    );
} else {
    $query_update = "
        UPDATE convenios_pasantia_beneficios
        SET 
            tipo_convenio = ?,
            observaciones = ?,
            fecha_firma_convenio = ?,
            convenio_file = IFNULL(?, convenio_file)
        WHERE id = ?
    ";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param(
        "sssii",
        $tipo_convenio,
        $observaciones,
        $fecha_firma_convenio,
        $convenio_file,
        $id
    );
}

// Ejecutar la consulta de actualización
if ($stmt_update->execute()) {
    // Redirigir al usuario tras el éxito
    header("Location: lista_convenios.php");
    exit;
} else {
    // Mostrar error de consulta
    echo "Error al actualizar el convenio: " . $stmt_update->error;
    exit;
}
?>