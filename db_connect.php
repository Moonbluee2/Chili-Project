<?php
// db_connect.php

$servername = "localhost";
$username_db = "root";
$password_db = "GOmita02";
$dbname = "C_KK";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "Conexión exitosa";

// Cerrar conexión
$conn->close();
?>