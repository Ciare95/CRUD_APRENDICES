<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SENA || Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="text-center">Lista de Aprendices</h1>
                    <div class="text-center mb-3">
                        <a href="crear.php" class="btn btn-sm btn-primary">Crear Aprendiz</a>
                    </div>

                    <table class="table table-sm table-hover table-responsive">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No.</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Edad</th>
                                <th colspan="3" scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once 'database/conexion.php';

                            try {
                                $db = new Conexion("localhost", "prueba_db", "root", "");
                                $conexion = $db->conexion;
                            
                                $sql = "SELECT * FROM aprendices";
                                $stmt = $conexion->prepare($sql);
                                $stmt->execute();
                                $resultado = $stmt->fetchAll();
                            
                                $contador = 1;
                            
                                foreach ($resultado as $row) {
                                    $id = $row['id'];
                                    $nombre = $row['primer_nombre'];
                                    $fecha_nacimiento = $row['fecha_nacimiento'];
                                    $obj = new DateTime($fecha_nacimiento);
                                    $hoy = new DateTime();
                                    $edad = $hoy->diff($obj)->y;
                            
                                    echo "<tr class='text-center'>";
                                    echo "<th scope='row'>$contador</th>";
                                    echo "<td>$nombre</td>";
                                    echo "<td>$edad años</td>";
                                    echo "<td><a href='ver.php?id=$id&nombre=$nombre' class='btn btn-info btn-sm'>Ver</a></td>";
                                    echo "<td><a href='editar.php?id=$id' class='btn btn-warning btn-sm'>Editar</a></td>";
                                    echo "<td><a href='delete.php?id=$id' class='btn btn-danger btn-sm'>Eliminar</a></td>";
                                    echo "</tr>";
                            
                                    $contador++;
                                }
                            
                            } catch (Exception $e) {
                                echo $e->getMessage();
                            }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>