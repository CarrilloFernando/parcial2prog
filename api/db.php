<?php
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
                    "user" => [
                        "sesion iniciada",
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

    // Nuevo método para obtener usuarios
    public function getUsuarios() {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para insertar un nuevo usuario
    public function insertarUsuario($nombre_usuario, $email, $password) {
        // Verificar si el nombre de usuario o email ya existen
        $queryCheck = "SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = :nombre_usuario OR email = :email";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->bindParam(':nombre_usuario', $nombre_usuario);
        $stmtCheck->bindParam(':email', $email);
        $stmtCheck->execute();
        
        if ($stmtCheck->fetchColumn() > 0) {
            // Retornar un error si el usuario o email ya existen
            return ["status" => "error", "message" => "El nombre de usuario o email ya existen."];
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
        
    }

}
?>

