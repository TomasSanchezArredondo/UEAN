<?php
include 'conexion.php'; // Conexión a la base de datos
include 'navbar.php'; // Barra de navegación

// Obtener referentes de la base de datos
$query = "SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM referente";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Entidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Añadir Entidades</h2>
    <form action="procesar_entidad.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="sector" class="form-label">Sector</label>
            <input type="text" class="form-control" id="sector" name="sector" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <div class="mb-3">
            <label for="id_referente" class="form-label">Referente</label>
            <select class="form-select" id="id_referente" name="id_referente" required>
                <option value="" selected disabled>Seleccionar un referente</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id']; ?>"><?= $row['nombre_completo']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Añadir Entidad</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
