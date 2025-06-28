<?php
include '../Conexiones/conexion.php';

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
if (mysqli_query($conn, $sql)) {
    echo "Registro exitoso";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
