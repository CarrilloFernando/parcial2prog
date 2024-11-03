<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$db = new Database();
$db_con = $db->obtenerConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lee los datos json enviados en el cuerpo de la solicitud
    $input = json_decode(file_get_contents('php://input'), true);

    
    if (isset($input['nombre_usuario']) && isset($input['email']) && isset($input['password'])) {
        $nombre_usuario = $input['nombre_usuario'];
        $email = $input['email'];
        $password = $input['password'];

        
        $resultado = $db->insertarUsuario($nombre_usuario, $email, $password);

        
        header('Content-Type: application/json');
        echo json_encode($resultado);
    } else {
        // Respuesta en caso de datos faltantes
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "error",
            "message" => "Datos incompletos."
        ]);
    }
}
?>

