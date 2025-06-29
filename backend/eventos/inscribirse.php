<?php
session_start();
include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    http_response_code(403);
    exit('No autorizado');
}

$id_evento = $_POST['id_evento'];
$id_estudiante = $_SESSION['idUsuario'];

// Evitar inscripciones duplicadas
$sql_check = "SELECT * FROM inscripciones WHERE id_evento='$id_evento' AND id_estudiante='$id_estudiante'";
$res_check = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($res_check) > 0) {
    echo "Ya estás inscrito en este evento.";
    exit;
}

$sql = "INSERT INTO inscripciones (id_evento, id_estudiante) VALUES ('$id_evento', '$id_estudiante')";
if (mysqli_query($conn, $sql)) {
    echo "Inscripción exitosa";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>