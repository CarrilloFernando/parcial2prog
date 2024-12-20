<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$db = new Database();
$db_con = $db->obtenerConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos la solicitud
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->nombre_o_email) && isset($data->password)) {
        $nombre_o_email = $data->nombre_o_email; // Puede ser nombre de usuario o email
        $password = $data->password;

        // llamal a la función psra validacion
        $resultado = $db->validarUsuario($nombre_o_email, $password);

        // retornar el resultado
        echo json_encode($resultado);
    } else {
        echo json_encode(["status" => "error", "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}
?>
