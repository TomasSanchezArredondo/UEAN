<?php
include 'conexion.php'; // Incluye la conexión a la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_entidad = $_POST['id_entidad'];
    $tipo_convenio_general = $_POST['tipo_convenio_general'];
    $tipo_convenio = $_POST['tipo_convenio'];
    $observaciones = $_POST['observaciones'];
    $fecha_firma_convenio = $_POST['fecha_firma_convenio'] ?? null;
    $firma_convenio = $_POST['firma_convenio'] ?? null;
    $convenio_file = $_FILES['convenio_file'];

    // Subir archivo con nombre aleatorio
    $upload_dir = 'uploads/';
    $original_name = basename($convenio_file['name']);
    $extension = pathinfo($original_name, PATHINFO_EXTENSION); // Obtiene la extensión
    $random_name = uniqid('file_', true) . '.' . $extension;   // Genera un nombre único
    $file_path = $upload_dir . $random_name;

    if (move_uploaded_file($convenio_file['tmp_name'], $file_path)) {
        if ($tipo_convenio_general === 'pasantia-beneficio') {
            $query = "INSERT INTO convenios_pasantia_beneficios (id_entidad, tipo_convenio, observaciones, convenio_file, fecha_firma_convenio) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issss", $id_entidad, $tipo_convenio, $observaciones, $file_path, $fecha_firma_convenio);
        } else if ($tipo_convenio_general === 'otros') {
            $adendas_cantidad = $_POST['adendas_cantidad'] ?? null;

            // Validar fecha de firma según el valor de firma_convenio
            if ($firma_convenio === 'No') {
                $fecha_firma_convenio = null;
            }

            $query = "INSERT INTO convenio_otros (id_entidad, tipo_convenio, firma_convenio, fecha_firma_convenio, adendas_cantidad, observaciones, convenio_file) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isssiss", $id_entidad, $tipo_convenio, $firma_convenio, $fecha_firma_convenio, $adendas_cantidad, $observaciones, $file_path);
        }

        if ($stmt->execute()) {
            header('Location: lista_convenios.php');
        } else {
            echo "Error al guardar el convenio: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error al subir el archivo.";
    }

    $conn->close();
}