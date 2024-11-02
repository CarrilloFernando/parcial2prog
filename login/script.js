// script.js

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');

    // Manejar el evento de envío del formulario
    registerForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Evitar el envío por defecto del formulario

        // Obtener los datos del formulario
        const formData = new FormData(registerForm);
        const data = Object.fromEntries(formData); // Convertir FormData a objeto

        try {
            // Enviar los datos a tu servidor Node.js
            const response = await fetch('http://localhost:3000/register', { // Cambia a tu URL si es necesario
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data) // Convertir objeto a JSON
            });

            // Manejar la respuesta
            if (response.ok) {
                const result = await response.json();
                alert('Registro exitoso: ' + JSON.stringify(result));
            } else {
                const error = await response.json();
                alert('Error al registrar: ' + error.message);
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
            alert('Error en la solicitud');
        }
    });
});



