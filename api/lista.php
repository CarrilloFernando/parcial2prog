<?php
require_once 'db.php';

$db = new Database();
$db_con = $db->obtenerConexion();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $usuarios = $db->getUsuarios();

    // Configura el encabezado para devolver JSON
    header('Content-Type: application/json');

    // Si se encontraron usuarios, los devuelve en formato JSON
    if ($usuarios) {
        echo json_encode([
            "status" => "success",
            "data" => $usuarios
        ]);
    } else {
        // Si no se encontraron usuarios, devuelve un mensaje de error
        echo json_encode([
            "status" => "error",
            "message" => "No se encontraron usuarios."
        ]);
    }
}
?>

