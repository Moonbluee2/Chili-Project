<?php
// cliente_dashboard.php
require 'auth.php';

// Verificar que el usuario sea un cliente
checkRole('cliente');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <nav>
            <a href="logout.php">Cerrar Sesión</a>
            <a href="favoritos.php">Favoritos</a>
            <!-- Otros enlaces relevantes para clientes -->
        </nav>
    </header>
    <main>
        <!-- Contenido para clientes: comprar productos, ver favoritos, etc. -->
    </main>
</body>
</html>