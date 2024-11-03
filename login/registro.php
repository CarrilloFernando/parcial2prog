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
            
            <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre de Usuario" required>
            
            
            <input type="email" id="email" name="email" placeholder="Email" required>
            
            
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            
            <button type="submit">Registrar Usuario</button> <br></br>
            <a href="login_principal.php">¿Ya tienes cuenta?</a>
        </form>
    </div>

    <script src="registrar_usuario.js"></script> <!-- Este es tu archivo de JavaScript -->
</body>
</html>

