<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interfaz Completa</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <div class="header">
      <a href="index.php">
        <img src="./img/descarga-Photoroom.png" alt="Logo">
      </a>
      <input type="text" placeholder="Buscar..." aria-label="Buscar">

      <div class="dropdown">
        <button class="dropbtn">Alumnos</button>
        <div class="dropdown-content">
          <a href="gestionar_alunos.php">agregar alumno</a>
          <a href="lista_alumnos.php">Lista de alumnos</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropbtn">Convenios</button>
        <div class="dropdown-content">
          <a href="gestionar_convenio.php">Gestionar convenio</a>
          <a href="lista_convenios.php">Lista de convenios</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropbtn">Alumnos Graduados</button>
        <div class="dropdown-content">
          <a href="gestionar_graduados.php">Agregar graduado</a>
          <a href="lista_graduados.php">Lista de graduados</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropbtn">Entidades Referentes</button>
        <div class="dropdown-content">
          <a href="gestionar_entidades.php">Gestión de entidades</a>
          <a href="lista_entidades_referentes.php">Lista de entidades</a>
          <a href="gestionar_entidades.php">Gestión de referentes</a>
          <a href="lista_entidades_referentes.php">Lista de referentes</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropbtn">Servicio de Empleo</button>
        <div class="dropdown-content">
          <a href="gestion_servicio_empleo.php">Gestión de servicios de empleo</a>
          <a href="lista_servicios_empleo.php">Lista de servicios de empleo</a>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="title">RESUMEN</div>
      <div class="buttons">
        <h2>GESTIONES</h2>
        <h2>LISTAS</h2>

        <a class="button_3" href="gestionar_alunos.php">Gestionar alumno</a>
        <a class="button_3" href="lista_alumnos.php">Lista de alumnos</a>
        <a class="button_3" href="gestionar_graduados.php">Gestionar graduados</a>
        <a class="button_3" href="lista_graduados.php">Lista de graduados</a>
        <a class="button_3" href="gestionar_convenio.php">Gestionar convenio</a>
        <a class="button_3" href="lista_convenios.php">Lista de convenios</a>
        <a class="button_3" href="gestionar_entidades.php">Gestionar entidades</a>
        <a class="button_3" href="lista_entidades_referentes.php">Lista de entidades</a>
        <a class="button_3" href="gestionar_referentes.php">Gestionar referentes</a>
        <a class="button_3" href="lista_referentes.php">Lista de referentes</a>
        <a class="button_3" href="gestion_servicio_empleo.php">Gestionar servicios de empleo</a>
        <a class="button_3" href="lista_servicios_empleo.php">Lista de servicios de empleo</a>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>

</html>