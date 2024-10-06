<?php
// agregar_producto.php
require 'auth.php';

// Verificar que el usuario sea un administrador
checkRole('administrador');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    
    // Manejar la subida de la imagen
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image_path = "";
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
    } else {
        echo "Error al subir la imagen.";
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
    
    // Insertar el producto
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image_path);
    
    if ($stmt->execute()) {
        echo "Producto agregado exitosamente. <a href='admin_dashboard.php'>Volver</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: admin_dashboard.php");
    exit();
}
?>