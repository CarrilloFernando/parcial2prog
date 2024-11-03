<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$db = new Database();
$db_con = $db->obtenerConexion();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar el token en la base de datos
    $query = "SELECT id_usuario FROM usuarios WHERE token_verificacion = :token AND verificado = 0";
    $stmt = $db_con->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Actualizar verificado a 1 y cambiar id_estado a 1 (habilitado)
        $queryUpdate = "UPDATE usuarios SET verificado = 1, fecha_verificacion = NOW(), id_estado = 1 WHERE token_verificacion = :token";
        $stmtUpdate = $db_con->prepare($queryUpdate);
        $stmtUpdate->bindParam(':token', $token);

        if ($stmtUpdate->execute()) {
            // Redirecciona al login principal
            header("Location: http://localhost/parcial/login/login_principal.php");
            exit(); // Asegura que se detiene el script después de la redirección
        } else {
            echo "Error al actualizar el estado del usuario.";
        }
    } else {
        echo "Token no válido o cuenta ya verificada.";
    }
} else {
    echo "Token no proporcionado.";
}


