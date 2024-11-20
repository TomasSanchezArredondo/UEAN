<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Agregar Alumno</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilo para el marcador de posición personalizado en el campo de fecha */
        .date-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .date-placeholder {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #999;
        }
        input[type="date"]:not(:placeholder-shown) + .date-placeholder,
        input[type="date"]:focus + .date-placeholder {
            display: none;
        }
        input[type="date"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
    <div class="header">
          <a href="index.php">
            <img src="./img/descarga-Photoroom.png" alt="Logo">
          </a>
          <input type="text" placeholder="Buscar...">
    
          <div class="dropdown">
            <button class="dropbtn">alumnos</button>
            <div class="dropdown-content">
              <a href="gestionar_alunos.php">agregar alumno</a>
              <a href="lista_alumnos.php">Lista Alumnos</a>
            </div>
          </div>
          <div class="dropdown">
            <button class="dropbtn">convenios</button>
            <div class="dropdown-content">
              <a href="gestionar_convenio.php">gestionar convenio</a>
              <a href="lista_convenios.php">lista convenios</a>
            </div>
          </div>
          <div class="dropdown">
            <button class="dropbtn">alumnos graduados</button>
            <div class="dropdown-content">
              <a href="gestionar_graduados.php">agregar graduado</a>
              <a href="lista_graduados.php">Lista graduados</a>
            </div>
          </div>
    
    
    
          <div class="dropdown">
            <button class="dropbtn">entidades referentes</button>
            <div class="dropdown-content">
              <a href="gestionar_entidades.php">gestion de entidades</a>
              <a href="lista entidades referentes.php">lista entidades referentes</a>
              <a href="gestionar_referentes.php">gestion de referentes</a>
              <a href="lista entidades referentes.php">lista referentes</a>
            </div>
          </div>
          <div class="dropdown">
            <button class="dropbtn">servicio de empleo</button>
            <div class="dropdown-content">
              <a href="gestión de servicios de Empleo.php">gestion de servicios de empleo</a>
              <a href="lista de servicios de Empleo.php">lista de servicios de empleo</a>
            </div>
          </div>
        </div>

        <!-- Contenido principal -->
        <div class="content_alumnos">
            <div class="title">AGREGAR ALUMNO</div>
            <form method="post" action="procesar_alumno.php">
                <div class="buttons">
                    <input class="button" type="text" name="nombre" placeholder="NOMBRE" required>
                    <input class="button" type="text" name="apellido" placeholder="APELLIDO/S" required>
                    <input class="button" type="text" name="dni" placeholder="DNI" required>
                    <input class="button" type="text" name="carreras" placeholder="CARRERAS" required>

                    <!-- Campo de fecha con marcador de posición personalizado -->
                    <div class="date-container">
                        <input class="button" type="date" name="fecha" required>
                        <span class="date-placeholder">Ingrese fecha inicio</span>
                    </div>

                    <input class="button" type="text" name="convenios" placeholder="CONVENIOS">
                    <input class="button" type="text" name="observaciones" placeholder="OBSERVACIONES">
                </div>
                <div class="button-group">
                    <button class="add-btn" type="submit">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
