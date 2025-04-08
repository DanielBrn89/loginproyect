<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    
    $stmt = $pdo->prepare("INSERT INTO products (name, description, quantity, price, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $quantity, $price, $_SESSION['user_id']]);
    
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar Nuevo Producto</h1>
    <form method="post">
        <label>Nombre: <input type="text" name="name" required></label><br>
        <label>Descripción: <textarea name="description"></textarea></label><br>
        <label>Cantidad: <input type="number" name="quantity" required></label><br>
        <label>Precio: <input type="number" step="0.01" name="price" required></label><br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>