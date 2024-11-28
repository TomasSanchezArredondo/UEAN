<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $empresa = $_POST['empresa'];
    $puesto = $_POST['puesto'];
    $requisitos = $_POST['requisitos'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $mail_contacto = $_POST['mail_contacto'];
    $beneficios = $_POST['beneficios'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];
    $fecha_limite = $_POST['fecha_limite'];
    $direccion = $_POST['direccion'];
    $area = $_POST['area'];
    $tipo = $_POST['tipo'];
    $referente_id = $_POST['referente'];
    $carrera_orientada = $_POST['carrera_orientada'];

    // Manejo de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $imagen = $_FILES['imagen'];
        $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'png'];

        if (in_array(strtolower($extension), $allowed_extensions)) {
            $imagen_path = 'uploads/' . uniqid() . '.' . $extension;
            move_uploaded_file($imagen['tmp_name'], $imagen_path);
        } else {
            die('Formato de imagen no permitido.');
        }
    } else {
        die('Error al subir la imagen.');
    }

    // Insertar empleo
    $query = "INSERT INTO empleo (empresa, puesto, requisitos, telefono_contacto, mail_contacto, beneficios, horario_inicio, horario_fin, fecha_limite, direccion, imagen, area, tipo, carrera_orientada) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssssssssss', $empresa, $puesto, $requisitos, $telefono_contacto, $mail_contacto, $beneficios, $horario_inicio, $horario_fin, $fecha_limite, $direccion, $imagen_path, $area, $tipo, $carrera_orientada);


    $empleo_id = $stmt->insert_id;

    // Relacionar con referente
    $query_referente = "INSERT INTO referente_empleo (id_referente, id_empleo) VALUES (?, ?)";
    $stmt_referente = $conn->prepare($query_referente);
    $stmt_referente->bind_param('ii', $referente_id, $empleo_id);
    $stmt_referente->execute();

    header('Location: lista_empleo.php');
    exit();
}
?>