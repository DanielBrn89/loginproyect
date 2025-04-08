<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Obtener productos del usuario
$stmt = $db->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mi Inventario</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container">
        <h1>Mi Inventario</h1>
        <a href="inventory/add_product.php" class="btn">+ Nuevo Producto</a>
        <a href="inventory/scan_qr.php" class="btn">Escanear QR</a>
        
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p>Stock: <?= $product['quantity'] ?></p>
                <?php if ($product['qr_code']): ?>
                <img src="<?= $product['qr_code'] ?>" alt="QR" class="qr-thumbnail">
                <?php endif; ?>
                <a href="inventory/view_product.php?id=<?= $product['id'] ?>" class="btn">Ver</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="assets/js/scripts/qr-scanner.js"></script>
</body>
</html>


