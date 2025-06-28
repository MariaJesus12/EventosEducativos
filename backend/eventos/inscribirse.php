<?php
include '../Conexiones/conexion.php';
include '../utils/verificar_rol.php';

verificarRol('estudiante');

$id_evento = $_POST['id_evento'];
$id_estudiante = $_SESSION['idUsuario'];

$sql = "INSERT INTO inscripciones (id_evento, id_estudiante) 
        VALUES ('$id_evento', '$id_estudiante')";

if (mysqli_query($conn, $sql)) {
    echo "Inscripción exitosa";
} else {
    echo "Ya estás inscrito o hubo un error: " . mysqli_error($conn);
}
?>
