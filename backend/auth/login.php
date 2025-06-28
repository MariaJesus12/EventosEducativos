<?php
session_start();
include '../Conexiones/conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($conn, $sql);

if ($usuario = mysqli_fetch_assoc($resultado)) {
    if (password_verify($password, $usuario['password'])) {
        $_SESSION['idUsuario'] = $usuario['id'];
        $_SESSION['rol'] = $usuario['rol'];
        echo "Login exitoso como " . $usuario['rol'];
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}
?>
