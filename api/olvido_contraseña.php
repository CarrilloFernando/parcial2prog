<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $db_con = $db->obtenerConexion();

    // Decodificar el JSON recibido en el cuerpo
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? null; // Usa null si 'email' no está presente

    if ($email) {
        // Verificar si el email existe en la base de datos
        $query = "SELECT id_usuario FROM usuarios WHERE email = :email";
        $stmt = $db_con->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Generar el token de recuperación y guardarlo en la base de datos
            $token_recuperacion = bin2hex(random_bytes(16));
            $queryToken = "UPDATE usuarios SET token_verificacion = :token, fecha_modificacion = NOW() WHERE email = :email";
            $stmtToken = $db_con->prepare($queryToken);
            $stmtToken->bindParam(':token', $token_recuperacion);
            $stmtToken->bindParam(':email', $email);
            $stmtToken->execute();

            // Enviar el correo de recuperación
            $resultado = $db->enviarCorreoRecuperacion($email, $token_recuperacion);
            echo json_encode($resultado);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontró ninguna cuenta asociada con ese correo."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Correo electrónico no proporcionado."]);
    }
}
?>

