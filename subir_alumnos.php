<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $pasantia = $_POST['pasantia'];
    $dni = intval($_POST['dni']);
    $carrera = $_POST['carrera'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
    $observaciones = !empty($_POST['observaciones']) ? $_POST['observaciones'] : null;
    $puesto = !empty($_POST['puesto']) ? $_POST['puesto'] : null;

    // Manejo de archivo
    $convenio_file = null;
    if (isset($_FILES['convenio_file']) && $_FILES['convenio_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Crear el directorio si no existe
        }
        $filename = basename($_FILES['convenio_file']['name']);
        $filepath = $upload_dir . uniqid() . "_" . $filename; // Evitar nombres duplicados
        if (move_uploaded_file($_FILES['convenio_file']['tmp_name'], $filepath)) {
            $convenio_file = $filepath;
        } else {
            die("Error al subir el archivo.");
        }
    }

    // Insertar datos en la base de datos
    $query = "INSERT INTO alumno (nombres, apellidos, pasantía, dni, carrera, fecha_inicio, fecha_fin, observaciones, puesto, convenio_file)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param(
            "sssissssss",
            $nombres,
            $apellidos,
            $pasantia,
            $dni,
            $carrera,
            $fecha_inicio,
            $fecha_fin,
            $observaciones,
            $puesto,
            $convenio_file
        );

        if ($stmt->execute()) {
            header("Location:./gestionar_alumnos.php");
        } else {
            echo "Error al guardar los datos: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
