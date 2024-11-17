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
            <div class="title">AGREGAR CONVENIOS</div> 
            <div class="buttons"> 
                <input class="button" type="text" placeholder="NOMBRE">
                <input class="button" type="text" placeholder="APELLIDO/S">
                <input class="button" type="text" placeholder="DNI">
                <input class="button" type="text" placeholder="CARRERAS">
                <input class="button" type="text" placeholder="FECHA DE INICIO">
                <input class="button" type="text" placeholder="CONVENIOS">
                
                <!-- Botones de Agregar y Cancelar -->
                <div class="button-group">
                    <button class="add-btn" type="button">Agregar</button>
                </div>
            </div> 
        </div>
    </div>
</body>
</html>