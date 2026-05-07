<?php
session_start();

/* 🔥 limpiar variables de sesión */
$_SESSION = [];

/* 🔥 destruir sesión completamente */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

/* 🔁 redirigir al login */
header("Location: login.php");
exit;
?>