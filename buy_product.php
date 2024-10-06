<?php
session_start();

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
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
    
    // Obtener precio del producto
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();
    
    $total_price = $price * $quantity;
    
    // Insertar en ventas
    $stmt = $conn->prepare("INSERT INTO sales (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $user_id, $product_id, $quantity, $total_price);
    
    if ($stmt->execute()) {
        echo "Compra realizada exitosamente. <a href='cliente_dashboard.php'>Volver</a>";
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