<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uean";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que las variables POST existen antes de asignarlas
$nombres = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellidos = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';
$carrera = isset($_POST['carreras']) ? $_POST['carreras'] : '';
$fecha_inicio = isset($_POST['fecha']) ? $_POST['fecha'] : '';
$convenio = isset($_POST['convenios']) ? $_POST['convenios'] : ''; // Cambiar el nombre de la variable a `$pasantia` si corresponde
$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';

// Consulta para insertar los datos
// Cambia 'convenio' a 'pasantia' si esa es la columna correcta en tu base de datos
$sql = "INSERT INTO alumno (nombres, apellidos, dni, carrera, fecha_inicio, pasantia, observaciones)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Asigna `$pasantia` en lugar de `$convenio` si corresponde
$stmt->bind_param("sssssss", $nombres, $apellidos, $dni, $carrera, $fecha_inicio, $convenio, $observaciones);

if ($stmt->execute()) {
    echo "Datos guardados exitosamente.";
} else {
    echo "Error al guardar los datos: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
