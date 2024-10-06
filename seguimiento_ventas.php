<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: login.html");
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

// Obtener todas las ventas
$sql = "SELECT sales.id, users.username, products.name, sales.quantity, sales.total_price, sales.sale_date 
        FROM sales 
        JOIN users ON sales.user_id = users.id 
        JOIN products ON sales.product_id = products.id 
        ORDER BY sales.sale_date DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguimiento de Ventas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Seguimiento de Ventas</h1>
        <nav>
            <a href="admin_dashboard.php">Volver al Dashboard</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Total</th>
                    <th>Fecha de Venta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>\${$row['total_price']}</td>
                                <td>{$row['sale_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay ventas registradas.</td></tr>";
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