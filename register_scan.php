<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO qr_scans (product_id, user_id) VALUES (?, ?)");
    $stmt->execute([$_POST['product_id'], $_POST['user_id']]);

    echo "Escaneo registrado correctamente.";
}
