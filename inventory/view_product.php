<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

$product_id = $_GET['id'];

// Verificar que el producto pertenece al usuario
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$product_id, $_SESSION['user_id']]);
$product = $stmt->fetch();

if (!$product) {
    die("Producto no encontrado");
}

// Obtener historial de escaneos
$stmt = $pdo->prepare("SELECT * FROM qr_scans WHERE product_id = ? ORDER BY scanned_at DESC");
$stmt->execute([$product_id]);
$scans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['name']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p>Cantidad: <?= $product['quantity'] ?></p>
    <p>Precio: $<?= number_format($product['price'], 2) ?></p>
    
    <?php if ($product['qr_code']): ?>
    <img src="<?= $product['qr_code'] ?>" alt="QR Code" width="200">
    <?php else: ?>
    <a href="generate_qr.php?id=<?= $product['id'] ?>">Generar QR</a>
    <?php endif; ?>
    
    <h2>Historial de Escaneos</h2>
    <ul>
        <?php foreach ($scans as $scan): ?>
        <li>Escaneado el <?= $scan['scanned_at'] ?></li>
        <?php endforeach; ?>
    </ul>
    
    <a href="home.php">Volver al inventario</a>
</body>
</html>