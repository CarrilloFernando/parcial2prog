document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    // Obtén los valores del formulario
    const nombre_o_email = document.getElementById('usernameOrEmail').value;
    const password = document.getElementById('password').value;

    // Obtén el token de reCAPTCHA
    const recaptchaToken = grecaptcha.getResponse();

    // Verifica si el reCAPTCHA fue completado
    if (!recaptchaToken) {
        alert("Por favor, completa el reCAPTCHA.");
        return; // Si el captcha no se completó, no envía los datos
    }

    // Si el reCAPTCHA es válido, procede a enviar los datos de inicio de sesión
    const data = {
        nombre_o_email,
        password
    };

    // Envía los datos a la API de validación
    try {
        const response = await fetch('http://localhost/parcial/api/validar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        // Muestra el mensaje en la interfaz
        document.getElementById('loginMessage').textContent = result.message;

        if (result.status === "success") {
            window.location.href = '../index.php';
        } else {
            alert("Error: " + result.message);
        }

    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert("Error en la solicitud. Inténtelo de nuevo.");
    }
});


