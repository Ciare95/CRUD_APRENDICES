<?php
require_once '../model/AprendizModel.php';

class AprendizController {
    private $modelo;

    public function __construct() {
        $this->modelo = new AprendizModel();
    }

    public function crear($datos) {
        return $this->modelo->crear($datos);
    }
}

// Manejo de las peticiones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new AprendizController();
    
    switch ($_POST['action']) {
        case 'crear':
            // Validar campos requeridos
            $campos_requeridos = [
                'primer_nombre', 'primer_apellido', 'tipo_documento_id',
                'numero_documento', 'sexo_id', 'fecha_nacimiento',
                'programa_formacion_id', 'numero_ficha'
            ];

            $errores = [];
            foreach ($campos_requeridos as $campo) {
                if (empty($_POST[$campo])) {
                    $errores[] = "El campo $campo es requerido";
                }
            }

            if (!empty($errores)) {
                header('Location: ../view/aprendiz/crear.php?error=' . urlencode(implode(', ', $errores)));
                exit;
            }

            $resultado = $controller->crear($_POST);
            
            if ($resultado['status'] === 'success') {
                header('Location: ../index.php?mensaje=creado');
            } else {
                header('Location: ../view/aprendiz/crear.php?error=' . urlencode($resultado['message']));
            }
            break;
            
        default:
            header('Location: ../index.php?error=accion_invalida');
    }
    exit;
} 