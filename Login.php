<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username_db = "tu_usuario";
$password_db = "tu_contraseña";
$dbname = "tu_base_de_datos";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Buscar el usuario en la base de datos
$stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password, $role);
    $stmt->fetch();
    
    // Verificar la contraseña
    if (password_verify($password, $hashed_password)) {
        // Guardar información en la sesión
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        
        // Redirigir según el rol
        if ($role == 'cliente') {
            header("Location: cliente_dashboard.php");
        } elseif ($role == 'administrador') {
            header("Location: admin_dashboard.php");
        } elseif ($role == 'super_admin') {
            header("Location: super_admin_dashboard.php");
        } else {
            header("Location: Login.html");
        }
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$stmt->close();
$conn->close();
?>