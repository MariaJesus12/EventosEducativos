<?php
include '../Conexiones/conexion.php';
include '../utils/verificar_rol.php';

verificarRol('admin');

$id_usuario = $_POST['id_usuario'];
$nuevo_rol = $_POST['rol']; // debe ser 'admin', 'profesor' o 'estudiante'

$sql = "UPDATE usuarios SET rol = '$nuevo_rol' WHERE id = '$id_usuario'";

if (mysqli_query($conn, $sql)) {
    echo "Rol actualizado correctamente";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>