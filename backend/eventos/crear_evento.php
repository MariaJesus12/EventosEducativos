<?php
session_start();
include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['profesor', 'admin'])) {
    http_response_code(403);
    exit('No autorizado');
}

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha'];
$creado_por = $_SESSION['idUsuario'];

$sql = "INSERT INTO eventos (titulo, descripcion, fecha, creado_por) VALUES ('$titulo', '$descripcion', '$fecha', '$creado_por')";
if (mysqli_query($conn, $sql)) {
    echo "Evento creado con éxito";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
