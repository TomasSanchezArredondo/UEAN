<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar que se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $tipoConvenio = $_POST['tipoConvenio'] ?? ''; // Esto obtiene el tipo de convenio
    $idEntidad = $_POST['id_entidad'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';
    $fechaFirmaConvenio = $_POST['fecha_firma_convenio'] ?? '';
    $convenioFile = $_FILES['convenio_file'] ?? null;

    // Inicializar $uploadFile con un valor vacío en caso de que no se suba archivo
    $uploadFile = null;

    // Si el tipo de convenio es "Pasantía-Beneficio"
    if ($tipoConvenio === 'pasantia') {
        $tipoConvenioPasantia = $_POST['tipo_convenio'] ?? ''; // Tipo de convenio (pasantía o beneficio)
        // Verificar que el tipo de convenio esté seleccionado
        if (empty($tipoConvenioPasantia)) {
            die('El tipo de convenio para pasantía-beneficio es obligatorio.');
        }

        // Validación del archivo PDF
        if ($convenioFile && $convenioFile['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $convenioFile['tmp_name'];
            $fileName = $convenioFile['name'];
            $fileSize = $convenioFile['size'];
            $fileType = $convenioFile['type'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if ($fileExt !== 'pdf') {
                die('El archivo debe ser un PDF.');
            }

            // Mover el archivo a la carpeta deseada
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($fileName);
            move_uploaded_file($fileTmpName, $uploadFile);
        }
    }

    // Si el tipo de convenio es "Otros Convenios"
    if ($tipoConvenio === 'otros') {
        $tipoConvenioOtros = $_POST['tipo'] ?? ''; // Tipo de convenio (colaboración académica, etc.)
        $firmaConvenio = $_POST['firma_convenio'] ?? '';
        $adendasCantidad = $_POST['adendas_cantidad'] ?? '';

        // Validación para "Otros Convenios"
        if (empty($tipoConvenioOtros) || empty($firmaConvenio) || empty($adendasCantidad)) {
            die('Todos los campos son obligatorios para los otros convenios.');
        }

        // Validación del archivo PDF
        if ($convenioFile && $convenioFile['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $convenioFile['tmp_name'];
            $fileName = $convenioFile['name'];
            $fileSize = $convenioFile['size'];
            $fileType = $convenioFile['type'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if ($fileExt !== 'pdf') {
                die('El archivo debe ser un PDF.');
            }

            // Mover el archivo a la carpeta deseada
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($fileName);
            move_uploaded_file($fileTmpName, $uploadFile);
        }
    }

    // Preparar la consulta para insertar el convenio
    if ($tipoConvenio === 'pasantia') {
        $sql = "INSERT INTO convenios_pasantia_beneficios (id_entidad, tipo_convenio, observaciones, convenio_file, fecha_firma_convenio)
                VALUES (:id_entidad, :tipo_convenio, :observaciones, :convenio_file, :fecha_firma_convenio)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_entidad' => $idEntidad,
            ':tipo_convenio' => $tipoConvenioPasantia,
            ':observaciones' => $observaciones,
            ':convenio_file' => $uploadFile ?? '', // En caso de que no se suba archivo, se guarda un valor vacío
            ':fecha_firma_convenio' => $fechaFirmaConvenio
        ]);
    } elseif ($tipoConvenio === 'otros') {
        $sql = "INSERT INTO convenio_otros (id_entidad, tipo, firma_convenio, adendas_cantidad, observaciones, convenio_file, fecha_firma_convenio)
                VALUES (:id_entidad, :tipo, :firma_convenio, :adendas_cantidad, :observaciones, :convenio_file, :fecha_firma_convenio)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_entidad' => $idEntidad,
            ':tipo' => $tipoConvenioOtros,
            ':firma_convenio' => $firmaConvenio,
            ':adendas_cantidad' => $adendasCantidad,
            ':observaciones' => $observaciones,
            ':convenio_file' => $uploadFile ?? '', // En caso de que no se suba archivo, se guarda un valor vacío
            ':fecha_firma_convenio' => $fechaFirmaConvenio
        ]);
    }

    echo "Convenio registrado correctamente.";
} else {
    echo "Método de solicitud no válido.";
}
