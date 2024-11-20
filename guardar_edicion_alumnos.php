<?php
require 'conexion.php';

// Verificar que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $pasantia = $_POST['pasantia'];
    $dni = intval($_POST['dni']);
    $carrera = $_POST['carrera'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
    $observaciones = $_POST['observaciones'];
    $puesto = $_POST['puesto'];

    // Manejo del archivo de convenio
    $convenio_file = null;
    $upload_dir = 'uploads/'; // Directorio para guardar archivos
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Crear el directorio si no existe
    }

    if (isset($_FILES['convenio_file']) && $_FILES['convenio_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['convenio_file']['tmp_name'];
        $file_name = basename($_FILES['convenio_file']['name']);
        $file_path = $upload_dir . time() . '_' . $file_name;

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($file_tmp, $file_path)) {
            $convenio_file = $file_path;
        } else {
            die("Error al subir el archivo.");
        }
    }

    // Obtener el archivo actual (si no se subió uno nuevo)
    if (is_null($convenio_file)) {
        $query = "SELECT convenio_file FROM alumno WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $convenio_file = $row['convenio_file'];
        }
        $stmt->close();
    }

    // Actualizar datos del alumno
    $query = "UPDATE alumno 
              SET nombres = ?, apellidos = ?, pasantía = ?, dni = ?, carrera = ?, 
                  fecha_inicio = ?, fecha_fin = ?, observaciones = ?, puesto = ?, convenio_file = ? 
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssissssssi",
        $nombres,
        $apellidos,
        $pasantia,
        $dni,
        $carrera,
        $fecha_inicio,
        $fecha_fin,
        $observaciones,
        $puesto,
        $convenio_file,
        $id
    );

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.";
        echo '<a href="listar_alumnos.php" class="btn btn-primary">Volver a la lista</a>';
    } else {
        echo "Error al actualizar los datos: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Solicitud no válida.";
}

$conn->close();
?>