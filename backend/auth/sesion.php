<?php
session_start();
if (isset($_SESSION['idUsuario']) && isset($_SESSION['rol'])) {
    echo json_encode([
        "logged" => true,
        "rol" => $_SESSION['rol'],
        "nombre" => isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ""
    ]);
} else {
    echo json_encode(["logged" => false]);
}
?>