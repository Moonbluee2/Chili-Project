<?php
session_start();

// Verificar si el usuario está logueado y es super administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
    header("Location: Login.html");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username_db = "tu_usuario";
$password_db = "tu_contraseña";
$dbname = "tu_base_de_datos";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener todos los usuarios
$sql = "SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gestionar Usuarios</h1>
        <nav>
            <a href="super_admin_dashboard.php">Volver al Dashboard</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['role']}</td>
                                <td>{$row['created_at']}</td>
                                <td>
                                    <a href='editar_usuario.php?id={$row['id']}'>Editar</a> | 
                                    <a href='eliminar_usuario.php?id={$row['id']}' onclick=\"return confirm('¿Estás seguro de eliminar este usuario?');\">Eliminar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay usuarios registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
<?php
$conn->close();
?>
