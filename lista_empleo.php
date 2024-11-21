<?php
include 'conexion.php';
include 'navbar.php';

// Obtener empleos de la base de datos
$query_empleos = "SELECT id, imagen, puesto, area FROM empleo";
$result_empleos = $conn->query($query_empleos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empleos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Lista de Empleos</h1>
    <div class="row">
        <?php while ($empleo = $result_empleos->fetch_assoc()): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="<?= $empleo['imagen'] ?>" class="card-img-top" alt="Imagen de <?= $empleo['puesto'] ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Puesto: </strong><?= $empleo['puesto'] ?></h5>
                        <p class="card-text"><strong>Área:</strong> <?= $empleo['area'] ?></p>
                        <a href="detalles_empleo.php?id=<?= $empleo['id'] ?>" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
