<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener las entidades disponibles
$query = $pdo->query("SELECT id, nombre FROM entidad");
$entidades = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Convenios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Formulario de Convenios</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="mainForm" method="POST" action="procesar_convenio.php" enctype="multipart/form-data">
                    <!-- Selección del tipo de convenio -->
                    <div class="mb-3">
                        <label for="tipoConvenio" class="form-label">Selecciona el tipo de convenio</label>
                        <select class="form-select" id="tipoConvenio" name="tipoConvenio" required>
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="pasantia">Convenio Pasantía-Beneficio</option>
                            <option value="otros">Otros Convenios</option>
                        </select>
                    </div>

                    <!-- Selección de la entidad -->
                    <div class="mb-3">
                        <label for="idEntidad" class="form-label">Selecciona la entidad</label>
                        <select class="form-select" id="idEntidad" name="id_entidad" required>
                            <option value="" selected disabled>Selecciona una entidad</option>
                            <?php foreach ($entidades as $entidad): ?>
                                <option value="<?= $entidad['id'] ?>"><?= htmlspecialchars($entidad['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Formulario para Pasantía-Beneficio -->
                    <div id="formPasantia" class="d-none">
                        <h5 class="mb-3">Formulario de Pasantía-Beneficio</h5>
                        <div class="mb-3">
                            <label for="tipoConvenioPasantia" class="form-label">Tipo de Convenio</label>
                            <select class="form-select" id="tipoConvenioPasantia" name="tipo_convenio" required>
                                <option value="" selected disabled>Selecciona una opción</option>
                                <option value="pasantía">Pasantía</option>
                                <option value="beneficio">Beneficio</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="observacionesPasantia" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observacionesPasantia" name="observaciones"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="convenioFilePasantia" class="form-label">Archivo del Convenio</label>
                            <input type="file" class="form-control" id="convenioFilePasantia" name="convenio_file" accept=".pdf" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaFirmaPasantia" class="form-label">Fecha de Firma</label>
                            <input type="date" class="form-control" id="fechaFirmaPasantia" name="fecha_firma_convenio" required>
                        </div>
                    </div>

                    <!-- Formulario para Otros Convenios -->
                    <div id="formOtros" class="d-none">
                        <h5 class="mb-3">Formulario de Otros Convenios</h5>
                        <div class="mb-3">
                            <label for="tipoConvenioOtros" class="form-label">Tipo de Convenio</label>
                            <select class="form-select" id="tipoConvenioOtros" name="tipo" required>
                                <option value="" selected disabled>Selecciona una opción</option>
                                <option value="colaboración academica">Colaboración Académica</option>
                                <option value="accion comunitaria">Acción Comunitaria</option>
                                <option value="pre profesional">Pre Profesional</option>
                                <option value="beneficios para comunidad">Beneficios para Comunidad</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firmaConvenioOtros" class="form-label">¿Convenio Firmado?</label>
                            <select class="form-select" id="firmaConvenioOtros" name="firma_convenio" required>
                                <option value="" selected disabled>Selecciona una opción</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="adendasCantidadOtros" class="form-label">Número de Adendas</label>
                            <input type="number" class="form-control" id="adendasCantidadOtros" name="adendas_cantidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="observacionesOtros" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observacionesOtros" name="observaciones"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="convenioFileOtros" class="form-label">Archivo del Convenio</label>
                            <input type="file" class="form-control" id="convenioFileOtros" name="convenio_file" accept=".pdf" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaFirmaOtros" class="form-label">Fecha de Firma</label>
                            <input type="date" class="form-control" id="fechaFirmaOtros" name="fecha_firma_convenio" required>
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100">Enviar Convenio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const tipoConvenio = document.getElementById('tipoConvenio');
        const formPasantia = document.getElementById('formPasantia');
        const formOtros = document.getElementById('formOtros');
        const tipoConvenioPasantia = document.getElementById('tipoConvenioPasantia');
        const tipoConvenioOtros = document.getElementById('tipoConvenioOtros');
        const firmaConvenioOtros = document.getElementById('firmaConvenioOtros');
        const adendasCantidadOtros = document.getElementById('adendasCantidadOtros');
        const convenioFilePasantia = document.getElementById('convenioFilePasantia');
        const convenioFileOtros = document.getElementById('convenioFileOtros');
        const fechaFirmaPasantia = document.getElementById('fechaFirmaPasantia');
        const fechaFirmaOtros = document.getElementById('fechaFirmaOtros');

        tipoConvenio.addEventListener('change', function () {
            // Mostrar/ocultar formularios
            if (this.value === 'pasantia') {
                formPasantia.classList.remove('d-none');
                formOtros.classList.add('d-none');
                
                // Hacer los campos de pasantía requeridos
                tipoConvenioPasantia.required = true;
                convenioFilePasantia.required = true;
                fechaFirmaPasantia.required = true;

                // Remover los campos de otros convenios requeridos
                tipoConvenioOtros.required = false;
                firmaConvenioOtros.required = false;
                adendasCantidadOtros.required = false;
                convenioFileOtros.required = false;
                fechaFirmaOtros.required = false;
            } else if (this.value === 'otros') {
                formOtros.classList.remove('d-none');
                formPasantia.classList.add('d-none');

                // Hacer los campos de otros convenios requeridos
                tipoConvenioOtros.required = true;
                firmaConvenioOtros.required = true;
                adendasCantidadOtros.required = true;
                convenioFileOtros.required = true;
                fechaFirmaOtros.required = true;

                // Remover los campos de pasantía requeridos
                tipoConvenioPasantia.required = false;
                convenioFilePasantia.required = false;
                fechaFirmaPasantia.required = false;
            }
        });
    </script>
</body>
</html>