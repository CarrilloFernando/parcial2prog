<?php
include 'db.php';

$db = new Database();
$db_con = $db->obtenerConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->nombre_o_email) && isset($data->password)) {
        $nombre_o_email = $data->nombre_o_email; // Puede ser nombre de usuario o email
        $password = $data->password;

        // Llamar a la función de validación
        $resultado = $db->validarUsuario($nombre_o_email, $password);

        // Retornar el resultado
        echo json_encode($resultado);
    } else {
        echo json_encode(["status" => "error", "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}
?>
