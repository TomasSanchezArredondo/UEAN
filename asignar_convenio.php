<?php
require 'conexion.php';
include 'navbar.php';

// Obtener el ID del alumno
$id_alumno = isset($_GET['id']) ? (int) $_GET['id'] : null;
if (!$id_alumno) {
    die("ID de alumno no proporcionado.");
}

// Obtener el nombre del alumno
$alumno_query = "SELECT nombres, apellidos FROM alumno WHERE id = ?";
$stmt = $conn->prepare($alumno_query);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$alumno_result = $stmt->get_result();

if ($alumno_result->num_rows === 0) {
    die("Alumno no encontrado.");
}

$alumno = $alumno_result->fetch_assoc();
$nombre_alumno = htmlspecialchars($alumno['nombres'] . ' ' . $alumno['apellidos']);
$stmt->close();

// Obtener las tablas disponibles para selección
$tipos_tablas = ['convenio_otros', 'convenios_pasantia_beneficios'];

// Proceso al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tabla_seleccionada = $_POST['tabla'];
    $tipo_convenio = $_POST['tipo_convenio'];
    $id_entidad = $_POST['entidad'];
    
    if ($tabla_seleccionada && $tipo_convenio && $id_entidad) {
        if ($tabla_seleccionada === 'convenio_otros') {
            // Guardar en la tabla convenio_otros_alumno
            $query = "INSERT INTO convenio_otros_alumno (id_alumno, id_convenio_otros) 
                      SELECT ?, id FROM convenio_otros 
                      WHERE tipo_convenio = ? AND id_entidad = ?";
        } elseif ($tabla_seleccionada === 'convenios_pasantia_beneficios') {
            // Guardar en la tabla convenio_pasantia_beneficio_alumno
            $query = "INSERT INTO convenio_pasantia_beneficio_alumno (id_alumno, id_convenio_beneficio) 
                      SELECT ?, id FROM convenios_pasantia_beneficios 
                      WHERE tipo_convenio = ? AND id_entidad = ?";
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $id_alumno, $tipo_convenio, $id_entidad);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>Convenio asignado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error al asignar el convenio: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-warning text-center'>Por favor, complete todos los campos.</div>";
    }
}

// Obtener los tipos de convenio y entidades por tabla
$tipos_convenio = [];
$entidades = [];
foreach ($tipos_tablas as $tabla) {
    $tipo_query = "SELECT DISTINCT tipo_convenio FROM $tabla";
    $tipo_result = $conn->query($tipo_query);
    $tipos_convenio[$tabla] = $tipo_result ? $tipo_result->fetch_all(MYSQLI_ASSOC) : [];

    $entidad_query = "SELECT e.id, e.nombre 
                      FROM entidad e 
                      JOIN $tabla c ON e.id = c.id_entidad";
    $entidad_result = $conn->query($entidad_query);
    $entidades[$tabla] = $entidad_result ? $entidad_result->fetch_all(MYSQLI_ASSOC) : [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Convenio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Asignar Convenio a <span class="text-primary"><?= $nombre_alumno ?></span></h1>
        <form method="POST">
            <input type="hidden" name="id_alumno" value="<?= htmlspecialchars($id_alumno) ?>">

            <!-- Selección de tabla -->
            <div class="mb-4">
                <label for="tabla" class="form-label">Seleccionar Tabla</label>
                <select class="form-select" id="tabla" name="tabla" required onchange="updateFields(this.value)">
                    <option value="" disabled selected>Seleccione una tabla</option>
                    <?php foreach ($tipos_tablas as $tabla): ?>
                        <option value="<?= htmlspecialchars($tabla) ?>"><?= htmlspecialchars($tabla) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Selección de tipo de convenio -->
            <div class="mb-4">
                <label for="tipo_convenio" class="form-label">Tipo de Convenio</label>
                <select class="form-select" id="tipo_convenio" name="tipo_convenio" required>
                    <option value="" disabled selected>Seleccione un tipo de convenio</option>
                </select>
            </div>

            <!-- Selección de entidad -->
            <div class="mb-4">
                <label for="entidad" class="form-label">Entidad</label>
                <select class="form-select" id="entidad" name="entidad" required>
                    <option value="" disabled selected>Seleccione una entidad</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Asignar Convenio</button>
        </form>
    </div>

    <script>
        const tiposConvenio = <?= json_encode($tipos_convenio) ?>;
        const entidades = <?= json_encode($entidades) ?>;

        function updateFields(tabla) {
            // Actualizar tipos de convenio
            const tipoSelect = document.getElementById('tipo_convenio');
            tipoSelect.innerHTML = '<option value="" disabled selected>Seleccione un tipo de convenio</option>';
            if (tiposConvenio[tabla]) {
                tiposConvenio[tabla].forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo.tipo_convenio;
                    option.textContent = tipo.tipo_convenio;
                    tipoSelect.appendChild(option);
                });
            }

            // Actualizar entidades
            const entidadSelect = document.getElementById('entidad');
            entidadSelect.innerHTML = '<option value="" disabled selected>Seleccione una entidad</option>';
            if (entidades[tabla]) {
                entidades[tabla].forEach(entidad => {
                    const option = document.createElement('option');
                    option.value = entidad.id;
                    option.textContent = entidad.nombre;
                    entidadSelect.appendChild(option);
                });
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>