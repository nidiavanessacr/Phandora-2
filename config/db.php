<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "phandora";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>