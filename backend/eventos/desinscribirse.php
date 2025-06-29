<?php
session_start();
include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    http_response_code(403);
    exit('No autorizado');
}

$id_evento = $_POST['id_evento'];
$id_estudiante = $_SESSION['idUsuario'];

$sql = "DELETE FROM inscripciones WHERE id_evento='$id_evento' AND id_estudiante='$id_estudiante'";
if (mysqli_query($conn, $sql)) {
    echo "Desinscripción exitosa";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>