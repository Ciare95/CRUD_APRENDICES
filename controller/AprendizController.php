<?php
require_once '../config/config.php';
require_once BASE_PATH . '/model/AprendizModel.php';

class AprendizController {
    private $modelo;

    public function __construct() {
        $this->modelo = new AprendizModel();
    }

    public function crear($datos) {
        return $this->modelo->crear($datos);
    }

    public function actualizar($id, $datos) {
        // Validación de campos requeridos
        $campos_requeridos = [
            'primer_nombre', 'primer_apellido', 'tipo_documento_id',
            'numero_documento', 'sexo_id', 'fecha_nacimiento',
            'programa_formacion_id', 'numero_ficha'
        ];

        foreach ($campos_requeridos as $campo) {
            if (empty($datos[$campo])) {
                return [
                    'status' => 'error',
                    'message' => "El campo $campo es requerido"
                ];
            }
        }

        return $this->modelo->actualizar($id, $datos);
    }

    public function eliminar($id) {
        if (!is_numeric($id)) {
            return [
                'status' => 'error',
                'message' => 'ID inválido'
            ];
        }
        return $this->modelo->eliminar($id);
    }
}

// Manejo de las peticiones
if (($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) || 
    ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']))) {
    
    $controller = new AprendizController();
    $action = $_POST['action'] ?? $_GET['action'];
    
    switch ($action) {
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
            
        case 'actualizar':
            if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
                header('Location: ../index.php?error=id_invalido');
                exit;
            }

            $resultado = $controller->actualizar($_POST['id'], $_POST);
            
            if ($resultado['status'] === 'success') {
                header('Location: ../index.php?mensaje=actualizado');
            } else {
                header('Location: ../view/aprendiz/editar.php?id=' . $_POST['id'] . '&error=' . urlencode($resultado['message']));
            }
            break;
            
        case 'eliminar':
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                header('Location: ../index.php?error=id_invalido');
                exit;
            }

            $resultado = $controller->eliminar($_GET['id']);
            
            if ($resultado['status'] === 'success') {
                header('Location: ../index.php?mensaje=eliminado');
            } else {
                header('Location: ../index.php?error=' . urlencode($resultado['message']));
            }
            break;
            
        default:
            header('Location: ../index.php?error=accion_invalida');
    }
    exit;
} 