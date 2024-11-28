<?php
ob_start();
require 'conexion.php';
include 'navbar.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $pasantia = $_POST['pasantia'];
    $dni = $_POST['dni'];
    $carrera = $_POST['carrera'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $observaciones = $_POST['observaciones'];
    $puesto = $_POST['puesto'];
    $convenio_file_path = null;

    // Manejar la subida del archivo
    if (isset($_FILES['convenio_file']) && $_FILES['convenio_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['convenio_file']['name']);
        $target_path = $upload_dir . uniqid() . '_' . $file_name;

        if (move_uploaded_file($_FILES['convenio_file']['tmp_name'], $target_path)) {
            $convenio_file_path = $target_path;
        } else {
            die("Error al subir el archivo.");
        }
    }

    // Actualizar los datos en la base de datos
    $query = "UPDATE alumno SET 
                nombres = ?, 
                apellidos = ?, 
                pasantía = ?, 
                dni = ?, 
                carrera = ?, 
                fecha_inicio = ?, 
                fecha_fin = ?, 
                observaciones = ?, 
                puesto = ?";

    if ($convenio_file_path) {
        $query .= ", convenio_file = ?";
    }
    
    $query .= " WHERE id = ?";

    $stmt = $conn->prepare($query);

    if ($convenio_file_path) {
        $stmt->bind_param(
            "ssssssssssi",
            $nombres,
            $apellidos,
            $pasantia,
            $dni,
            $carrera,
            $fecha_inicio,
            $fecha_fin,
            $observaciones,
            $puesto,
            $convenio_file_path,
            $id
        );
    } else {
        $stmt->bind_param(
            "sssssssssi",
            $nombres,
            $apellidos,
            $pasantia,
            $dni,
            $carrera,
            $fecha_inicio,
            $fecha_fin,
            $observaciones,
            $puesto,
            $id
        );
    }

    if ($stmt->execute()) {
        header("Location: perfil_alumno.php?id=$id");
        exit();
    } else {
        die("Error al actualizar los datos del alumno.");
    }
}

// Verificar que se haya recibido un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de alumno no especificado.");
}

$id = intval($_GET['id']);

// Obtener los datos del alumno
$query = "SELECT * FROM alumno WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Alumno no encontrado.");
}

$alumno = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Alumno</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($alumno['id']) ?>">
            
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?= htmlspecialchars($alumno['nombres']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($alumno['apellidos']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="pasantia" class="form-label">Pasantía</label>
                <select class="form-select" id="pasantia" name="pasantia" required>
                    <option value="rentada" <?= $alumno['pasantía'] === 'rentada' ? 'selected' : '' ?>>Rentada</option>
                    <option value="no rentada" <?= $alumno['pasantía'] === 'no rentada' ? 'selected' : '' ?>>No Rentada</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="number" class="form-control" id="dni" name="dni" value="<?= htmlspecialchars($alumno['dni']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="carrera" class="form-label">Carrera</label>
                <input type="text" class="form-control" id="carrera" name="carrera" value="<?= htmlspecialchars($alumno['carrera']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($alumno['fecha_inicio']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($alumno['fecha_fin']) ?>">
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones"><?= htmlspecialchars($alumno['observaciones']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto" value="<?= htmlspecialchars($alumno['puesto']) ?>">
            </div>

            <div class="mb-3">
                <label for="convenio_file" class="form-label">Archivo de Convenio</label>
                <input type="file" class="form-control" id="convenio_file" name="convenio_file">
                <?php if (!empty($alumno['convenio_file'])): ?>
                    <p class="mt-2">Archivo actual: <a href="<?= htmlspecialchars($alumno['convenio_file']) ?>" target="_blank">Ver archivo</a></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="listar_alumnos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
ob_end_flush(); 
?>