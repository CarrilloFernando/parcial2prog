document.getElementById('registroForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const nombre_usuario = document.getElementById('nombre_usuario').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const data = {
        nombre_usuario: nombre_usuario,
        email: email,
        password: password
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
        document.getElementById('mensajeRespuesta').textContent = result.message;
    } catch (error) {
        console.error('Error en la solicitud:', error);
        document.getElementById('mensajeRespuesta').textContent = "Error en la solicitud. Inténtelo de nuevo.";
    }
});
