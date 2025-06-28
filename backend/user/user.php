<?php
session_start();
include '../Conexiones/conexion.php';
include '../utils/verificar_rol.php';

// Detectar método
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

// Simulación de métodos con _method (POST simulado)
$overrideMethod = $_POST['_method'] ?? null;
if ($method === 'POST' && $overrideMethod) {
    $method = strtoupper($overrideMethod);
    $input = $_POST;
}

switch ($method) {

    case 'GET':
        verificarRol('admin');

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT id, nombre, email, rol FROM usuarios WHERE id = $id";
            $res = mysqli_query($conn, $sql);
            echo json_encode(mysqli_fetch_assoc($res));
        } else {
            $sql = "SELECT id, nombre, email, rol FROM usuarios";
            $res = mysqli_query($conn, $sql);
            $usuarios = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $usuarios[] = $row;
            }
            echo json_encode($usuarios);
        }
        break;

    case 'POST':
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$nombre || !$email || !$password) {
            echo json_encode(["error" => "Faltan campos"]);
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$hash')";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["mensaje" => "Usuario registrado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => mysqli_error($conn)]);
        }
        break;

    case 'PUT':
        verificarRol('admin');

        $id = $input['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "Falta ID"]);
            break;
        }

        $nombre = $input['nombre'] ?? null;
        $email = $input['email'] ?? null;
        $rol = $input['rol'] ?? null;

        $set = [];
        if ($nombre) $set[] = "nombre = '$nombre'";
        if ($email) $set[] = "email = '$email'";
        if ($rol)   $set[] = "rol = '$rol'";

        if (empty($set)) {
            echo json_encode(["error" => "Nada que actualizar"]);
            break;
        }

        $sql = "UPDATE usuarios SET " . implode(', ', $set) . " WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["mensaje" => "Usuario actualizado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => mysqli_error($conn)]);
        }
        break;

    case 'DELETE':
        verificarRol('admin');

        $id = $input['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "Falta ID"]);
            break;
        }

        $sql = "DELETE FROM usuarios WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["mensaje" => "Usuario eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => mysqli_error($conn)]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
