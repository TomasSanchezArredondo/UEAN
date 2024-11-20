<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

// Obtener las entidades para mostrarlas en el formulario
$query = "SELECT id, nombre FROM entidad";
$result = $conn->query($query);
$entidades = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Convenio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestionar Convenio</h2>
        <form action="procesar_convenio.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="entidad" class="form-label">Entidad</label>
                <select id="entidad" name="id_entidad" class="form-select" required>
                    <option value="">Seleccione una entidad</option>
                    <?php foreach ($entidades as $entidad): ?>
                        <option value="<?= $entidad['id'] ?>"><?= $entidad['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="tipo_convenio_general" class="form-label">Tipo de Convenio</label>
                <select id="tipo_convenio_general" name="tipo_convenio_general" class="form-select" required>
                    <option value="">Seleccione un tipo de convenio</option>
                    <option value="pasantia-beneficio">Pasantía / Beneficio</option>
                    <option value="otros">Otros Convenios</option>
                </select>
            </div>

            <div id="formulario-dinamico"></div>

            <button type="submit" class="btn btn-primary mt-3">Guardar Convenio</button>
        </form>
 

        <div id="formulario-dinamico"></div>

<script>
    document.getElementById('tipo_convenio_general').addEventListener('change', function() {
        const tipoConvenio = this.value;
        const formularioDinamico = document.getElementById('formulario-dinamico');

        formularioDinamico.innerHTML = ''; // Limpiar el formulario dinámico

        if (tipoConvenio === 'pasantia-beneficio') {
            formularioDinamico.innerHTML = `
                <div class="mb-3">
                    <label for="tipo_convenio" class="form-label">Tipo de Convenio</label>
                    <select id="tipo_convenio" name="tipo_convenio" class="form-select" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="pasantía">Pasantía</option>
                        <option value="beneficio">Beneficio</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="convenio_file" class="form-label">Archivo del Convenio</label>
                    <input type="file" id="convenio_file" name="convenio_file" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_firma_convenio" class="form-label">Fecha de Firma</label>
                    <input type="date" id="fecha_firma_convenio" name="fecha_firma_convenio" class="form-control" required>
                </div>
            `;
        } else if (tipoConvenio === 'otros') {
            formularioDinamico.innerHTML = `
                <div class="mb-3">
                    <label for="tipo_convenio" class="form-label">Tipo de Convenio</label>
                    <select id="tipo_convenio" name="tipo_convenio" class="form-select" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="colaboración academica">Colaboración Académica</option>
                        <option value="accion comunitaria">Acción Comunitaria</option>
                        <option value="pre profesional">Pre Profesional</option>
                        <option value="beneficios para comunidad">Beneficios para Comunidad</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="firma_convenio" class="form-label">¿Se firmó el convenio?</label>
                    <select id="firma_convenio" name="firma_convenio" class="form-select" required>
                        <option value="">Seleccione una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha_firma_convenio" class="form-label">Fecha de Firma</label>
                    <input type="date" id="fecha_firma_convenio" name="fecha_firma_convenio" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="adendas_cantidad" class="form-label">Cantidad de Adendas</label>
                    <input type="number" id="adendas_cantidad" name="adendas_cantidad" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="convenio_file" class="form-label">Archivo del Convenio</label>
                    <input type="file" id="convenio_file" name="convenio_file" class="form-control" required>
                </div>
            `;
        }
    });
</script>
</body>
</html>