<?php
session_start();
include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['profesor', 'admin'])) {
    http_response_code(403);
    exit('No autorizado');
}

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha'];

$sql = "UPDATE eventos SET titulo='$titulo', descripcion='$descripcion', fecha='$fecha' WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "Evento actualizado";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>