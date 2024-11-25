<?php
require 'conexion.php';
include 'navbar.php';

// Obtener el ID del alumno desde la URL
$id_alumno = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id_alumno) {
    die('ID de alumno no especificado.');
}

// Consultar los datos del alumno
$query = "SELECT * FROM alumno WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Alumno no encontrado.');
}

$alumno = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Perfil del Alumno</h1>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Datos del Alumno</h5>
            <ul class="list-group">
                <li class="list-group-item"><strong>ID:</strong> <?= htmlspecialchars($alumno['id']) ?></li>
                <li class="list-group-item"><strong>Nombres:</strong> <?= htmlspecialchars($alumno['nombres']) ?></li>
                <li class="list-group-item"><strong>Apellidos:</strong> <?= htmlspecialchars($alumno['apellidos']) ?></li>
                <li class="list-group-item"><strong>DNI:</strong> <?= htmlspecialchars($alumno['dni']) ?></li>
                <li class="list-group-item"><strong>Carrera:</strong> <?= htmlspecialchars($alumno['carrera']) ?></li>
                <li class="list-group-item"><strong>Pasantía:</strong> <?= htmlspecialchars($alumno['pasantia']) ?></li>
                <li class="list-group-item"><strong>Fecha de Inicio:</strong> <?= htmlspecialchars($alumno['fecha_inicio']) ?></li>
                <li class="list-group-item"><strong>Fecha de Fin:</strong> <?= htmlspecialchars($alumno['fecha_fin']) ?></li>
                <li class="list-group-item"><strong>Puesto:</strong> <?= htmlspecialchars($alumno['puesto']) ?></li>
                <li class="list-group-item"><strong>Observaciones:</strong> <?= htmlspecialchars($alumno['observaciones']) ?></li>
                <li class="list-group-item">
                    <strong>Archivo de Convenio:</strong>
                    <?php if ($alumno['convenio_file']): ?>
                        <a href="<?= htmlspecialchars($alumno['convenio_file']) ?>" target="_blank">Abrir Convenio</a>
                    <?php else: ?>
                        No disponible.
                    <?php endif; ?>
                </li>
            </ul>
            <a href="editar_alumno.php?id=<?= htmlspecialchars($alumno['id']) ?>" class="btn btn-primary btn-sm">Editar</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>