<?php
require 'conexion.php';
include 'navbar.php';

// Obtener todas las carreras disponibles
$carrera_query = "SELECT DISTINCT carrera FROM alumno";
$carrera_result = $conn->query($carrera_query);

if (!$carrera_result) {
    die("Error al obtener las carreras: " . $conn->error);
}

// Carrera seleccionada por defecto
$carrera_seleccionada = isset($_GET['carrera']) ? $_GET['carrera'] : null;

// Obtener los alumnos de la carrera seleccionada, excluyendo los graduados
$alumnos = [];
if ($carrera_seleccionada) {
    $alumno_query = "SELECT * FROM alumno WHERE carrera = ? AND es_graduado = 'NO'";
    $stmt = $conn->prepare($alumno_query);
    $stmt->bind_param("s", $carrera_seleccionada);
    $stmt->execute();
    $result = $stmt->get_result();
    $alumnos = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Lista de Alumnos</h1>

        <!-- Selector de carreras -->
        <form method="GET" class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-100">
                    <label for="carrera" class="form-label">Seleccionar Carrera</label>
                    <select class="form-select" id="carrera" name="carrera" onchange="this.form.submit()">
                        <option value="" disabled <?= !$carrera_seleccionada ? 'selected' : '' ?>>Seleccione una carrera</option>
                        <?php while ($row = $carrera_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['carrera']) ?>" <?= $row['carrera'] === $carrera_seleccionada ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['carrera']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
        </form>

        <!-- Tabla de alumnos -->
        <?php if ($carrera_seleccionada): ?>
            <?php if (!empty($alumnos)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>DNI</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alumnos as $alumno): ?>
                            <tr>
                                <td><?= htmlspecialchars($alumno['id']) ?></td>
                                <td><?= htmlspecialchars($alumno['nombres']) ?></td>
                                <td><?= htmlspecialchars($alumno['apellidos']) ?></td>
                                <td><?= htmlspecialchars($alumno['dni']) ?></td>
                                <td><?= htmlspecialchars($alumno['fecha_inicio']) ?></td>
                                <td><?= htmlspecialchars($alumno['fecha_fin']) ?></td>
                                <td>
                                    <a href="editar_alumno.php?id=<?= htmlspecialchars($alumno['id']) ?>" class="btn btn-primary btn-sm">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-danger">No hay alumnos registrados en esta carrera.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-info">Seleccione una carrera para ver los alumnos.</p>
        <?php endif; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php $conn->close(); ?>