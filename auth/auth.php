<?php
session_start();

// Si no hay sesión → login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
?>