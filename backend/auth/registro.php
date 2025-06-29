<?php
include '../conexion/conexion.php';

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = $_POST['password'];
$rol = $_POST['rol'];

// Verifica si el email ya existe
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "El correo ya está registrado";
    exit;
}

// Inserta el nuevo usuario
$sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password', '$rol')";
if (mysqli_query($conn, $sql)) {
    echo "Registro exitoso";
} else {
    echo "Error al registrar: " . mysqli_error($conn);
}
?>