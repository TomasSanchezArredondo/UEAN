<?php
// Incluir conexión a la base de datos y la navbar
include 'conexion.php';
include 'navbar.php';

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $carrera = $_POST['carrera'];
    $alumno_id = $_POST['alumno_id'];
    $anio_graduacion = $_POST['anio_graduacion'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];
    $estudios_posteriores = $_POST['estudios_posteriores'];
    $area_de_interes = $_POST['area_de_interes'];
    $observaciones_graduado = $_POST['observaciones'];

    // Insertar en la tabla graduados
    $query_graduado = "INSERT INTO graduados (anio_graduacion, mail, tel, estudios_posteriores, area_de_interes, observaciones) 
                      VALUES ('$anio_graduacion', '$mail', '$tel', '$estudios_posteriores', '$area_de_interes', '$observaciones_graduado')";
    if (mysqli_query($conn, $query_graduado)) {
        // Obtener el id del graduado insertado
        $graduado_id = mysqli_insert_id($conn);

        // Insertar en la tabla alumno_graduado
        $query_alumno_graduado = "INSERT INTO alumno_graduado (id_alumno, id_graduado) VALUES ('$alumno_id', '$graduado_id')";
        mysqli_query($conn, $query_alumno_graduado);

        // Actualizar el campo 'es_graduado' en la tabla alumno
        $query_actualizar_alumno = "UPDATE alumno SET es_graduado = 'SI' WHERE id = '$alumno_id'";
        mysqli_query($conn, $query_actualizar_alumno);

        echo "<div class='alert alert-success mt-3'>Graduado registrado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error al registrar el graduado.</div>";
    }
}

// Obtener las carreras
$query_carreras = "SELECT DISTINCT carrera FROM alumno";
$result_carreras = mysqli_query($conn, $query_carreras);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Graduados</title>

    <!-- Estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Otros estilos personalizados, si es necesario -->
    <style>
        /* Aquí puedes agregar tus estilos personalizados */
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Añadir de Graduados</h2>
        <form method="POST">
            <!-- Selección de carrera -->
            <div class="form-group mb-3">
                <label for="carrera">Carrera</label>
                <select name="carrera" id="carrera" class="form-control" required>
                    <option value="">Selecciona una carrera</option>
                    <?php while ($row = mysqli_fetch_assoc($result_carreras)) { ?>
                        <option value="<?php echo $row['carrera']; ?>"><?php echo $row['carrera']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Selección de alumno -->
            <div class="form-group mb-3">
                <label for="alumno_id">Alumno</label>
                <select name="alumno_id" id="alumno_id" class="form-control" required>
                    <option value="">Selecciona un alumno</option>
                </select>
            </div>

            <!-- Datos de graduado -->
            <div class="form-group mb-3">
                <label for="anio_graduacion">Año de Graduación</label>
                <input type="number" name="anio_graduacion" id="anio_graduacion" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="mail">Correo Electrónico</label>
                <input type="email" name="mail" id="mail" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="tel">Teléfono</label>
                <input type="text" name="tel" id="tel" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="estudios_posteriores">Estudios Posteriores</label>
                <input type="text" name="estudios_posteriores" id="estudios_posteriores" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="area_de_interes">Área de Interés</label>
                <input type="text" name="area_de_interes" id="area_de_interes" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Graduado</button>
        </form>
    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para cargar alumnos según la carrera seleccionada -->
    <script>
        document.getElementById('carrera').addEventListener('change', function() {
            var carrera = this.value;
            var alumnoSelect = document.getElementById('alumno_id');
            
            // Limpiar el select de alumnos
            alumnoSelect.innerHTML = '<option value="">Selecciona un alumno</option>';

            if (carrera) {
                fetch('obtener_alumnos.php?carrera=' + carrera)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(alumno => {
                            var option = document.createElement('option');
                            option.value = alumno.id;
                            option.textContent = alumno.nombres + ' ' + alumno.apellidos;
                            alumnoSelect.appendChild(option);
                        });
                    });
            }
        });
    </script>
</body>
</html>