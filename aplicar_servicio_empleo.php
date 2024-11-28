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
            <?php endif; ?>
        </div>

    <!-- Botón para postularse -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postulateModal">
        Postúlate
    </button>

    <!-- Modal de postulación -->
    <div class="modal fade" id="postulateModal" tabindex="-1" aria-labelledby="postulateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postulateModalLabel">Formulario de Postulación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para postularse -->
                    <form action="procesar_postulacion.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="cv" class="form-label">CV</label>
                            <input type="file" class="form-control" id="cv" name="cv" required>
                        </div>
                        <input type="hidden" name="id_empleo" value="<?= $id_empleo ?>">
                        <div class="d-inline-block">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#postulateModal">
                                Postúlate
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
