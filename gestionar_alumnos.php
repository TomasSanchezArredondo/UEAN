<?php
include './navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Agregar alumno</h1>
        <form action="subir_alumnos.php" method="POST" enctype="multipart/form-data">
            <!-- Nombres -->
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <!-- Apellidos -->
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <!-- Pasantía -->
            <div class="mb-3">
                <label for="pasantia" class="form-label">Pasantía</label>
                <select class="form-select" id="pasantia" name="pasantia" required>
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="rentada">Rentada</option>
                    <option value="no rentada">No rentada</option>
                </select>
            </div>
            <!-- DNI -->
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="number" class="form-control" id="dni" name="dni" required>
            </div>
            <!-- Carrera -->
            <div class="mb-3">
                <label for="carrera" class="form-label">Carrera</label>
                <input type="text" class="form-control" id="carrera" name="carrera" required>
            </div>
            <!-- Fecha de inicio -->
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <!-- Fecha de fin -->
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
            </div>
            <!-- Observaciones -->
            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
            </div>
            <!-- Puesto -->
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto">
            </div>
            <!-- Botón de enviar -->
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
