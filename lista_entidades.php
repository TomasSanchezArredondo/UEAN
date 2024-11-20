<?php
include 'conexion.php'; // Conexión a la base de datos
include 'navbar.php'; // Barra de navegación

// Obtener entidades y referentes
$query = "
    SELECT 
        entidad.id, 
        entidad.nombre, 
        entidad.sector, 
        entidad.direccion, 
        entidad.id_referente,
        CONCAT(referente.nombres, ' ', referente.apellidos) AS referente
    FROM entidad
    LEFT JOIN referente ON entidad.id_referente = referente.id
";
$entidades = $conn->query($query);

// Obtener lista de referentes para los dropdowns
$query_referentes = "SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM referente";
$referentes = $conn->query($query_referentes);
$referentes_list = [];
while ($ref = $referentes->fetch_assoc()) {
    $referentes_list[] = $ref;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Entidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Entidades</h2>
    <table class="table table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Sector</th>
                <th>Dirección</th>
                <th>Referente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($entidades->num_rows > 0): ?>
                <?php while ($row = $entidades->fetch_assoc()): ?>
                    <tr data-id="<?= $row['id']; ?>">
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['nombre']; ?></td>
                        <td><?= $row['sector']; ?></td>
                        <td><?= $row['direccion']; ?></td>
                        <td><?= $row['referente']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-edit">Editar</button>
                            <button class="btn btn-danger btn-sm btn-delete">Borrar</button>
                        </td>
                    </tr>
                    <!-- Formulario de edición (oculto por defecto) -->
                    <tr class="edit-row d-none" data-id="<?= $row['id']; ?>">
                        <td><?= $row['id']; ?></td>
                        <td><input type="text" class="form-control" value="<?= $row['nombre']; ?>"></td>
                        <td><input type="text" class="form-control" value="<?= $row['sector']; ?>"></td>
                        <td><input type="text" class="form-control" value="<?= $row['direccion']; ?>"></td>
                        <td>
                            <select class="form-select">
                                <?php foreach ($referentes_list as $referente): ?>
                                    <option value="<?= $referente['id']; ?>" 
                                        <?= $referente['id'] == $row['id_referente'] ? 'selected' : ''; ?>>
                                        <?= $referente['nombre_completo']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm btn-save">Guardar</button>
                            <button class="btn btn-secondary btn-sm btn-cancel">Cancelar</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay entidades registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Manejar el clic en "Editar"
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            const editRow = row.nextElementSibling;
            row.classList.add('d-none');
            editRow.classList.remove('d-none');
        });
    });

    // Manejar el clic en "Cancelar"
    document.querySelectorAll('.btn-cancel').forEach(button => {
        button.addEventListener('click', (e) => {
            const editRow = e.target.closest('tr');
            const row = editRow.previousElementSibling;
            editRow.classList.add('d-none');
            row.classList.remove('d-none');
        });
    });

    // Manejar el clic en "Guardar"
    document.querySelectorAll('.btn-save').forEach(button => {
        button.addEventListener('click', (e) => {
            const editRow = e.target.closest('tr');
            const id = editRow.dataset.id;
            const inputs = editRow.querySelectorAll('input');
            const select = editRow.querySelector('select');

            const nombre = inputs[0]?.value;
            const sector = inputs[1]?.value;
            const direccion = inputs[2]?.value;
            const idReferente = select.value;

            fetch('actualizar_entidad.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, nombre, sector, direccion, idReferente })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Entidad actualizada correctamente');
                    location.reload(); // Refrescar la página
                } else {
                    alert(data.message || 'Error al actualizar la entidad');
                }
            })
            .catch(error => console.error("Error en la solicitud:", error));
        });
    });

    // Manejar el clic en "Borrar"
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            const id = row.dataset.id;

            if (confirm('¿Estás seguro de que deseas eliminar esta entidad?')) {
                fetch('borrar_entidad.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Entidad eliminada correctamente');
                        location.reload(); // Refrescar la página
                    } else {
                        alert(data.message || 'Error al eliminar la entidad');
                    }
                })
                .catch(error => console.error("Error en la solicitud:", error));
            }
        });
    });
});
</script>
</body>
</html>
