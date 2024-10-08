<?php
// auth.php
session_start();

// Función para verificar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Función para verificar el rol del usuario
function checkRole($required_role) {
    if (!isLoggedIn()) {
        header("Location: Login.html");
        exit();
    }

    if ($_SESSION['role'] !== $required_role) {
        // Puedes redirigir a una página de error o al dashboard correspondiente
        header("Location: unauthorized.html");
        exit();
    }
}

// Función para verificar si el usuario tiene uno de los roles permitidos
function checkRoles($allowed_roles = []) {
    if (!isLoggedIn()) {
        header("Location: Login.html");
        exit();
    }

    if (!in_array($_SESSION['role'], $allowed_roles)) {
        header("Location: unauthorized.html");
        exit();
    }
}
?>
