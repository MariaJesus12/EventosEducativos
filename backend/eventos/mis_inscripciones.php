<?php
session_start();
include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    http_response_code(403);
    exit('No autorizado');
}

$id_estudiante = $_SESSION['idUsuario'];
$sql = "SELECT id_evento FROM inscripciones WHERE id_estudiante='$id_estudiante'";
$res = mysqli_query($conn, $sql);

$ids = [];
while ($row = mysqli_fetch_assoc($res)) {
    $ids[] = $row['id_evento'];
}
echo json_encode($ids);
?>