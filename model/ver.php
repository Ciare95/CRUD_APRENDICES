<?php
include 'conexion.php';

$id = $_GET['id'];
$sql        = "SELECT * FROM aprendices WHERE id = $id";
$resultado  = mysqli_query($conexion, $sql);
$row        = mysqli_fetch_array($resultado);
$nombre     = $row['nombre'];
$fecha_nacimiento = $row['fecha_nacimiento'];

echo $nombre;
echo "<br>";
echo $fecha_nacimiento;
