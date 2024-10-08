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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $role = $_POST['role'];
    
    // Actualizar el rol del usuario
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $role, $user_id);
    
    if ($stmt->execute()) {
        echo "Usuario actualizado exitosamente. <a href='gestionar_usuarios.php'>Volver</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    exit();
}

// Obtener el ID del usuario a editar
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Obtener datos del usuario
    $stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $email, $role);
    $stmt->fetch();
    $stmt->close();
} else {
    header("Location: gestionar_usuarios.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container edit-user-container">
        <h1>Editar Usuario: <?php echo htmlspecialchars($username); ?></h1>
        <form action="editar_usuario.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            
            <label for="role">Rol</label>
            <select name="role" id="role" required>
                <option value="cliente" <?php if ($role == 'cliente') echo 'selected'; ?>>Cliente</option>
                <option value="administrador" <?php if ($role == 'administrador') echo 'selected'; ?>>Administrador</option>
                <option value="super_admin" <?php if ($role == 'super_admin') echo 'selected'; ?>>Super Administrador</option>
            </select>
            
            <button type="submit">Actualizar Usuario</button>
        </form>
        <a href="gestionar_usuarios.php">Volver</a>
    </div>
</body>
</html>
