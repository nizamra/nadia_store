<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
$conn = connectDB();

$product = null;
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

include __DIR__ . '/../includes/header.php';
?>
<div class="container" style="max-width:700px;">
    <?php if ($product): ?>
        <div class="detail-box">
            <?php if ($product['image']): ?>
                <img src="../public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="detail-img" onerror="this.style.display='none'">
            <?php endif; ?>

            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="detail-price"><?php echo htmlspecialchars($product['price']); ?> ر.س</p>

            <?php if ($product['description']): ?>
                <div class="detail-section">
                    <h3>الوصف</h3>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($product['ingredients']): ?>
                <div class="detail-section">
                    <h3>المكونات</h3>
                    <p><?php echo nl2br(htmlspecialchars($product['ingredients'])); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($product['results']): ?>
                <div class="detail-section">
                    <h3>النتائج المتوقعة</h3>
                    <p><?php echo nl2br(htmlspecialchars($product['results'])); ?></p>
                </div>
            <?php endif; ?>

            <div style="text-align:center; margin-top:30px;">
                <a href="../index.php" class="order-btn" style="display:inline-block; padding:12px 30px;">← العودة للمنتجات</a>
            </div>
        </div>
    <?php else: ?>
        <div style="text-align:center; padding:80px 0;">
            <h2 style="color:#d4af37;">المنتج غير موجود</h2>
            <a href="../index.php" style="color:#d4af37;">← العودة للرئيسية</a>
        </div>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
