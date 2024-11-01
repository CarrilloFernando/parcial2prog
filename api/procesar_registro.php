<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibe los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Crear JSON directamente con los datos
    $jsonData = json_encode([
        'nombre_usuario' => $nombre_usuario,
        'email' => $email,
        'password' => $password
    ]);

    // Inicializar cURL
    $ch = curl_init('http://localhost/parcial/api/insertar.php'); // Ajusta la URL a tu API

    // Configuración de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    
    if ($response === false) {
        // Maneja errores de cURL si ocurren
        echo "Error en la solicitud: " . curl_error($ch);
    } else {
        // Muestra la respuesta JSON sin convertir a un arreglo
        echo "Respuesta de la API: " . $response;
    }

    // Cierra cURL
    curl_close($ch);
}
?>

