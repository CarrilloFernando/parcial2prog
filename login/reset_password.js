document.getElementById('reset-password-form').addEventListener('submit', async function (e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    // Obtén el correo electrónico del campo de entrada
    const email = document.getElementById('email').value.trim();

    // Crea el objeto de datos para enviar
    const data = {
        email: email
    };

    try {
        // solicitud al endpoint
        const response = await fetch('http://localhost/parcial/api/olvido_contraseña.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        //  respuesta del servidor
        const result = await response.json();

        // Muestra un mensaje 
        if (result.status === "success") {
            alert("Se ha enviado un correo de restablecimiento de contraseña. Revisa tu bandeja de entrada.");
        } else {
            alert("Error: " + result.message);
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert("Error al enviar la solicitud. Intenta de nuevo más tarde.");
    }
});
