<?php
require_once '../database/conexion.php';

class AprendizModel {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conexion;
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
} 