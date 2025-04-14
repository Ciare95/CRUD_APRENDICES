<?php
require_once 'database/conexion.php';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SENA || Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="text-center">Lista de Aprendices</h1>
                    <div class="text-center mb-3">
                        <a href="view/aprendiz/crear.php" class="btn btn-sm btn-primary">Crear Aprendiz</a>
                    </div>

                    <table class="table table-sm table-hover table-responsive">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No.</th>
                                <th scope="col">Nombre Completo</th>
                                <th scope="col">Edad</th>
                                <th colspan="3" scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $db = new Conexion();
                                $conexion = $db->conexion;
                            
                                $sql = "SELECT a.id, 
                                              p.primer_nombre, 
                                              p.segundo_nombre, 
                                              p.primer_apellido, 
                                              p.segundo_apellido,
                                              p.fecha_nacimiento
                                       FROM aprendices a
                                       INNER JOIN personas p ON a.persona_id = p.id";
                                
                                $stmt = $conexion->prepare($sql);
                                $stmt->execute();
                                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                                $contador = 1;
                            
                                foreach ($resultado as $row) {
                                    if (isset($row['id']) && isset($row['primer_nombre']) && isset($row['fecha_nacimiento'])) {
                                        $id = $row['id'];
                                        
                                        // Construir nombre completo
                                        $nombre = $row['primer_nombre'];
                                        if (!empty($row['segundo_nombre'])) $nombre .= " " . $row['segundo_nombre'];
                                        $nombre .= " " . $row['primer_apellido'];
                                        if (!empty($row['segundo_apellido'])) $nombre .= " " . $row['segundo_apellido'];
                                        
                                        // Calcular edad
                                        $fecha_nac = new DateTime($row['fecha_nacimiento']);
                                        $hoy = new DateTime();
                                        $edad = $hoy->diff($fecha_nac)->y;
                                
                                        echo "<tr class='text-center'>";
                                        echo "<th scope='row'>$contador</th>";
                                        echo "<td>$nombre</td>";
                                        echo "<td>$edad años</td>";
                                        echo "<td><a href='view/aprendiz/ver.php?id=$id' class='btn btn-info btn-sm'>Ver</a></td>";
                                        echo "<td><a href='view/aprendiz/editar.php?id=$id' class='btn btn-warning btn-sm'>Editar</a></td>";
                                        echo "<td><a href='javascript:void(0)' onclick='eliminarAprendiz($id, \"$nombre\")' class='btn btn-danger btn-sm'>Eliminar</a></td>";
                                        echo "</tr>";
                                
                                        $contador++;
                                    }
                                }
                            
                            } catch (Exception $e) {
                                echo "<tr><td colspan='6' class='text-center text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/aprendiz.js"></script>
</body>

</html>