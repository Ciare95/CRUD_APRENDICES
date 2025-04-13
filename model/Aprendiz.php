<?php

class Aprendiz {
    private $id;
    private $primer_nombre;
    private $fecha_nacimiento;
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conexion;
    }

    public function setNombre($primer_nombre) {
        if (empty($primer_nombre)) {
            throw new Exception("El nombre no puede estar vacío");
        }
        if (strlen($primer_nombre) > 50) {
            throw new Exception("El nombre no puede exceder los 50 caracteres");
        }
        $this->primer_nombre = $primer_nombre;
    }

    public function setFechaNacimiento($fecha_nacimiento) {
        $fecha = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
        if (!$fecha) {
            throw new Exception("Formato de fecha inválido");
        }
        $hoy = new DateTime();
        if ($fecha > $hoy) {
            throw new Exception("La fecha de nacimiento no puede ser futura");
        }
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function crear() {
        try {
            $sql = "INSERT INTO aprendices (primer_nombre, fecha_nacimiento) VALUES (:nombre, :fecha)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $this->primer_nombre);
            $stmt->bindParam(':fecha', $this->fecha_nacimiento);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al crear el aprendiz: " . $e->getMessage());
        }
    }
} 