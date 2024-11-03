document.getElementById('change-password-form').addEventListener('submit', async function (e) {
    e.preventDefault(); 

    // Obtiene el token
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');

    // Obtiene las nuevas contraseñas
    const newPassword = document.getElementById('new-password').value.trim();
    const confirmNewPassword = document.getElementById('confirm-new-password').value.trim();

    // Verifica que las contraseñas coincidan
    if (newPassword !== confirmNewPassword) {
        alert("Las contraseñas no coinciden. Intenta nuevamente.");
        return; // Detiene el envío si las contraseñas no coinciden
    }

    // Prepara los datos para el envío
    const data = {
        token: token,
        nueva_password: newPassword
    };

    try {
        const response = await fetch('http://localhost/parcial/api/restablecer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        // muestra el mensaje en la interfaz
        alert(result.message); // muestra el mensaje del servidor

        if (result.status === "success") {
            // redirige al usuario al login principal después de un cambio exitoso
            window.location.href = 'login_principal.php';
        }

    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert("Error en la solicitud. Inténtelo de nuevo.");
    }
});
