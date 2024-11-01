<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $db_con = $db->obtenerConexion();

    // Obtener el contenido de la solicitud y decodificar JSON
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    // Verificación de datos decodificados
    if (!$data) {
        echo json_encode(["status" => "error", "message" => "No se recibieron datos JSON válidos."]);
        exit;
    }

    $token = $data['token'] ?? null;
    $nueva_password = $data['nueva_password'] ?? null;

    if ($token && $nueva_password) {
        // Hashear la nueva contraseña
        $hashed_password = password_hash($nueva_password, PASSWORD_BCRYPT);

        // Verificar el token y actualizar la contraseña
        $query = "UPDATE usuarios SET password = :password, token_verificacion = NULL WHERE token_verificacion = :token";
        $stmt = $db_con->prepare($query);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':token', $token);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Contraseña actualizada correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "El token es inválido o ha expirado."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Datos incompletos. Se requiere el token y la nueva contraseña."]);
    }
}
?>
