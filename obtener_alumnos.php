<?php
include 'conexion.php';

if (isset($_GET['carrera'])) {
    $carrera = $_GET['carrera'];
    $query_alumnos = "SELECT id, nombres, apellidos FROM alumno WHERE carrera = '$carrera' AND es_graduado = 'NO'";
    $result_alumnos = mysqli_query($conn, $query_alumnos);

    $alumnos = [];
    while ($row = mysqli_fetch_assoc($result_alumnos)) {
        $alumnos[] = $row;
    }

    echo json_encode($alumnos);
}
?>
