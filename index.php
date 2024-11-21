<?php
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Gestión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            color: #000;
        }
        .list-group-item {
            border: none;
        }
        .list-group-item.active {
            background-color: #f8f9fa;
            color: #000;
            font-weight: bold;
        }
        a {
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Menú</h2>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item active">Alumnos</li>
                    <li class="list-group-item"><a href="gestionar_alumnos.php" class="text-decoration-none">Gestionar alumno</a></li>
                    <li class="list-group-item"><a href="listar_alumnos.php" class="text-decoration-none">Lista de alumnos</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item active">Graduados</li>
                    <li class="list-group-item"><a href="gestionar_graduados.php" class="text-decoration-none">Gestionar graduados</a></li>
                    <li class="list-group-item"><a href="lista_graduados.php" class="text-decoration-none">Lista de graduados</a></li>
                </ul>
            </div>
            <div class="col-md-6 mt-3">
                <ul class="list-group">
                    <li class="list-group-item active">Convenios</li>
                    <li class="list-group-item"><a href="gestionar_convenio.php" class="text-decoration-none">Gestionar convenio</a></li>
                    <li class="list-group-item"><a href="lista_convenios.php" class="text-decoration-none">Lista de convenios</a></li>
                </ul>
            </div>
            <div class="col-md-6 mt-3">
                <ul class="list-group">
                    <li class="list-group-item active">Entidades</li>
                    <li class="list-group-item"><a href="gestionar_entidades.php" class="text-decoration-none">Gestionar entidades</a></li>
                    <li class="list-group-item"><a href="lista_entidades.php" class="text-decoration-none">Lista de entidades</a></li>
                </ul>
            </div>
            <div class="col-md-6 mt-3">
                <ul class="list-group">
                    <li class="list-group-item active">Referentes</li>
                    <li class="list-group-item"><a href="gestionar_referentes.php" class="text-decoration-none">Gestionar referentes</a></li>
                    <li class="list-group-item"><a href="listar_referentes.php" class="text-decoration-none">Lista de referentes</a></li>
                </ul>
            </div>
            <div class="col-md-6 mt-3">
                <ul class="list-group">
                    <li class="list-group-item active">Servicios de Empleo</li>
                    <li class="list-group-item"><a href="agregar_empleo.php" class="text-decoration-none">Añadir servicios de empleo</a></li>
                    <li class="list-group-item"><a href="lista_empleo.php" class="text-decoration-none">Lista de servicios de empleo</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
