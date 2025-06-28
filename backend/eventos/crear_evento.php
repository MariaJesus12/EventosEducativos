<?php
include '../Conexiones/conexion.php';
include '../utils/verificar_rol.php';

verificarRol('profesor');

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha'];
$creado_por = $_SESSION['idUsuario'];

$sql = "INSERT INTO eventos (titulo, descripcion, fecha, creado_por) 
        VALUES ('$titulo', '$descripcion', '$fecha', '$creado_por')";

if (mysqli_query($conn, $sql)) {
    echo "Evento creado con éxito";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
