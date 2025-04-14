<?php
require_once '../../database/conexion.php';

try {
    $db = new Conexion();
    $conexion = $db->conexion;

    // Cargar tipos de documento
    $sql_tipos = "SELECT id, nombre FROM tipo_documento";
    $stmt_tipos = $conexion->query($sql_tipos);
    $tipos_documento = $stmt_tipos->fetchAll(PDO::FETCH_ASSOC);

    // Cargar sexos
    $sql_sexos = "SELECT id, descripcion FROM sexo";
    $stmt_sexos = $conexion->query($sql_sexos);
    $sexos = $stmt_sexos->fetchAll(PDO::FETCH_ASSOC);

    // Cargar grupos sanguíneos
    $sql_grupos = "SELECT id, grupo FROM grupo_sanguineo";
    $stmt_grupos = $conexion->query($sql_grupos);
    $grupos_sanguineos = $stmt_grupos->fetchAll(PDO::FETCH_ASSOC);

    // Cargar programas de formación
    $sql_programas = "SELECT id, nombre FROM programa_formacion";
    $stmt_programas = $conexion->query($sql_programas);
    $programas = $stmt_programas->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al cargar datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA || Crear Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Crear Aprendiz</h3>
                    </div>
                    <div class="card-body">
                        <form id="formCrearAprendiz" action="../../controller/AprendizController.php" method="POST" onsubmit="return guardarAprendiz('formCrearAprendiz', false)" class="needs-validation" novalidate>
                            <input type="hidden" name="action" value="crear">
                            
                            <!-- Datos Personales -->
                            <h4 class="mb-3">Datos Personales</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="primer_nombre" class="form-label">Primer Nombre *</label>
                                    <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required>
                                    <div class="invalid-feedback">El primer nombre es requerido</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                                    <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="primer_apellido" class="form-label">Primer Apellido *</label>
                                    <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required>
                                    <div class="invalid-feedback">El primer apellido es requerido</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido">
                                </div>
                            </div>

                            <!-- Documentación -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_documento_id" class="form-label">Tipo de Documento *</label>
                                    <select class="form-select" id="tipo_documento_id" name="tipo_documento_id" required>
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($tipos_documento as $tipo): ?>
                                            <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Seleccione un tipo de documento</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="numero_documento" class="form-label">Número de Documento *</label>
                                    <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
                                    <div class="invalid-feedback">El número de documento es requerido</div>
                                </div>
                            </div>

                            <!-- Información Adicional -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="sexo_id" class="form-label">Sexo *</label>
                                    <select class="form-select" id="sexo_id" name="sexo_id" required>
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sexos as $sexo): ?>
                                            <option value="<?= $sexo['id'] ?>"><?= htmlspecialchars($sexo['descripcion']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Seleccione el sexo</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="grupo_sanguineo_id" class="form-label">Grupo Sanguíneo</label>
                                    <select class="form-select" id="grupo_sanguineo_id" name="grupo_sanguineo_id">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($grupos_sanguineos as $grupo): ?>
                                            <option value="<?= $grupo['id'] ?>"><?= htmlspecialchars($grupo['grupo']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                    <div class="invalid-feedback">La fecha de nacimiento es requerida</div>
                                </div>
                            </div>

                            <!-- Información del Programa -->
                            <h4 class="mb-3">Información del Programa</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="programa_formacion_id" class="form-label">Programa de Formación *</label>
                                    <select class="form-select" id="programa_formacion_id" name="programa_formacion_id" required>
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($programas as $programa): ?>
                                            <option value="<?= $programa['id'] ?>"><?= htmlspecialchars($programa['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Seleccione un programa de formación</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="numero_ficha" class="form-label">Número de Ficha *</label>
                                    <input type="text" class="form-control" id="numero_ficha" name="numero_ficha" required>
                                    <div class="invalid-feedback">El número de ficha es requerido</div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Guardar Aprendiz</button>
                                <a href="../../index.php" class="btn btn-secondary">Volver</a>
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Nuestro archivo JavaScript -->
    <script src="../../assets/js/aprendiz.js"></script>
</body>
</html>