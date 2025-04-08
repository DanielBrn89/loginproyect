<?php
require_once '../../includes/db.php';
require_once '../../includes/auth.php';

// Usar la librería phpqrcode (descargar de https://github.com/t0k4rt/phpqrcode)
require_once 'phpqrcode/qrlib.php';

$product_id = $_GET['id'];

// Verificar propiedad
$stmt = $db->prepare("SELECT id FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$product_id, $_SESSION['user_id']]);

if ($stmt->fetch()) {
    $qrData = "PROD-{$_SESSION['user_id']}-$product_id";
    $qrFile = "qr-images/product_$product_id.png";
    
    if (!file_exists('qr-images')) {
        mkdir('qr-images', 0755, true);
    }
    
    QRcode::png($qrData, $qrFile);
    
    // Actualizar DB
    $db->prepare("UPDATE products SET qr_code = ? WHERE id = ?")
       ->execute([$qrFile, $product_id]);
    
    header("Location: ../view_product.php?id=$product_id");
} else {
    header("Location: ../home.php?error=qr_unauthorized");
    exit();
}