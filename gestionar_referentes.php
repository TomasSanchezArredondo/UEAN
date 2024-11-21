<?php
// Incluimos el archivo de conexión y la barra de navegación
include 'conexion.php';
include 'navbar.php';

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $puesto = $_POST['puesto'];
    $email = $_POST['email'];

    // Validamos los datos antes de insertarlos
    if (!empty($nombres) && !empty($apellidos) && !empty($puesto) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "INSERT INTO referente (nombres, apellidos, puesto, email) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombres, $apellidos, $puesto, $email);

        if ($stmt->execute()) {
            $mensaje = "Referente registrado correctamente.";
        } else {
            $mensaje = "Error al registrar el referente: " . $conn->error;
        }

        $stmt->close();
    } else {
        $mensaje = "Por favor, complete todos los campos correctamente.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Referente</title>
    <!-- Incluimos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Registrar Referente</h1>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <!-- Incluimos Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
