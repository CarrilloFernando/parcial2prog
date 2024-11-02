<?php
session_start(); // Asegúrate de iniciar la sesión en la página principal

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['nombre_usuario'])) {
    // Si no hay una sesión activa, redirigir al login
    header("Location: ./login/login.php");
    exit();
}

// Obtener el nombre del usuario
$nombre_usuario = $_SESSION['nombre_usuario'];
$id_rol = $_SESSION['id_rol']; // Asegúrate de que esta línea esté aquí
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Línea</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>    

    <nav class="container">
        <div>
            <div class="buttons">
                <button onclick="window.location.href= 'index.php'">Inicio</button>
                <button onclick="window.location.href= 'gestion_linea.php'">Adm. de Sectores</button>
                <button onclick="window.location.href='puesto1.php'">Puesto 1</button>
                <button onclick="window.location.href='puesto2.php'">Puesto 2</button>
                <button onclick="window.location.href='puesto3.php'">Puesto 3</button>
                

            </div>
        </div>
    </nav>

    <!--mostrar nombre del usuario que inicio sesion-->  
    <div class="mostra_nombre_usuario">
        <h5 class="boton_muestra">Username: <?php echo htmlspecialchars($nombre_usuario); ?></h5>
        <div>    
            <button class="boton_cerrar" onclick="window.location.href='./login/cerrar_sesion.php'"><span aria-hidden="true">&times;</span> Cerrar Sesión</button>
        </div>
    </div>    
    

    <div class="menu_gestion">
        <h2>Administración de Sectores</h2>
    
        <?php if ($id_rol == 5 || $id_rol == 6): // Rol 1 y 2 tienen acceso a Productos ?>
            <button class="boton_menu" onclick="window.location.href='./productos/Productos.php'">Productos</button>
        <?php else: ?>
            <button class="boton_menu" disabled title="No tienes permiso para acceder a esta página">Productos</button>
        <?php endif; ?>

        <?php if ($id_rol == 4 || $id_rol == 6): // Solo el rol 1 tiene acceso a Orden de Producción ?>
            <button class="boton_menu" onclick="window.location.href='./TP/orden_de_producto_P2.php'">Orden de Producción</button>
        <?php else: ?>
            <button class="boton_menu" disabled title="No tienes permiso para acceder a esta página">Orden de Producción</button>
        <?php endif; ?>

        <?php if ($id_rol == 3 || $id_rol == 6): // Rol 1 y 2 tienen acceso a Orden de Carga ?>
            <button class="boton_menu" onclick="window.location.href='./orden_carga/crear_orden_carga.php'">Orden de Carga</button>
        <?php else: ?>
            <button class="boton_menu" disabled title="No tienes permiso para acceder a esta página">Orden de Carga</button>
        <?php endif; ?>

        <?php if ($id_rol == 2 || $id_rol == 6): // Rol 1 y 2 tienen acceso a Fórmulas ?>
            <button class="boton_menu" onclick="window.location.href='./interfazNueva/seleccionarFormula.php'">Fórmulas</button>
        <?php else: ?>
            <button class="boton_menu" disabled title="No tienes permiso para acceder a esta página">Fórmulas</button>
        <?php endif; ?>

        <?php if ($id_rol == 1 || $id_rol == 6): // Rol 1 y 2 tienen acceso a Usuarios ?>
            <button class="boton_menu" onclick="window.location.href='./login/usuarios.php'">Usuarios</button>
        <?php else: ?>
            <button class="boton_menu" disabled title="No tienes permiso para acceder a esta página">Usuarios</button>
        <?php endif; ?>

    </div>


    
</body>
</html>





