<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $db_con = $db->obtenerConexion();

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $token = $data['token'] ?? null;
    $nueva_password = $data['nueva_password'] ?? null;

    if ($token && $nueva_password) {
        // Primero, verificar si el token existe en la base de datos
        $queryCheck = "SELECT id_usuario FROM usuarios WHERE token_verificacion = :token";
        $stmtCheck = $db_con->prepare($queryCheck);
        $stmtCheck->bindParam(':token', $token);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            // Hashear la nueva contraseña
            $hashed_password = password_hash($nueva_password, PASSWORD_BCRYPT);

            // Actualizar la contraseña y limpiar el token de verificación
            $queryUpdate = "UPDATE usuarios SET password = :password, token_verificacion = NULL WHERE token_verificacion = :token";
            $stmtUpdate = $db_con->prepare($queryUpdate);
            $stmtUpdate->bindParam(':password', $hashed_password);
            $stmtUpdate->bindParam(':token', $token);

            if ($stmtUpdate->execute()) {
                echo json_encode(["status" => "success", "message" => "Contraseña actualizada correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar la contraseña."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "El token es inválido o ha expirado."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Datos incompletos. Se requiere el token y la nueva contraseña."]);
    }
}
?>


