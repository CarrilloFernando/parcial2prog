(async () => {
    const fetch = await import('node-fetch').then(module => module.default);

    async function enviarDatos() {
        const data = {
            nombre_usuario: "UsuarioPrueba",
            email: "usuario@example.com",
            password: "MiContraseñaSegura123"
        };

        try {
            const response = await fetch('http://localhost/parcial/api/insertar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            console.log(result);
        } catch (error) {
            console.error("Error en la solicitud:", error);
        }
    }

    enviarDatos();
})();


