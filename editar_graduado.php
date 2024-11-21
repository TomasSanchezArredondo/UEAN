<?php
// Incluir conexión a la base de datos y la navbar
include 'conexion.php';
include 'navbar.php';

// Verificar si se pasó un ID para editar
if (isset($_GET['id'])) {
    $id_graduado = $_GET['id'];

    // Obtener los datos del graduado a editar
    $query = "SELECT g.*, a.nombres, a.apellidos, a.carrera 
              FROM graduados g
              JOIN alumno_graduado ag ON g.id = ag.id_graduado
              JOIN alumno a ON ag.id_alumno = a.id
              WHERE g.id = $id_graduado";
    $result = mysqli_query($conn, $query);
    $graduado = mysqli_fetch_assoc($result);
} else {
    echo "ID de graduado no válido.";
    exit;
}

// Manejo del formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $anio_graduacion = $_POST['anio_graduacion'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];
    $estudios_posteriores = $_POST['estudios_posteriores'];
    $area_de_interes = $_POST['area_de_interes'];
    $observaciones = $_POST['observaciones'];

    $query_update = "UPDATE graduados SET 
                    anio_graduacion = '$anio_graduacion',
                    mail = '$mail',
                    tel = '$tel',
                    estudios_posteriores = '$estudios_posteriores',
                    area_de_interes = '$area_de_interes',
                    observaciones = '$observaciones'
                    WHERE id = $id_graduado";

    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Datos actualizados correctamente'); window.location.href='lista_graduados.php';</script>";
    } else {
        echo "Error al actualizar los datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Graduado</title>

    <!-- Estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Editar Graduado</h2>

        <!-- Formulario de edición -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombre</label>
                <input type="text" id="nombres" class="form-control" value="<?php echo $graduado['nombres'] . ' ' . $graduado['apellidos']; ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="carrera" class="form-label">Carrera</label>
                <input type="text" id="carrera" class="form-control" value="<?php echo $graduado['carrera']; ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="anio_graduacion" class="form-label">Año de Graduación</label>
                <input type="text" id="anio_graduacion" name="anio_graduacion" class="form-control" value="<?php echo $graduado['anio_graduacion']; ?>">
            </div>

            <div class="mb-3">
                <label for="mail" class="form-label">Correo</label>
                <input type="email" id="mail" name="mail" class="form-control" value="<?php echo $graduado['mail']; ?>">
            </div>

            <div class="mb-3">
                <label for="tel" class="form-label">Teléfono</label>
                <input type="text" id="tel" name="tel" class="form-control" value="<?php echo $graduado['tel']; ?>">
            </div>

            <div class="mb-3">
                <label for="estudios_posteriores" class="form-label">Estudios Posteriores</label>
                <input type="text" id="estudios_posteriores" name="estudios_posteriores" class="form-control" value="<?php echo $graduado['estudios_posteriores']; ?>">
            </div>

            <div class="mb-3">
                <label for="area_de_interes" class="form-label">Área de Interés</label>
                <input type="text" id="area_de_interes" name="area_de_interes" class="form-control" value="<?php echo $graduado['area_de_interes']; ?>">
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea id="observaciones" name="observaciones" class="form-control"><?php echo $graduado['observaciones']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
