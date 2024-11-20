<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $sector = $_POST['sector'];
    $direccion = $_POST['direccion'];
    $id_referente = $_POST['id_referente'];

    $stmt = $conn->prepare("INSERT INTO entidad (nombre, sector, direccion, id_referente) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $sector, $direccion, $id_referente);

    if ($stmt->execute()) {
        header("Location: gestionar_entidades.php?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
