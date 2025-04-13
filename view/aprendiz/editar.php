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
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="card-title mb-0">Editar Aprendiz</h3>
                    </div>
                    <div class="card-body">
                        <form action="../../controller/AprendizController.php" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="actualizar">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                            <!-- Datos Personales -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="primer_nombre" class="form-label">Primer Nombre *</label>
                                    <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" 
                                           value="<?php echo mostrarDato($aprendiz['primer_nombre']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                                    <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" 
                                           value="<?php echo mostrarDato($aprendiz['segundo_nombre']); ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="primer_apellido" class="form-label">Primer Apellido *</label>
                                    <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" 
                                           value="<?php echo mostrarDato($aprendiz['primer_apellido']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" 
                                           value="<?php echo mostrarDato($aprendiz['segundo_apellido']); ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tipo_documento_id" class="form-label">Tipo de Documento *</label>
                                    <select class="form-select" id="tipo_documento_id" name="tipo_documento_id" required>
                                        <?php
                                        $db = new Conexion();
                                        $stmt = $db->conexion->query("SELECT id, descripcion FROM tipo_documento");
                                        while ($row = $stmt->fetch()) {
                                            $selected = ($aprendiz['tipo_documento'] == $row['nombre']) ? 'selected' : '';
                                            echo "<option value='{$row['id']}' {$selected}>{$row['descripcion']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_documento" class="form-label">Número de Documento *</label>
                                    <input type="text" class="form-control" id="numero_documento" name="numero_documento" 
                                           value="<?php echo mostrarDato($aprendiz['numero_documento']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="sexo_id" class="form-label">Sexo *</label>
                                    <select class="form-select" id="sexo_id" name="sexo_id" required>
                                        <?php
                                        $stmt = $db->conexion->query("SELECT id, descripcion FROM sexo");
                                        while ($row = $stmt->fetch()) {
                                            $selected = ($aprendiz['sexo'] == $row['descripcion']) ? 'selected' : '';
                                            echo "<option value='{$row['id']}' {$selected}>{$row['descripcion']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="grupo_sanguineo_id" class="form-label">Grupo Sanguíneo</label>
                                    <select class="form-select" id="grupo_sanguineo_id" name="grupo_sanguineo_id">
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $stmt = $db->conexion->query("SELECT id, grupo FROM grupo_sanguineo");
                                        while ($row = $stmt->fetch()) {
                                            $selected = ($aprendiz['grupo_sanguineo'] == $row['grupo']) ? 'selected' : '';
                                            echo "<option value='{$row['id']}' {$selected}>{$row['grupo']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" 
                                           value="<?php echo mostrarDato($aprendiz['fecha_nacimiento']); ?>" required>
                                </div>
                            </div>

                            <!-- Datos del Programa -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="programa_formacion_id" class="form-label">Programa de Formación *</label>
                                    <select class="form-select" id="programa_formacion_id" name="programa_formacion_id" required>
                                        <?php
                                        $stmt = $db->conexion->query("SELECT id, nombre FROM programa_formacion");
                                        while ($row = $stmt->fetch()) {
                                            $selected = ($aprendiz['programa_formacion'] == $row['nombre']) ? 'selected' : '';
                                            echo "<option value='{$row['id']}' {$selected}>{$row['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_ficha" class="form-label">Número de Ficha *</label>
                                    <input type="text" class="form-control" id="numero_ficha" name="numero_ficha" 
                                           value="<?php echo mostrarDato($aprendiz['numero_ficha']); ?>" required>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="../../index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-warning">Actualizar Aprendiz</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Validación del formulario
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
    </script>
</body>

</html>