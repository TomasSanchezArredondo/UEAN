<?php
require 'conexion.php';
include 'navbar.php';

// Obtener todas las carreras disponibles para el filtro
$carrera_query = "SELECT DISTINCT carrera FROM alumno";
$carrera_result = $conn->query($carrera_query);

if (!$carrera_result) {
    die("Error al obtener las carreras: " . $conn->error);
}

// Variables de búsqueda
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$carrera_seleccionada = isset($_GET['carrera']) ? $_GET['carrera'] : '';

// Preparar la consulta de alumnos con los filtros aplicados
$alumnos = [];
$alumno_query = "
    SELECT 
        a.*,
        COALESCE(cp.tipo_convenio, co.tipo_convenio, 'N/A') AS tipo_convenio,
        COALESCE(e.nombre, 'N/A') AS entidad_convenio
    FROM alumno a
    LEFT JOIN convenio_pasantia_beneficio_alumno cpba ON a.id = cpba.id_alumno
    LEFT JOIN convenios_pasantia_beneficios cp ON cpba.id_convenio_beneficio = cp.id
    LEFT JOIN convenio_otros_alumno coa ON a.id = coa.id_alumno
    LEFT JOIN convenio_otros co ON coa.id_convenio_otros = co.id
    LEFT JOIN entidad e ON e.id = COALESCE(cp.id_entidad, co.id_entidad)
    WHERE 1=1";  // WHERE 1=1 para poder agregar dinámicamente los filtros

// Aplicar filtros si se proporcionan
if ($buscar) {
    $alumno_query .= " AND (a.nombres LIKE ? OR a.apellidos LIKE ?)";
}
if ($carrera_seleccionada) {
    $alumno_query .= " AND a.carrera = ?";
}

$alumno_query .= " GROUP BY a.id";  // Agrupar por ID de alumno

$stmt = $conn->prepare($alumno_query);

// Vincular los parámetros
$types = '';
$params = [];
if ($buscar) {
    $types .= 'ss';  // Dos parámetros de tipo string (nombre y apellido)
    $params[] = "%$buscar%";
    $params[] = "%$buscar%";
}
if ($carrera_seleccionada) {
    $types .= 's';
    $params[] = $carrera_seleccionada;
}

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$alumnos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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

        <!-- Filtros y barra de búsqueda en el mismo contenedor -->
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" id="buscar" name="buscar" value="<?= htmlspecialchars($buscar) ?>" placeholder="Buscar por nombre o apellido">
                </div>
                <div class="col-md-5 mb-3">
                    <select class="form-select" id="carrera" name="carrera">
                        <option value="" disabled <?= !$carrera_seleccionada ? 'selected' : '' ?>>Seleccione una carrera</option>
                        <?php while ($row = $carrera_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['carrera']) ?>" <?= $row['carrera'] === $carrera_seleccionada ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['carrera']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-1 mb-3">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabla de alumnos -->
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
                        <th>Tipo de Convenio</th>
                        <th>Entidad del Convenio</th>
                        <th>Acciones</th>
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
                            <td><?= htmlspecialchars($alumno['tipo_convenio']) ?></td>
                            <td><?= htmlspecialchars($alumno['entidad_convenio']) ?></td>
                            <td>
                                <a href="perfil_alumno.php?id=<?= htmlspecialchars($alumno['id']) ?>" class="btn btn-info btn-sm">Perfil</a>
                                <a href="asignar_convenio.php?id=<?= htmlspecialchars($alumno['id']) ?>" class="btn btn-success btn-sm">Asignar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-danger">No hay alumnos registrados con esos filtros.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>