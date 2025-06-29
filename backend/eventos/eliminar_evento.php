<?php
session_start();
include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['profesor', 'admin'])) {
    http_response_code(403);
    exit('No autorizado');
}

$id = $_POST['id'];
$sql = "DELETE FROM eventos WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "Evento eliminado";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>