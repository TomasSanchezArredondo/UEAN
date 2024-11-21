<?php
// Incluimos la conexión
include('conexion.php');
include './navbar.php';

// Verificamos si se ha enviado el formulario
$tabla_seleccionada = isset($_POST['tabla_seleccionada']) ? $_POST['tabla_seleccionada'] : '';
$datos = [];

if ($tabla_seleccionada === 'otros') {
    // Consulta para tabla convenio_otros
    $sql = "SELECT co.id, e.nombre AS entidad, co.tipo_convenio, co.firma_convenio, co.adendas_cantidad, co.observaciones, co.convenio_file, co.fecha_firma_convenio
            FROM convenio_otros co
            INNER JOIN entidad e ON co.id_entidad = e.id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $datos = $result->fetch_all(MYSQLI_ASSOC);
    }
} elseif ($tabla_seleccionada === 'pasantia_beneficio') {
    // Consulta para tabla convenios_pasantia_beneficios
    $sql = "SELECT cpb.id, e.nombre AS entidad, cpb.tipo_convenio, cpb.observaciones, cpb.convenio_file, cpb.fecha_firma_convenio
            FROM convenios_pasantia_beneficios cpb
            INNER JOIN entidad e ON cpb.id_entidad = e.id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $datos = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de convenios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Lista de convenios</h1>

        <!-- Formulario para seleccionar la tabla -->
        <form method="post" action="" class="mb-4" id="tablaForm">
            <div class="mb-3">
                <label for="tabla_seleccionada" class="form-label">Selecciona el tipo de convenios:</label>
                <select name="tabla_seleccionada" id="tabla_seleccionada" class="form-select" onchange="document.getElementById('tablaForm').submit();">
                    <option value="">-- Selecciona una opción --</option>
                    <option value="otros" <?php echo $tabla_seleccionada === 'otros' ? 'selected' : ''; ?>>Convenios Otros</option>
                    <option value="pasantia_beneficio" <?php echo $tabla_seleccionada === 'pasantia_beneficio' ? 'selected' : ''; ?>>Convenios Pasantía y Beneficio</option>
                </select>
            </div>
        </form>

        <!-- Tabla de resultados -->
        <?php if (!empty($tabla_seleccionada)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <?php
                            // Mostramos las columnas según los datos obtenidos
                            if (!empty($datos)) {
                                foreach (array_keys($datos[0]) as $columna) {
                                    echo "<th>" . htmlspecialchars($columna) . "</th>";
                                }
                                echo "<th>Acción</th>";
                            } else {
                                echo "<th>No hay datos disponibles</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mostramos los datos de la tabla seleccionada
                        if (!empty($datos)) {
                            foreach ($datos as $fila) {
                                echo "<tr>";
                                foreach ($fila as $columna => $valor) {
                                    if ($columna === 'convenio_file' && !empty($valor)) {
                                        echo "<td><a href='" . htmlspecialchars($valor) . "' target='_blank'>Ver archivo</a></td>";
                                    } else {
                                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                                    }
                                }
                                // Botón Editar
                                echo "<td><a href='editar_convenio.php?id=" . htmlspecialchars($fila['id']) . "' class='btn btn-warning btn-sm'>Editar</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='100%'>No hay registros para mostrar</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
