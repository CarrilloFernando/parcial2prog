<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Registro de Usuario</h2>
        <form id="registroForm">
        <label for="nombre">Nombre de Usuario:</label>
        <input type="text" id="nombre" name="NOMBRE_USUARIO" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="EMAIL" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="PASSWORD" required>
        
        <button type="submit">Registrar</button>
        <a href="login_principal.php">¿Ya tienes cuenta?</a>
    </form>
    </div>

    <script src="script.js"></script> <!-- Este es tu archivo de JavaScript -->
</body>
</html>

