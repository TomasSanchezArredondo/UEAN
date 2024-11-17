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
      <!-- Dropdown menus -->
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
          <a href="gestionar_entidades.php">gestion de entidades referentes</a>
          <a href="lista entidades referentes.php">lista entidades referentes</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">servicio de empleo</button>
        <div class="dropdown-content">
          <a href="gestión de servicios de Empleo.php">gestion de servicios de empleo</a>
          <a href="lista de servicios de empleo.php">lista de servicios de empleo</a>
        </div>
      </div>
    </div>
    <div class="content">
      <h2>Gestión de Alumnos</h2>
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Ver Información de Convenios</th>
            <th>Ver Trayectoria</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Configuración de conexión a la base de datos
          $servername = "localhost";
          $username = "root"; // Usuario predeterminado en XAMPP
          $password = ""; // Deja en blanco si no tienes contraseña
          $dbname = "uean"; // Nombre de la base de datos importada

          // Crear conexión
          $conn = new mysqli($servername, $username, $password, $dbname);

          // Verificar la conexión
          if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
          }

          // Consulta para obtener los datos de los alumnos
          $sql = "SELECT nombre, apellido, dni FROM alumnos";
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0) {
            // Imprimir cada fila de la tabla
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($row["apellido"]) . "</td>
                                    <td>" . htmlspecialchars($row["dni"]) . "</td>
                                    <td><a href='#'>Ver</a></td>
                                    <td><a href='#'>Ver</a></td>
                                  </tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No hay datos disponibles</td></tr>";
          }

          // Cerrar conexión
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
  </div>


</body>

</html>