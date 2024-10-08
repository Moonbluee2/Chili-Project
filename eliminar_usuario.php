<?php
session_start();

// Verificar si el usuario está logueado y es super administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
    header("Location: Login.html");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Conexión a la base de datos
    $servername = "localhost";
    $username_db = "tu_usuario";
    $password_db = "tu_contraseña";
    $dbname = "tu_base_de_datos";
    
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    // Eliminar el usuario
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo "Usuario eliminado exitosamente. <a href='gestionar_usuarios.php'>Volver</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: gestionar_usuarios.php");
    exit();
}
?>
