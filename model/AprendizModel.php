<?php
require_once __DIR__ . '/../config/config.php';
require_once BASE_PATH . '/database/conexion.php';

class AprendizModel {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conexion;
    }

    /**
     * Obtiene el persona_id de un aprendiz
     */
    private function obtener_id_usuario($id) {
        $sql = "SELECT persona_id FROM aprendices WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(['id' => $id]);
        $aprendiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aprendiz) {
            throw new Exception("Aprendiz no encontrado");
        }

        return $aprendiz['persona_id'];
    }

    public function crear($datos) {
        try {
            $this->conexion->beginTransaction();

            // Primero insertamos en la tabla personas
            $sql_persona = "INSERT INTO personas (
                primer_nombre, segundo_nombre, primer_apellido, segundo_apellido,
                tipo_documento_id, numero_documento, sexo_id, grupo_sanguineo_id,
                fecha_nacimiento
            ) VALUES (
                :primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido,
                :tipo_documento_id, :numero_documento, :sexo_id, :grupo_sanguineo_id,
                :fecha_nacimiento
            )";

            $stmt_persona = $this->conexion->prepare($sql_persona);
            $stmt_persona->execute([
                ':primer_nombre' => $datos['primer_nombre'],
                ':segundo_nombre' => $datos['segundo_nombre'],
                ':primer_apellido' => $datos['primer_apellido'],
                ':segundo_apellido' => $datos['segundo_apellido'],
                ':tipo_documento_id' => $datos['tipo_documento_id'],
                ':numero_documento' => $datos['numero_documento'],
                ':sexo_id' => $datos['sexo_id'],
                ':grupo_sanguineo_id' => empty($datos['grupo_sanguineo_id']) ? null : $datos['grupo_sanguineo_id'],
                ':fecha_nacimiento' => $datos['fecha_nacimiento']
            ]);

            $persona_id = $this->conexion->lastInsertId();

            // Luego insertamos en la tabla aprendices
            $sql_aprendiz = "INSERT INTO aprendices (
                persona_id, programa_formacion_id, numero_ficha
            ) VALUES (
                :persona_id, :programa_formacion_id, :numero_ficha
            )";

            $stmt_aprendiz = $this->conexion->prepare($sql_aprendiz);
            $stmt_aprendiz->execute([
                ':persona_id' => $persona_id,
                ':programa_formacion_id' => $datos['programa_formacion_id'],
                ':numero_ficha' => $datos['numero_ficha']
            ]);

            $this->conexion->commit();
            return ['status' => 'success', 'message' => 'Aprendiz creado exitosamente'];

        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return ['status' => 'error', 'message' => 'Error al crear el aprendiz: ' . $e->getMessage()];
        }
    }

    public function obtenerDetalles($id) {
        try {
            $sql = "SELECT 
                p.primer_nombre, p.segundo_nombre, p.primer_apellido, p.segundo_apellido,
                p.numero_documento, p.fecha_nacimiento,
                td.nombre as tipo_documento, td.descripcion as tipo_documento_descripcion,
                s.descripcion as sexo,
                gs.grupo as grupo_sanguineo,
                pf.nombre as programa_formacion,
                a.numero_ficha
            FROM aprendices a
            INNER JOIN personas p ON a.persona_id = p.id
            INNER JOIN tipo_documento td ON p.tipo_documento_id = td.id
            INNER JOIN sexo s ON p.sexo_id = s.id
            LEFT JOIN grupo_sanguineo gs ON p.grupo_sanguineo_id = gs.id
            INNER JOIN programa_formacion pf ON a.programa_formacion_id = pf.id
            WHERE a.id = :id";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error al obtener los detalles del aprendiz: ' . $e->getMessage()];
        }
    }

    public function actualizar($id, $datos) {
        try {
            $this->conexion->beginTransaction();

            // Obtenemos el persona_id usando la función reutilizable
            $persona_id = $this->obtener_id_usuario($id);

            // Actualizamos la tabla personas
            $sql_persona = "UPDATE personas SET 
                primer_nombre = :primer_nombre,
                segundo_nombre = :segundo_nombre,
                primer_apellido = :primer_apellido,
                segundo_apellido = :segundo_apellido,
                tipo_documento_id = :tipo_documento_id,
                numero_documento = :numero_documento,
                sexo_id = :sexo_id,
                grupo_sanguineo_id = :grupo_sanguineo_id,
                fecha_nacimiento = :fecha_nacimiento
                WHERE id = :persona_id";

            $stmt_persona = $this->conexion->prepare($sql_persona);
            $stmt_persona->execute([
                ':primer_nombre' => $datos['primer_nombre'],
                ':segundo_nombre' => $datos['segundo_nombre'],
                ':primer_apellido' => $datos['primer_apellido'],
                ':segundo_apellido' => $datos['segundo_apellido'],
                ':tipo_documento_id' => $datos['tipo_documento_id'],
                ':numero_documento' => $datos['numero_documento'],
                ':sexo_id' => $datos['sexo_id'],
                ':grupo_sanguineo_id' => empty($datos['grupo_sanguineo_id']) ? null : $datos['grupo_sanguineo_id'],
                ':fecha_nacimiento' => $datos['fecha_nacimiento'],
                ':persona_id' => $persona_id
            ]);

            // Actualizamos la tabla aprendices
            $sql_aprendiz = "UPDATE aprendices SET 
                programa_formacion_id = :programa_formacion_id,
                numero_ficha = :numero_ficha
                WHERE id = :id";

            $stmt_aprendiz = $this->conexion->prepare($sql_aprendiz);
            $stmt_aprendiz->execute([
                ':programa_formacion_id' => $datos['programa_formacion_id'],
                ':numero_ficha' => $datos['numero_ficha'],
                ':id' => $id
            ]);

            $this->conexion->commit();
            return ['status' => 'success', 'message' => 'Aprendiz actualizado exitosamente'];

        } catch (Exception $e) {
            $this->conexion->rollBack();
            return ['status' => 'error', 'message' => 'Error al actualizar el aprendiz: ' . $e->getMessage()];
        }
    }

    public function eliminar($id) {
        try {
            $this->conexion->beginTransaction();

            // Obtenemos el persona_id usando la función reutilizable
            $persona_id = $this->obtener_id_usuario($id);

            // Primero eliminamos el registro de la tabla aprendices
            $sql_delete_aprendiz = "DELETE FROM aprendices WHERE id = :id";
            $stmt = $this->conexion->prepare($sql_delete_aprendiz);
            $stmt->execute(['id' => $id]);

            // Luego eliminamos el registro de la tabla personas
            $sql_delete_persona = "DELETE FROM personas WHERE id = :persona_id";
            $stmt = $this->conexion->prepare($sql_delete_persona);
            $stmt->execute(['persona_id' => $persona_id]);

            $this->conexion->commit();
            return ['status' => 'success', 'message' => 'Aprendiz eliminado exitosamente'];

        } catch (Exception $e) {
            $this->conexion->rollBack();
            return ['status' => 'error', 'message' => 'Error al eliminar el aprendiz: ' . $e->getMessage()];
        }
    }
} 