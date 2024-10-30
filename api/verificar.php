<?php
include 'db.php';

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
            echo "Cuenta verificada exitosamente y estado actualizado a habilitado.";
        } else {
            echo "Error al actualizar el estado del usuario.";
        }
    } else {
        echo "Token no válido o cuenta ya verificada.";
    }
} else {
    echo "Token no proporcionado.";
}

