<?php
// Incluir conexión a la base de datos y la navbar
include 'conexion.php';
include 'navbar.php';

// Manejo de la selección de carrera y búsqueda por nombre o apellido
$carreraSeleccionada = isset($_GET['carrera']) ? $_GET['carrera'] : '';
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Obtener las carreras disponibles
$query_carreras = "SELECT DISTINCT carrera FROM alumno";
$result_carreras = mysqli_query($conn, $query_carreras);

// Consulta para obtener los graduados
$query_graduados = "SELECT g.id, g.anio_graduacion, g.mail, g.tel, g.estudios_posteriores, g.area_de_interes, g.observaciones, a.nombres, a.apellidos, a.carrera
                    FROM graduados g
                    JOIN alumno_graduado ag ON g.id = ag.id_graduado
                    JOIN alumno a ON ag.id_alumno = a.id
                    WHERE (a.nombres LIKE '%$buscar%' OR a.apellidos LIKE '%$buscar%')";

// Si no hay búsqueda, se aplica el filtro de carrera
if (!$buscar && $carreraSeleccionada) {
    $query_graduados .= " AND a.carrera = '$carreraSeleccionada'";
}

$result_graduados = mysqli_query($conn, $query_graduados);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Graduados</title>

    <!-- Estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Otros estilos personalizados, si es necesario -->
    <style>
        /* Aquí puedes agregar tus estilos personalizados */
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Lista de Graduados</h2>

        <!-- Filtro por carrera y barra de búsqueda -->
        <form method="GET" class="mb-4">
            <div class="row">
                <!-- Barra de búsqueda -->
                <div class="col-md-6 mb-3">
                    <label for="buscar" class="form-label">Busque por nombre y apellido</label>
                    <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Buscar por nombre o apellido" value="<?php echo htmlspecialchars($buscar); ?>">
                </div>

                <!-- Filtro por carrera -->
                <div class="col-md-4 mb-3">
                    <label for="carrera" class="form-label">Elija una carrera</label>
                    <select name="carrera" id="carrera" class="form-control">
                        <option value="">Ver Todos</option>
                        <?php while ($row = mysqli_fetch_assoc($result_carreras)) { ?>
                            <option value="<?php echo $row['carrera']; ?>" <?php echo $carreraSeleccionada == $row['carrera'] ? 'selected' : ''; ?>>
                                <?php echo $row['carrera']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Botón de filtro -->
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabla de graduados -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Año de Graduación</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Estudios Posteriores</th>
                    <th>Área de Interés</th>
                    <th>Observaciones</th>
                    <th>Acción</th> <!-- Nueva columna para acción -->
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_graduados) > 0) { 
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result_graduados)) { ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $row['nombres'] . ' ' . $row['apellidos']; ?></td>
                            <td><?php echo $row['carrera']; ?></td>
                            <td><?php echo $row['anio_graduacion']; ?></td>
                            <td><?php echo $row['mail']; ?></td>
                            <td><?php echo $row['tel']; ?></td>
                            <td><?php echo $row['estudios_posteriores']; ?></td>
                            <td><?php echo $row['area_de_interes']; ?></td>
                            <td><?php echo $row['observaciones']; ?></td>
                            <td>
                                <a href="editar_graduado.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="10" class="text-center">No se encontraron graduados</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>