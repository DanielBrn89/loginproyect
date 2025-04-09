<?php
require 'db.php';
require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO products (name, description, quantity, price, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['description'],
        $_POST['quantity'],
        $_POST['price'],
        $_POST['user_id']
    ]);

    $productId = $pdo->lastInsertId();

    // Generar código de barras con el ID
    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($productId, $generator::TYPE_CODE_128);

    // Guardar imagen en archivo
    $barcodePath = "barcodes/$productId.png";
    file_put_contents($barcodePath, $barcode);

    // Guardar la ruta en la BD
    $pdo->prepare("UPDATE products SET qr_code = ? WHERE id = ?")->execute([$barcodePath, $productId]);

    echo "Producto guardado. <br>";
    echo "<img src='$barcodePath'><br>";
    echo "<a href='add_product.php'>Agregar otro</a>";
}
