<?php
$host = "localhost";
$dbname = "login_db";
$user = "root";
$pass = ""; // Cambia esto si tienes una contraseña

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>