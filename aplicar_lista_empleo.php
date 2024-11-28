<?php
include 'conexion.php';
include 'navbar.php';

// Enumeraciones manuales para área y tipo
$areas_enum = ['Administración', 'Hotelería', 'Marketing', 'Negocios en internet', 'Negocios internacionales', 'Recursos humanos', 'Tecnología'];
$tipos_enum = ['Pasantía', 'Práctica no rentada', 'Puesto fijo'];

// Inicializamos las variables de filtro
$area_filter = isset($_GET['area']) ? $_GET['area'] : '';
$tipo_filter = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$carrera_filter = isset($_GET['carrera_orientada']) ? $_GET['carrera_orientada'] : '';

// Consulta principal de empleos
$query_empleos = "SELECT id, imagen, puesto, area, tipo, carrera_orientada FROM empleo WHERE 1";

if ($area_filter) {
    $query_empleos .= " AND area = '$area_filter'";
}
if ($tipo_filter) {
    $query_empleos .= " AND tipo = '$tipo_filter'";
}
if ($carrera_filter) {
    $query_empleos .= " AND carrera_orientada LIKE '%$carrera_filter%'";
}
$query_empleos .= " ORDER BY id";
$result_empleos = $conn->query($query_empleos);

$query_carreras = "SELECT DISTINCT carrera_orientada FROM empleo WHERE carrera_orientada IS NOT NULL AND carrera_orientada != ''";
$result_carreras = $conn->query($query_carreras);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empleos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="lista.css">
</head>
<body>
<div class="container-fluid mt-4">
    <div class="main-container">
        <!-- Filtros -->
        <div class="filters card p-3">
            
            <h5 class="mb-1">Filtros</h5>
            <form action="lista_empleo.php" method="GET">
                <!-- Filtro por área -->
                <div class="mb-2">
                    <label for="area" class="form-label">Área</label>
                    <select class="form-select" name="area" id="area">
                        <option value="">Selecciona un área</option>
                        <?php foreach ($areas_enum as $area): ?>
                            <option value="<?= $area ?>" <?= $area == $area_filter ? 'selected' : '' ?>><?= $area ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Filtro por tipo -->
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" name="tipo" id="tipo">
                        <option value="">Selecciona un tipo</option>
                        <?php foreach ($tipos_enum as $tipo): ?>
                            <option value="<?= $tipo ?>" <?= $tipo == $tipo_filter ? 'selected' : '' ?>><?= $tipo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Filtro por carrera orientada -->
                <div class="mb-3">
                    <label for="carrera_orientada" class="form-label">Carrera Orientada</label>
                    <select class="form-select" name="carrera_orientada" id="carrera_orientada">
                        <option value="">Selecciona una carrera</option>
                        <?php while ($carrera = $result_carreras->fetch_assoc()): ?>
                            <option value="<?= $carrera['carrera_orientada'] ?>" <?= $carrera['carrera_orientada'] == $carrera_filter ? 'selected' : '' ?>><?= $carrera['carrera_orientada'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Botón de aplicar filtros -->
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </form>
        </div>

        <!-- Tarjetas de empleos -->
        <div class="cards">
            <h1 class="mb-4">Lista de Empleos</h1>
            <?php if ($result_empleos->num_rows > 0): ?>
                <div class="row">
                    <?php while ($empleo = $result_empleos->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?= $empleo['imagen'] ?>" class="card-img-top" alt="Imagen de <?= $empleo['puesto'] ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Puesto: </strong><?= $empleo['puesto'] ?></h5>
                                    <p class="card-text"><strong>Área:</strong> <?= $empleo['area'] ?></p>
                                    <p class="card-text"><strong>Tipo:</strong> <?= $empleo['tipo'] ?></p>
                                    <a href="aplicar_servicio_empleo.php?id=<?= $empleo['id'] ?>" class="btn btn-primary">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    No hay empleos disponibles con los filtros seleccionados.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>