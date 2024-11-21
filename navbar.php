<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ2QF1aoomX0pK4Z8Kh9zB6sbJdfq9W1FZf8XB+IjLgqKXfgjOjvF3Tq6vw7" crossorigin="anonymous">
  <style>
    .custom-navbar {
      background-color: #0B2D56;
    }
    .navbar-nav .nav-link {
      color: white !important;
    }
    .navbar-brand {
      color: white !important;
    }
    .navbar-nav .nav-link:hover {
      color: #A1C6EA !important;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand" href="index.php">
        <img src="./img/logo2.png" alt="Logo" style="height: 40px;">
      </a>

      <!-- Botón de navegación para dispositivos móviles -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú de navegación -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <!-- Dropdown Alumnos -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Alumnos
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="gestionar_alumnos.php">Agregar Alumno</a></li>
              <li><a class="dropdown-item" href="listar_alumnos.php">Lista de Alumnos</a></li>
            </ul>
          </li>

          <!-- Dropdown Convenios -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Convenios
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="gestionar_convenio.php">Gestionar Convenio</a></li>
              <li><a class="dropdown-item" href="lista_convenios.php">Lista de Convenios</a></li>
            </ul>
          </li>

          <!-- Dropdown Alumnos Graduados -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Alumnos Graduados
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="gestionar_graduados.php">Agregar Graduado</a></li>
              <li><a class="dropdown-item" href="lista_graduados.php">Lista de Graduados</a></li>
            </ul>
          </li>

          <!-- Dropdown Entidades Referentes -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Entidades Referentes
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="gestionar_entidades.php">Gestión de Entidades</a></li>
              <li><a class="dropdown-item" href="lista_entidades.php">Lista de Entidades</a></li>
              <li><a class="dropdown-item" href="gestionar_referentes.php">Gestión de Referentes</a></li>
              <li><a class="dropdown-item" href="listar_referentes.php">Lista de Referentes</a></li>
            </ul>
          </li>

          <!-- Dropdown Servicio de Empleo -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Servicio de Empleo
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="gestion_servicio_empleo.php">Gestión de Servicios de Empleo</a></li>
              <li><a class="dropdown-item" href="lista_servicios_empleo.php">Lista de Servicios de Empleo</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Enlaces de Bootstrap CSS y JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0xY0A+YfbiM3Xb1EY4A6LPHiDo3YIQnsjzF8vXT+iPHVuzl9" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ2QF1aoomX0pK4Z8Kh9zB6sbJdfq9W1FZf8XB+IjLgqKXfgjOjvF3Tq6vw7" crossorigin="anonymous">
</body>