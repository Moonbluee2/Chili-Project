<?php
// admin_dashboard.php
require 'auth.php';

// Verificar que el usuario sea un administrador
checkRole('administrador');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Administrador: <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <nav>
            <a href="logout.php">Cerrar Sesión</a>
            <a href="agregar_producto.php">Agregar Producto</a>
            <a href="gestionar_productos.php">Gestionar Productos</a>
            <a href="seguimiento_ventas.php">Seguimiento de Ventas</a>
            <!-- Otros enlaces relevantes para administradores -->
        </nav>
    </header>
    <main>
        <!-- Contenido para administradores: agregar/modificar productos, ver ventas, etc. -->
    </main>
</body>
</html>