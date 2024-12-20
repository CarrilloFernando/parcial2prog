<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

class Database {
    private $host = "localhost";
    private $db_name = "foro_virtual";
    private $username = "root";
    private $password = "";
    public $conn;

    public function obtenerConexion() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }


    // Función para validar usuario
    public function validarUsuario($nombre_o_email, $password) {
        $query = "SELECT id_usuario, nombre_usuario, password, verificado, id_estado FROM usuarios WHERE nombre_usuario = :nombre_o_email OR email = :nombre_o_email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_o_email', $nombre_o_email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Verificar si la cuenta está verificada
            if ($usuario['verificado'] == 0) {
                return ["status" => "error", "message" => "La cuenta no está verificada."];
            }
    
            // Verificar el estado del usuario
            if ($usuario['id_estado'] != 1) { // Verificar que id_estado sea 1 (habilitado)
                return ["status" => "error", "message" => "La cuenta está suspendida o eliminada."];
            }
    
            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                return [
                    "status" => "success",
                    "message" => "Sesión iniciada correctamente.",
                    "user" => [
                        "id_usuario" => $usuario['id_usuario'],
                        "nombre_usuario" => $usuario['nombre_usuario'],
                        "id_estado" => $usuario['id_estado']
                    ]
                ];
            } else {
                return ["status" => "error", "message" => "Contraseña incorrecta."];
            }
        } else {
            return ["status" => "error", "message" => "El usuario no existe."];
        }
    }
    

    // Nuevo metodo para obtener usuarios
    public function getUsuarios() {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para insertar un nuevo usuario
    public function insertarUsuario($nombre_usuario, $email, $password) {
        // Verificar si el nombre de usuario ya existe
        $queryCheckUsername = "SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmtCheckUsername = $this->conn->prepare($queryCheckUsername);
        $stmtCheckUsername->bindParam(':nombre_usuario', $nombre_usuario);
        $stmtCheckUsername->execute();
        
        if ($stmtCheckUsername->fetchColumn() > 0) {
            // Retornar un error específico si el nombre de usuario ya existe
            return ["status" => "error", "message" => "El nombre de usuario ya existe."];
        }
        
        // Verificar si el email ya existe
        $queryCheckEmail = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmtCheckEmail = $this->conn->prepare($queryCheckEmail);
        $stmtCheckEmail->bindParam(':email', $email);
        $stmtCheckEmail->execute();
        
        if ($stmtCheckEmail->fetchColumn() > 0) {
            // Retornar un error específico si el email ya existe
            return ["status" => "error", "message" => "El email ya está registrado."];
        }
    
        // Hashear la contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
        // Generar un token de verificación único
        $token_verificacion = bin2hex(random_bytes(16));
    
        // Insertar el nuevo usuario con estado "Pendiente de verificación"
        $queryInsert = "INSERT INTO usuarios (nombre_usuario, email, password, verificado, token_verificacion, id_estado) 
                        VALUES (:nombre_usuario, :email, :password, 0, :token_verificacion, 4)";
        $stmtInsert = $this->conn->prepare($queryInsert);
        $stmtInsert->bindParam(':nombre_usuario', $nombre_usuario);
        $stmtInsert->bindParam(':email', $email);
        $stmtInsert->bindParam(':password', $passwordHash);
        $stmtInsert->bindParam(':token_verificacion', $token_verificacion);
    
        if ($stmtInsert->execute()) {
            $this->enviarCorreoVerificacion($email, $token_verificacion);
            return ["status" => "success", "message" => "Usuario registrado correctamente. Verifique su correo para activar la cuenta."];
        } else {
            return ["status" => "error", "message" => "No se pudo registrar el usuario."];
        }
    }
    


    public function enviarCorreoVerificacion($email, $token_verificacion) {
        $mail = new PHPMailer(true);
        
        try {
            // Configuracion del servidor de correo
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'florrolito@gmail.com'; //dirección de corro
            $mail->Password = 'soez kekb uxzb umac'; //contraseña de aplicación de Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del remitente y destinatario
            $mail->setFrom('florrolito@gmail.com', 'foro_virtual');
            $mail->addAddress($email); // Email y nombre del destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Verificación de Cuenta';
            $mail->Body = "
                <h1>Verificación de Cuenta</h1>
                <p>Gracias por registrarte. Haz clic en el enlace a continuación para verificar tu cuenta:</p>
                <a href='http://localhost/parcial/api/verificar.php?token=$token_verificacion'>Verificar Cuenta</a>
                <p>Si no solicitaste este registro, ignora este correo.</p>
            ";

            // Enviar el correo
            $mail->send();
            return ["status" => "success", "message" => "Correo enviado correctamente."];
        } catch (Exception $e) {
            return ["status" => "error", "message" => "No se pudo enviar el correo. Error: " . $mail->ErrorInfo];
        }
    }
    
    public function enviarCorreoRecuperacion($email, $token_recuperacion) {
        $mail = new PHPMailer(true);
        
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'florrolito@gmail.com';
            $mail->Password = 'soez kekb uxzb umac'; // Contraseña de aplicación de Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            // Configuración del remitente y destinatario
            $mail->setFrom('florrolito@gmail.com', 'Foro Virtual');
            $mail->addAddress($email);
    
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body = "
                <h1>Recuperación de Contraseña</h1>
                <p>Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el enlace a continuación para establecer una nueva contraseña:</p>
                <a href='http://localhost/parcial/login/cambiar_password.php?token=$token_recuperacion'>Restablecer Contraseña</a>
                <p>Si no solicitaste este cambio, ignora este correo.</p>
            ";

    
            // Enviar el correo
            $mail->send();
            return ["status" => "success", "message" => "Correo de recuperación enviado correctamente."];
        } catch (Exception $e) {
            return ["status" => "error", "message" => "No se pudo enviar el correo. Error: " . $mail->ErrorInfo];
        }
    }
    
}
?>

