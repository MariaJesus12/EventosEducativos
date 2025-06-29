<?php
session_start();
include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['profesor', 'admin'])) {
    http_response_code(403);
    exit('No autorizado');
}

$id_evento = $_GET['id_evento'];

$sql = "SELECT usuarios.nombre FROM inscripciones 
        JOIN usuarios ON inscripciones.id_estudiante = usuarios.id
        WHERE inscripciones.id_evento = '$id_evento'";
$res = mysqli_query($conn, $sql);

$inscritos = [];
while ($row = mysqli_fetch_assoc($res)) {
    $inscritos[] = $row['nombre'];
}
echo json_encode($inscritos);
?>