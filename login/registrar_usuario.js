document.getElementById('registroForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const nombre_usuario = document.getElementById('nombre_usuario').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    const data = {
        nombre_usuario,
        email,
        password
    };

    try {
        const response = await fetch('http://localhost/parcial/api/insertar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        // Muestra un mensaje de alerta basado en la respuesta del servidor
        if (result.status === "success") {
            
            window.location.href = "pagina_espera.php"; // Página de espera
        } else {
            alert("Error en el registro: " + result.message);
        }

        // También actualiza el mensaje en pantalla
        document.getElementById('mensajeRespuesta').textContent = result.message;
        
    } catch (error) {
        console.error('Error en la solicitud:', error);

        // Muestra un mensaje de alerta en caso de error en la solicitud

        // También actualiza el mensaje en pantalla
        document.getElementById('mensajeRespuesta').textContent = "Error en la solicitud. Inténtelo de nuevo.";
    }
});

