<?php
session_start();

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];
    
    // Conexión a la base de datos
    $servername = "localhost";
    $username_db = "tu_usuario";
    $password_db = "tu_contraseña";
    $dbname = "tu_base_de_datos";
    
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    // Insertar en favoritos
    $stmt = $conn->prepare("INSERT INTO favorites (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $product_id);
    
    if ($stmt->execute()) {
        echo "Añadido a favoritos. <a href='cliente_dashboard.php'>Volver</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: cliente_dashboard.php");
    exit();
}
?>
