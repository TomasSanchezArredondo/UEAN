<?php
header('Content-Type: application/json');

// Conexión a la base de datos
include 'conexion.php';

// Obtener el ID de la entidad a eliminar
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    exit;
}

// Eliminar la entidad de la base de datos
$query = "DELETE FROM entidad WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al borrar la entidad']);
}
?>
