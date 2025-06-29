<?php
session_start();
include '../conexion/conexion.php';

$where = '';
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'profesor') {
    $idUsuario = $_SESSION['idUsuario'];
    $where = "WHERE eventos.creado_por = '$idUsuario'";
}

$sql = "SELECT eventos.*, usuarios.nombre AS creado_por_nombre FROM eventos 
        LEFT JOIN usuarios ON eventos.creado_por = usuarios.id
        $where ORDER BY fecha DESC";
$result = mysqli_query($conn, $sql);

$eventos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $eventos[] = $row;
}
echo json_encode($eventos);
?>