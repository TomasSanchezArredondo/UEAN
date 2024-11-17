<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Agregar Alumno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="index.php">
                <img src="./img/descarga-Photoroom.png" alt="Logo">
            </a>
            <input type="text" placeholder="Buscar...">
            <!-- Menú desplegable -->
            <div class="dropdown">
                <button class="dropbtn">Alumnos</button>
                <div class="dropdown-content">
                    <a href="gestionar_alumnos.html">Agregar Alumno</a>
                    <a href="lista_alumnos.php">Lista Alumnos</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Convenios</button>
                <div class="dropdown-content">
                    <a href="gestionar_convenio.php">Gestionar Convenio</a>
                    <a href="lista_convenios.php">Lista Convenios</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Alumnos Graduados</button>
                <div class="dropdown-content">
                    <a href="gestionar_graduados.php">Agregar Graduado</a>
                    <a href="lista_graduados.php">Lista Graduados</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Entidades Referentes</button>
                <div class="dropdown-content">
                    <a href="gestionar_entidades.php">Gestión de Entidades</a>
                    <a href="lista_entidades.php">Lista Entidades</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Servicio de Empleo</button>
                <div class="dropdown-content">
                    <a href="gestion_servicio_empleo.php">Gestión de Servicios</a>
                    <a href="lista de servicios de Empleo.php">Lista de Servicios</a>
                </div>
            </div>
        </div>
        
        <div class="content_alumnos">
            <div class="title">AGREGAR EMPLEO</div>
            <form method="post" action="procesar_alumno.php">
                <div class="buttons">
                    <input class="button" type="text" name="Puesto disponible" placeholder="PUESTO DIPONIBLE" required>
                    <input class="button" type="text" name="Entidad" placeholder="ENTIDAD" required>
                    <input class="button" type="date" name="Fecha de inicio" placeholder="FECHA DE INICIO" required>
                    <input class="button" type="date" name="Fin de la vacante" placeholder="FIN DE LA VACANTE" required>
                    <input class="button" type="number" name="Postulantes" placeholder="NUMERO DE POSTULANTES" required>
                    <input class="button" type="text" name="Convenios" placeholder="CARRERAS REQUERIDAS">
                </div>
                <div class="button-group">
                    <button class="add-btn" type="submit">Agregar Empleo</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
