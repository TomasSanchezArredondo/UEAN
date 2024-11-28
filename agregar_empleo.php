<?php
include 'conexion.php';
include 'navbar.php';

// Obtener referentes disponibles
$query_referentes = "SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM referente";
$result_referentes = $conn->query($query_referentes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Empleo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Agregar Empleo</h2>
    <form action="guardar_empleo.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="empresa" class="form-label">Empresa</label>
            <input type="text" class="form-control" id="empresa" name="empresa" required>
        </div>
        <div class="mb-3">
            <label for="puesto" class="form-label">Puesto</label>
            <input type="text" class="form-control" id="puesto" name="puesto" required>
        </div>
        <div class="mb-3">
            <label for="requisitos" class="form-label">Requisitos</label>
            <textarea class="form-control" id="requisitos" name="requisitos" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="carrera_orientada" class="form-label">Carrera Orientada</label>
            <input type="text" class="form-control" id="carrera_orientada" name="carrera_orientada">
        </div>
        <div class="mb-3">
            <label for="telefono_contacto" class="form-label">Teléfono de Contacto</label>
            <input type="tel" class="form-control" id="telefono_contacto" name="telefono_contacto" required>
        </div>
        <div class="mb-3">
            <label for="mail_contacto" class="form-label">Email de Contacto</label>
            <input type="email" class="form-control" id="mail_contacto" name="mail_contacto" required>
        </div>
        <div class="mb-3">
            <label for="beneficios" class="form-label">Beneficios</label>
            <textarea class="form-control" id="beneficios" name="beneficios" rows="3"></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="horario_inicio" class="form-label">Horario Inicio</label>
                <input type="time" class="form-control" id="horario_inicio" name="horario_inicio" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="horario_fin" class="form-label">Horario Fin</label>
                <input type="time" class="form-control" id="horario_fin" name="horario_fin" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="fecha_limite" class="form-label">Fecha Límite</label>
            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept=".jpg, .png" required>
        </div>
        <div class="mb-3">
            <label for="area" class="form-label">Área</label>
            <select class="form-select" id="area" name="area" required>
                <option value="">Seleccione un área</option>
                <option value="Administración">Administración</option>
                <option value="Hotelería">Hotelería</option>
                <option value="Marketing">Marketing</option>
                <option value="Negocios en internet">Negocios en internet</option>
                <option value="Negocios internacionales">Negocios internacionales</option>
                <option value="Recursos humanos">Recursos humanos</option>
                <option value="Tecnología">Tecnología</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Seleccione un tipo</option>
                <option value="Pasantía">Pasantía</option>
                <option value="Práctica no rentada">Práctica no rentada</option>
                <option value="Puesto fijo">Puesto fijo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="referente" class="form-label">Referente</label>
            <select class="form-select" id="referente" name="referente" required>
                <option value="">Seleccione un referente</option>
                <?php while ($referente = $result_referentes->fetch_assoc()): ?>
                    <option value="<?= $referente['id'] ?>"><?= $referente['nombre_completo'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Empleo</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>