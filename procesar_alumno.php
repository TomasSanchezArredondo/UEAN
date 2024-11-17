<?php
// Conexión a la base de datos
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "uean";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombres = $_POST['nombre'];
$apellidos = $_POST['apellido'];
$dni = $_POST['dni'];
$carrera = $_POST['carreras'];
$fecha_inicio = $_POST['fecha'];
$convenio = $_POST['convenios'];
$observaciones = $_POST['observaciones'];

// Consulta para insertar los datos
$sql = "INSERT INTO alumno (nombres, apellidos, dni, carrera, fecha_inicio, pasantía, observaciones)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $nombres, $apellidos, $dni, $carrera, $fecha_inicio, $convenio, $observaciones);

if ($stmt->execute()) {
    echo "Datos guardados exitosamente.";
} else {
    echo "Error al guardar los datos: " . $conn->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
