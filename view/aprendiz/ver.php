<?php
require_once __DIR__ . '/../../config/config.php';
require_once BASE_PATH . '/model/AprendizModel.php';

// Validación del ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../../index.php?error=id_invalido');
    exit;
}

$id = (int)$_GET['id'];
$modelo = new AprendizModel();
$aprendiz = $modelo->obtenerDetalles($id);

// Validar si se encontró el aprendiz
if (!$aprendiz || isset($aprendiz['error'])) {
    header('Location: ../../index.php?error=aprendiz_no_encontrado');
    exit;
}

// Función helper para mostrar datos de forma segura
function mostrarDato($valor) {
    return htmlspecialchars($valor ?? 'No especificado', ENT_QUOTES, 'UTF-8');
}

// Construir nombre completo
$nombreCompleto = mostrarDato($aprendiz['primer_nombre']);
if (!empty($aprendiz['segundo_nombre'])) {
    $nombreCompleto .= ' ' . mostrarDato($aprendiz['segundo_nombre']);
}
$nombreCompleto .= ' ' . mostrarDato($aprendiz['primer_apellido']);
if (!empty($aprendiz['segundo_apellido'])) {
    $nombreCompleto .= ' ' . mostrarDato($aprendiz['segundo_apellido']);
}

// Calcular edad
$fecha_nac = new DateTime($aprendiz['fecha_nacimiento']);
$hoy = new DateTime();
$edad = $hoy->diff($fecha_nac)->y;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Información del Aprendiz</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light">Nombre Completo:</th>
                                        <td><?php echo $nombreCompleto; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Tipo de Documento:</th>
                                        <td><?php echo mostrarDato($aprendiz['tipo_documento_descripcion']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Número de Documento:</th>
                                        <td><?php echo mostrarDato($aprendiz['numero_documento']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Fecha de Nacimiento:</th>
                                        <td><?php echo mostrarDato($aprendiz['fecha_nacimiento']); ?> (<?php echo $edad; ?> años)</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Sexo:</th>
                                        <td><?php echo mostrarDato($aprendiz['sexo']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Grupo Sanguíneo:</th>
                                        <td><?php echo mostrarDato($aprendiz['grupo_sanguineo']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Programa de Formación:</th>
                                        <td><?php echo mostrarDato($aprendiz['programa_formacion']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Número de Ficha:</th>
                                        <td><?php echo mostrarDato($aprendiz['numero_ficha']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="../../index.php" class="btn btn-secondary">Volver al Listado</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 