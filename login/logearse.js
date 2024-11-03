document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault(); 

    //  valores del formulario
    const nombre_o_email = document.getElementById('usernameOrEmail').value;
    const password = document.getElementById('password').value;

    // token de reCAPTCHA
    const recaptchaToken = grecaptcha.getResponse();

    // reCAPTCHA fue completado
    if (!recaptchaToken) {
        alert("Por favor, completa el reCAPTCHA.");
        return; // si el captcha no se complet, no envía los datos
    }

    // si el reCAPTCHA es válido, procede a enviar los datos de inicio de sesión
    const data = {
        nombre_o_email,
        password
    };

    // envía los datos a la API de validación
    try {
        const response = await fetch('http://localhost/parcial/api/validar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        // muestra el mensaje en la interfaz
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


