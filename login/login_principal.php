<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="form-container">
        <h2>Iniciar Sesión</h2>
        <form id="registroForm">
            <input type="text" id="username" placeholder="Nombre de usuario o correo" required>
            <input type="password" id="password" placeholder="Contraseña" required>
            <div class="captcha-container">
                <div class="g-recaptcha" data-sitekey="6LdVknMqAAAAAKWuPqraB1YnVFMvAwMJ3zsL_53_"></div>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
        <p><a href="reset_password.php">¿Olvidaste tu contraseña?</a></p>
    </div>
    <script src="/js/script.js"></script>
</body>
</html>
