<?php
session_start();
include '../conexion/conexion.php'; // corrige el nombre del archivo

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($conn, $sql);

if ($usuario = mysqli_fetch_assoc($resultado)) {
    // Solo compara texto plano
    if ($password == $usuario['password']) {
        $_SESSION['idUsuario'] = $usuario['id'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['nombre'] = $usuario['nombre']; // <-- agrega esto
        echo "Login exitoso como " . $usuario['rol'];
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}
?>
