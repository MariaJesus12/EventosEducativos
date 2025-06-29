<?php
session_start();

include '../Conexiones/conexion.php';
include '../utils/verificar_rol.php';

// Detectar método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

include '../conexion/conexion.php';

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['profesor', 'admin'])) {
    http_response_code(403);
    exit('No autorizado');
}


// Si se está simulando un método (desde un formulario o fetch con POST)
$overrideMethod = $_POST['_method'] ?? null;
if ($method === 'POST' && $overrideMethod) {
    $method = strtoupper($overrideMethod); // "PUT", "DELETE"
    $input = $_POST;
}


switch ($method) {

    // 📄 Obtener todos los eventos o uno por ID
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM eventos WHERE id = $id";
            $res = mysqli_query($conn, $sql);
            echo json_encode(mysqli_fetch_assoc($res));
        } else {
            $sql = "SELECT * FROM eventos";
            $res = mysqli_query($conn, $sql);
            $eventos = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $eventos[] = $row;
            }
            echo json_encode($eventos);
        }
        break;

    // ➕ Crear evento
    case 'POST':
        verificarRol('profesor');

        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha = $_POST['fecha'] ?? '';
        $creado_por = $_SESSION['idUsuario'];

        if (!$titulo || !$fecha) {
            echo json_encode(["error" => "Faltan campos obligatorios"]);
            exit;
        }

        $sql = "INSERT INTO eventos (titulo, descripcion, fecha, creado_por)
                VALUES ('$titulo', '$descripcion', '$fecha', $creado_por)";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["mensaje" => "Evento creado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => mysqli_error($conn)]);
        }
        break;

    // ✏️ Actualizar evento
    case 'PUT':
        verificarRol('profesor');

        $id = $input['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "Falta ID"]);
            break;
        }

        $titulo = $input['titulo'] ?? '';
        $descripcion = $input['descripcion'] ?? '';
        $fecha = $input['fecha'] ?? '';

        $sql = "UPDATE eventos SET 
                  titulo = '$titulo', 
                  descripcion = '$descripcion', 
                  fecha = '$fecha' 
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["mensaje" => "Evento actualizado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => mysqli_error($conn)]);
        }
        break;

    // ❌ Eliminar evento
    case 'DELETE':
        verificarRol('profesor');

        $id = $input['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "Falta ID"]);
            break;
        }

        $sql = "DELETE FROM eventos WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["mensaje" => "Evento eliminado"]);
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