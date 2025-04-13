<?php

class Conexion {
    private $server;
    private $database;
    private $usuario;
    private $contrasenia;
    public $conexion;

    public function __construct($server = "localhost", $database = "prueba_db", $usuario = "root", $contrasenia = "") {
        $this->server = $server;
        $this->database = $database;
        $this->usuario = $usuario;
        $this->contrasenia = $contrasenia;
        $this->conectar();
    }
    

    public function conectar() {
        try {
            $dsn = "mysql:host={$this->server};dbname={$this->database};charset=utf8mb4";
            $this->conexion = new PDO($dsn, $this->usuario, $this->contrasenia);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Error de conexión: " . $e->getMessage());
        }
    }
}
