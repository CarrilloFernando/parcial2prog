document.getElementById('registerForm').addEventListener('submit', async function (e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    // Obtén los valores del formulario
    const nombre_usuario = document.getElementById('nombre_usuario').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Crea el objeto JSON con los datos
    const data = {
        nombre_usuario,
        email,
        password
    };

    // Envía los datos a la API
    try {
        const response = await fetch('http://localhost/parcial/api/insertar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        // Muestra el mensaje en la interfaz
        document.getElementById('responseMessage').textContent = result.message;

    } catch (error) {
        console.error('Error en la solicitud:', error);
        document.getElementById('responseMessage').textContent = "Error en la solicitud. Inténtelo de nuevo.";
    }
});