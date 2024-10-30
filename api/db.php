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
            return ["status" => "success", "message" => "Usuario registrado correctamente. Verifique su correo para activar la cuenta."];
        } else {
            return ["status" => "error", "message" => "No se pudo registrar el usuario."];
        }
    }
}
?>

