<?php
ob_start();
include('conexion.php');
include './navbar.php';

$id_convenio = isset($_GET['id']) ? intval($_GET['id']) : 0;
$tipo_convenio = isset($_GET['tipo']) ? $_GET['tipo'] : '';

$alumnos = [];

if ($tipo_convenio === 'otros') {
    $sql = "SELECT a.id, a.nombres, a.apellidos, a.dni, a.carrera
            FROM alumno a
            INNER JOIN convenio_otros_alumno coa ON a.id = coa.id_alumno
            WHERE coa.id_convenio_otros = ?";
} elseif ($tipo_convenio === 'pasantia_beneficio') {
    $sql = "SELECT a.id, a.nombres, a.apellidos, a.dni, a.carrera
            FROM alumno a
            INNER JOIN convenio_pasantia_beneficio_alumno cpba ON a.id = cpba.id_alumno
            WHERE cpba.id_convenio_beneficio = ?";
}

if (!empty($sql)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_convenio);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $alumnos = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Eliminar relación de la tabla intermedia
if (isset($_GET['borrar']) && isset($_GET['alumno_id'])) {
    $alumno_id = intval($_GET['alumno_id']);
    if ($tipo_convenio === 'otros') {
        $delete_sql = "DELETE FROM convenio_otros_alumno WHERE id_alumno = ? AND id_convenio_otros = ?";
    } elseif ($tipo_convenio === 'pasantia_beneficio') {
        $delete_sql = "DELETE FROM convenio_pasantia_beneficio_alumno WHERE id_alumno = ? AND id_convenio_beneficio = ?";
    }

    if (!empty($delete_sql)) {
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param('ii', $alumno_id, $id_convenio);
        $delete_stmt->execute();
        header("Location: lista_alumnos_convenio.php?id=$id_convenio&tipo=$tipo_convenio");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Lista de alumnos en convenio</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Carrera</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alumnos)): ?>
                        <?php foreach ($alumnos as $alumno): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($alumno['id']); ?></td>
                                <td><?php echo htmlspecialchars($alumno['nombres']); ?></td>
                                <td><?php echo htmlspecialchars($alumno['apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($alumno['dni']); ?></td>
                                <td><?php echo htmlspecialchars($alumno['carrera']); ?></td>
                                <td>
                                    <a href="lista_alumnos_convenio.php?id=<?php echo $id_convenio; ?>&tipo=<?php echo $tipo_convenio; ?>&borrar=1&alumno_id=<?php echo $alumno['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('¿Está seguro de que desea eliminar esta relación?');">
                                        Borrar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay alumnos relacionados con este convenio</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="lista_convenios.php" class="btn btn-secondary mt-3">Volver</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php ob_end_flush(); ?>
</body>
</html>