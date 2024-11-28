<?php
include 'conexion.php';
include 'navbar.php';

// Obtener ID del empleo desde la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de empleo no proporcionado.");
}
$id_empleo = $_GET['id'];

// Obtener los datos actuales del empleo
$query_empleo = "
    SELECT e.*, 
           CONCAT(r.nombres, ' ', r.apellidos) AS nombre_referente, 
           er.id_referente 
    FROM empleo e
    LEFT JOIN referente_empleo er ON e.id = er.id_empleo
    LEFT JOIN referente r ON er.id_referente = r.id
    WHERE e.id = ?";
$stmt_empleo = $conn->prepare($query_empleo);
$stmt_empleo->bind_param('i', $id_empleo);
$stmt_empleo->execute();
$result_empleo = $stmt_empleo->get_result();
$empleo = $result_empleo->fetch_assoc();

if (!$empleo) {
    die("Empleo no encontrado.");
}

// Obtener referentes disponibles
$query_referentes = "SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM referente";
$result_referentes = $conn->query($query_referentes);

// Obtener los valores del ENUM para 'area' y 'tipo'
$query_enum_area = "SHOW COLUMNS FROM empleo LIKE 'area'";
$result_enum_area = $conn->query($query_enum_area);
$row_enum_area = $result_enum_area->fetch_assoc();
$area_enum_values = str_replace(["enum(", ")"], "", $row_enum_area['Type']);
$area_enum_values = explode(",", $area_enum_values);

$query_enum_tipo = "SHOW COLUMNS FROM empleo LIKE 'tipo'";
$result_enum_tipo = $conn->query($query_enum_tipo);
$row_enum_tipo = $result_enum_tipo->fetch_assoc();
$tipo_enum_values = str_replace(["enum(", ")"], "", $row_enum_tipo['Type']);
$tipo_enum_values = explode(",", $tipo_enum_values);

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresa = $_POST['empresa'];
    $puesto = $_POST['puesto'];
    $requisitos = $_POST['requisitos'];
    $carrera_orientada = $_POST['carrera_orientada'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $mail_contacto = $_POST['mail_contacto'];
    $beneficios = $_POST['beneficios'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];
    $fecha_limite = $_POST['fecha_limite'];
    $direccion = $_POST['direccion'];
    $area = $_POST['area'];
    $tipo = $_POST['tipo'];
    $referente = $_POST['referente'];

    // Manejar la subida de la imagen si se carga una nueva
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_destino = 'imagenes/' . $imagen_nombre;
        move_uploaded_file($imagen_tmp, $imagen_destino);
    } else {
        $imagen_destino = $empleo['imagen']; // Si no se sube una nueva, mantener la actual
    }

    // Actualizar los datos en la base de datos
    $query_update = "
        UPDATE empleo SET 
            empresa = ?, puesto = ?, requisitos = ?, carrera_orientada = ?, telefono_contacto = ?, 
            mail_contacto = ?, beneficios = ?, horario_inicio = ?, horario_fin = ?, fecha_limite = ?, 
            direccion = ?, imagen = ?, area = ?, tipo = ?
        WHERE id = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param(
        'sssssssssssssi',
        $empresa, $puesto, $requisitos, $carrera_orientada, $telefono_contacto, 
        $mail_contacto, $beneficios, $horario_inicio, $horario_fin, $fecha_limite, 
        $direccion, $imagen_destino, $area, $tipo, $id_empleo
    );
    $stmt_update->execute();

    // Actualizar el referente en la tabla intermedia
    $query_update_referente = "
        INSERT INTO empleo_referente (id_empleo, id_referente) 
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE id_referente = ?";
    $stmt_update_referente = $conn->prepare($query_update_referente);
    $stmt_update_referente->bind_param('iii', $id_empleo, $referente, $referente);
    $stmt_update_referente->execute();

    // Redirigir a los detalles del empleo tras la actualización
    header('Location: detalles_empleo.php?id=' . $id_empleo);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Empleo</h2>
    <form action="editar_detalles_empleo.php?id=<?= $id_empleo ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="empresa" class="form-label">Empresa</label>
            <input type="text" class="form-control" id="empresa" name="empresa" value="<?= $empleo['empresa'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="puesto" class="form-label">Puesto</label>
            <input type="text" class="form-control" id="puesto" name="puesto" value="<?= $empleo['puesto'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="requisitos" class="form-label">Requisitos</label>
            <textarea class="form-control" id="requisitos" name="requisitos" rows="3" required><?= $empleo['requisitos'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="carrera_orientada" class="form-label">Carrera Orientada</label>
            <input type="text" class="form-control" id="carrera_orientada" name="carrera_orientada" value="<?= $empleo['carrera_orientada'] ?>">
        </div>
        <div class="mb-3">
            <label for="telefono_contacto" class="form-label">Teléfono de Contacto</label>
            <input type="tel" class="form-control" id="telefono_contacto" name="telefono_contacto" value="<?= $empleo['telefono_contacto'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="mail_contacto" class="form-label">Email de Contacto</label>
            <input type="email" class="form-control" id="mail_contacto" name="mail_contacto" value="<?= $empleo['mail_contacto'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="beneficios" class="form-label">Beneficios</label>
            <textarea class="form-control" id="beneficios" name="beneficios" rows="3"><?= $empleo['beneficios'] ?></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="horario_inicio" class="form-label">Horario Inicio</label>
                <input type="time" class="form-control" id="horario_inicio" name="horario_inicio" value="<?= $empleo['horario_inicio'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="horario_fin" class="form-label">Horario Fin</label>
                <input type="time" class="form-control" id="horario_fin" name="horario_fin" value="<?= $empleo['horario_fin'] ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="fecha_limite" class="form-label">Fecha Límite</label>
            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" value="<?= $empleo['fecha_limite'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $empleo['direccion'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
            <?php if ($empleo['imagen']): ?>
                <img src="<?= $empleo['imagen'] ?>" alt="Imagen Actual" class="mt-3" width="100">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="area" class="form-label">Área</label>
            <select class="form-select" id="area" name="area" required>
                <option value="">Seleccione un área</option>
                <?php foreach ($area_enum_values as $value): ?>
                    <option value="<?= $value ?>" <?= $empleo['area'] == $value ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Seleccione un tipo</option>
                <?php foreach ($tipo_enum_values as $value): ?>
                    <option value="<?= $value ?>" <?= $empleo['tipo'] == $value ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="referente" class="form-label">Referente</label>
            <select class="form-select" id="referente" name="referente" required>
                <option value="">Seleccione un referente</option>
                <?php while ($referente = $result_referentes->fetch_assoc()): ?>
                    <option value="<?= $referente['id'] ?>" <?= $referente['id'] == $empleo['id_referente'] ? 'selected' : '' ?>>
                        <?= $referente['nombre_completo'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Empleo</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>