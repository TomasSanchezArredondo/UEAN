<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            text-align: center;
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #333;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="search-bar">
            <input type="text" placeholder="Buscar...">
        </div>
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
            <body>
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
                                <td><a href='#'>ver</a></td>
                                <td><a href='#'>ver</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay datos disponibles</td></tr>";
                }

                // Cerrar conexión
                $conn->close();
                ?>
            </body>
        </table>
    </div>
</body>

</html>