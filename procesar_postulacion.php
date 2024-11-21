<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $id_empleo = $_POST['id_empleo'];

    // Subir el archivo CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cv_tmp_name = $_FILES['cv']['tmp_name'];
        $cv_name = $_FILES['cv']['name'];
        $cv_path = 'uploads/cvs/' . $cv_name;  // Ruta donde guardar el CV

        if (move_uploaded_file($cv_tmp_name, $cv_path)) {
            // Insertar postulante en la base de datos
            $query = "INSERT INTO postulante (nombres, apellidos, CV) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $nombre, $apellido, $cv_path);
            $stmt->execute();

            // Obtener el ID del postulante insertado
            $postulante_id = $stmt->insert_id;

            // Asociar el postulante con el empleo
            $query_empleo = "INSERT INTO postulante_empleo (id_postulante, id_empleo) VALUES (?, ?)";
            $stmt_empleo = $conn->prepare($query_empleo);
            $stmt_empleo->bind_param('ii', $postulante_id, $id_empleo);
            $stmt_empleo->execute();

             header("Location:./aplicar_lista_empleo.php");
        } else {
            echo "Error al subir el CV.";
        }
    }
}
?>
