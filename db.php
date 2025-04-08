<?php
$host = "localhost";
$user = "root";
$password = ""; // Por defecto en XAMPP, el usuario root no tiene contraseña
$database = "login_db"; // Asegúrate que este nombre coincida con tu BD

$conn = new mysqli($host, $user, $password, $database);

// Verificamos la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
