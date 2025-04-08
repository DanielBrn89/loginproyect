<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$qrCode = $data['qr_code'];

// Extraer el ID del producto del código QR (asumiendo formato "PROD:123")
if (strpos($qrCode, 'PROD:') === 0) {
    $productId = substr($qrCode, 5);
    
    // Verificar que el producto existe y pertenece al usuario
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
    $stmt->execute([$productId, $_SESSION['user_id']]);
    $product = $stmt->fetch();
    
    if ($product) {
        // Registrar el escaneo
        $stmt = $pdo->prepare("INSERT INTO qr_scans (product_id, user_id) VALUES (?, ?)");
        $stmt->execute([$productId, $_SESSION['user_id']]);
        
        echo json_encode([
            'success' => true,
            'product_id' => $productId
        ]);
        exit();
    }
}

echo json_encode([
    'success' => false,
    'message' => 'Producto no encontrado en tu inventario'
]);
?>