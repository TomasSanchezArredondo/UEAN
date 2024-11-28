<?php
include 'conexion.php';
include 'navbar.php';

// Obtener ID del empleo desde la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de empleo no proporcionado.");
}
$id_empleo = $_GET['id'];

// Obtener datos del empleo
$query_empleo = "
    SELECT e.*, CONCAT(r.nombres, ' ', r.apellidos) AS nombre_referente 
    FROM empleo e
    LEFT JOIN referente_empleo re ON e.id = re.id_empleo
    LEFT JOIN referente r ON re.id_referente = r.id
    WHERE e.id = ?";
$stmt_empleo = $conn->prepare($query_empleo);
$stmt_empleo->bind_param('i', $id_empleo);
$stmt_empleo->execute();
$result_empleo = $stmt_empleo->get_result();
$empleo = $result_empleo->fetch_assoc();

if (!$empleo) {
    die("Empleo no encontrado.");
}

// Obtener postulantes relacionados
$query_postulantes = "
    SELECT p.id, p.nombres, p.apellidos, p.CV 
    FROM postulante p
    INNER JOIN postulante_empleo pe ON p.id = pe.id_postulante
    WHERE pe.id_empleo = ?";
$stmt_postulantes = $conn->prepare($query_postulantes);
$stmt_postulantes->bind_param('i', $id_empleo);
$stmt_postulantes->execute();
$result_postulantes = $stmt_postulantes->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Empleo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Detalles del Empleo</h1>
<?php
// Contar la cantidad de postulantes relacionados
$cantidad_postulantes = $result_postulantes->num_rows;
?>

<div class="container mt-5">
    <!-- Contenedor principal con dos columnas -->
    <div class="row">
        <!-- Columna para los datos -->
        <div class="col-md-8">
            <ul class="list-group">
                <?php foreach ($empleo as $campo => $valor): ?>
                    <?php if ($campo !== 'imagen' && $campo !== 'id'): ?>
                        <li class="list-group-item">
                            <strong><?= ucfirst(str_replace('_', ' ', $campo)) ?>:</strong> <?= $valor ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Columna para la imagen -->
        <div class="col-md-4">
            <?php if (!empty($empleo['imagen'])): ?>
                <img src="<?= $empleo['imagen'] ?>" alt="Imagen del empleo" class="img-fluid mb-3" style="max-width: 100%; height: 50%;">
                <!-- Botón para redirigir a la edición -->
                <a href="editar_empleo.php?id=<?= $empleo['id'] ?>" class="btn btn-warning mt-3">Editar Detalles del Empleo</a>
            <?php endif; ?>
        </div>
    <!-- Tabla de postulantes -->
    <h2 class="mb-3 mt-4">
        Postulantes 
        <small class="text-muted">(Cantidad de postulantes: <?= $cantidad_postulantes ?>)</small>
    </h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>CV</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($cantidad_postulantes > 0): ?>
            <?php while ($postulante = $result_postulantes->fetch_assoc()): ?>
                <tr>
                    <td><?= $postulante['nombres'] ?></td>
                    <td><?= $postulante['apellidos'] ?></td>
                    <td>
                        <a href="<?= $postulante['CV'] ?>" target="_blank">Ver CV</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No hay postulantes para este empleo.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
