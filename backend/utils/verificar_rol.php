<?php
function verificarRol($rolRequerido) {
    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != $rolRequerido) {
        echo "Acceso denegado";
        exit;
    }
}
?>