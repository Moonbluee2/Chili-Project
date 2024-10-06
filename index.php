<?php
// index.php

// Incluir el archivo de conexión a la base de datos
require 'db_connect.php';

// Consultar todos los vendedores
$sellers_sql = "SELECT id, username FROM users WHERE role = 'vendedor'";
$sellers_result = $conn->query($sellers_sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial - Mercado Mexicano</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido a Nuestro Mercado Mexicano</h1>
        <nav>
            <a href="Login.html">Iniciar Sesión</a>
            <a href="Register.html">Registrarse</a>
        </nav>
    </header>
    <main>
        <?php
        // Mostrar mensajes si existen
        if (isset($_GET['message'])) {
            echo "<div class='message'>" . htmlspecialchars($_GET['message']) . "</div>";
        }

        if ($sellers_result->num_rows > 0) {
            while($seller = $sellers_result->fetch_assoc()) {
                // Obtener los productos del vendedor
                $seller_id = $seller['id'];
                $products_sql = "SELECT id, name, description, price, image_path FROM products WHERE seller_id = $seller_id";
                $products_result = $conn->query($products_sql);
                
                if ($products_result->num_rows > 0) {
                    echo "<section class='seller-section'>";
                    echo "<h2>Stands de " . htmlspecialchars($seller['username']) . "</h2>";
                    echo "<div class='products-container'>";
                    
                    while($product = $products_result->fetch_assoc()) {
                        echo "<div class='product-card'>";
                        echo "<img src='" . htmlspecialchars($product['image_path']) . "' alt='" . htmlspecialchars($product['name']) . "'>";
                        echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
                        echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                        echo "<p class='price'>$" . number_format($product['price'], 2) . "</p>";
                        echo "<form action='add_favorite.php' method='post'>";
                        echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
                        echo "<button type='submit'>Añadir a Favoritos</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                    
                    echo "</div>";
                    echo "</section>";
                }
            }
        } else {
            echo "<p>No hay vendedores disponibles en este momento.</p>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mercado Mexicano. Todos los derechos reservados.</p>
    </footer>
</body>
</html>