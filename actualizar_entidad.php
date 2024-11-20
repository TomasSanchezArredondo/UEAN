<?php
header('Content-Type: application/json');

// Conexión a la base de datos
include 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Datos no recibidos']);
    exit;
}

// Obtener datos del JSON
$id = $data['id'] ?? null;
$nombre = $data['nombre'] ?? null;
$sector = $data['sector'] ?? null;
$direccion = $data['direccion'] ?? null;
$idReferente = $data['idReferente'] ?? null;

// Validar datos
if (!$id || !$nombre || !$sector || !$direccion || !$idReferente) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Actualizar la entidad
$query = "UPDATE entidad SET nombre=?, sector=?, direccion=?, id_referente=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $nombre, $sector, $direccion, $idReferente, $id);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar la entidad']);
}
?>
