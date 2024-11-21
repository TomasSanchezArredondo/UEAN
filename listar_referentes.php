<?php
// Incluimos el archivo de conexión y la barra de navegación
include 'conexion.php';
include 'navbar.php';

// Manejo de eliminación de referente
if (isset($_GET['borrar_id'])) {
    $id_a_borrar = $_GET['borrar_id'];
    $sql_borrar = "DELETE FROM referente WHERE id = ?";
    $stmt_borrar = $conn->prepare($sql_borrar);
    $stmt_borrar->bind_param("i", $id_a_borrar);

    if ($stmt_borrar->execute()) {
        $mensaje = "Referente borrado correctamente.";
    } else {
        $mensaje = "Error al borrar el referente: " . $conn->error;
    }

    $stmt_borrar->close();
}

// Manejo de la edición
if (isset($_POST['editar_id'])) {
    $id_a_editar = $_POST['editar_id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $puesto = $_POST['puesto'];
    $email = $_POST['email'];

    $sql_editar = "UPDATE referente SET nombres = ?, apellidos = ?, puesto = ?, email = ? WHERE id = ?";
    $stmt_editar = $conn->prepare($sql_editar);
    $stmt_editar->bind_param("ssssi", $nombres, $apellidos, $puesto, $email, $id_a_editar);

    if ($stmt_editar->execute()) {
        $mensaje = "Referente actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar el referente: " . $conn->error;
    }

    $stmt_editar->close();
}

// Obtener los datos de la tabla referente
$sql = "SELECT * FROM referente";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Referentes</title>
    <!-- Incluimos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Referentes</h1>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <!-- Tabla de Referentes -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Puesto</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr id="referente-<?= $row['id'] ?>">
                            <td><?= $row['id'] ?></td>
                            <td>
                                <span id="nombres-<?= $row['id'] ?>"><?= $row['nombres'] ?></span>
                                <input type="text" class="form-control d-none" id="edit-nombres-<?= $row['id'] ?>" value="<?= $row['nombres'] ?>">
                            </td>
                            <td>
                                <span id="apellidos-<?= $row['id'] ?>"><?= $row['apellidos'] ?></span>
                                <input type="text" class="form-control d-none" id="edit-apellidos-<?= $row['id'] ?>" value="<?= $row['apellidos'] ?>">
                            </td>
                            <td>
                                <span id="puesto-<?= $row['id'] ?>"><?= $row['puesto'] ?></span>
                                <input type="text" class="form-control d-none" id="edit-puesto-<?= $row['id'] ?>" value="<?= $row['puesto'] ?>">
                            </td>
                            <td>
                                <span id="email-<?= $row['id'] ?>"><?= $row['email'] ?></span>
                                <input type="email" class="form-control d-none" id="edit-email-<?= $row['id'] ?>" value="<?= $row['email'] ?>">
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="toggleEdit(<?= $row['id'] ?>)">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="borrarReferente(<?= $row['id'] ?>)">Borrar</button>
                                <button class="btn btn-success btn-sm d-none" id="save-btn-<?= $row['id'] ?>" onclick="guardarCambios(<?= $row['id'] ?>)">Guardar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay referentes registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Incluimos Bootstrap JS y JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleEdit(id) {
            // Cambiar entre vista y edición
            $('#nombres-' + id).toggleClass('d-none');
            $('#apellidos-' + id).toggleClass('d-none');
            $('#puesto-' + id).toggleClass('d-none');
            $('#email-' + id).toggleClass('d-none');
            $('#edit-nombres-' + id).toggleClass('d-none');
            $('#edit-apellidos-' + id).toggleClass('d-none');
            $('#edit-puesto-' + id).toggleClass('d-none');
            $('#edit-email-' + id).toggleClass('d-none');
            $('#save-btn-' + id).toggleClass('d-none');
        }

        function borrarReferente(id) {
            if (confirm('¿Estás seguro de que quieres borrar este referente?')) {
                window.location.href = 'listar_referentes.php?borrar_id=' + id;
            }
        }

        function guardarCambios(id) {
            var nombres = $('#edit-nombres-' + id).val();
            var apellidos = $('#edit-apellidos-' + id).val();
            var puesto = $('#edit-puesto-' + id).val();
            var email = $('#edit-email-' + id).val();

            $.post('listar_referentes.php', {
                editar_id: id,
                nombres: nombres,
                apellidos: apellidos,
                puesto: puesto,
                email: email
            }, function(response) {
                location.reload();
            });
        }
    </script>
</body>
</html>
