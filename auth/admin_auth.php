<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION["usuario_rol"] !== "admin") {
    header("Location: ../main.php");
    exit;
}
?>