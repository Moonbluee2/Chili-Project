<?php
// super_admin_dashboard.php
require 'auth.php';

// Verificar que el usuario sea un super administrador
checkRole('super_admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Super Administrador: <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <nav>
            <a href="logout.php">Cerrar Sesión</a>
            <a href="gestionar_usuarios.php">Gestionar Usuarios</a>
            <a href="gestionar_vendedores.php">Gestionar Vendedores</a>
            <!-- Otros enlaces relevantes para super administradores -->
        </nav>
    </header>
    <main>
        <!-- Contenido para super administradores: gestionar usuarios, resolver conflictos, etc. -->
    </main>
</body>
</html>