<?php
session_start();
include 'header.php';
require_once 'db.php';
$conn = connectDB();

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container" style="text-align:center;">
    <h2 style="color:#d4af37;">مجموعة منتجات SKINLUXE</h2>
    <div class="product-grid">
        <?php foreach ($products as $row):
            $img = $row['image'] ? 'images/' . htmlspecialchars($row['image']) : '';
        ?>
            <div class="product-card">
                <?php if ($img): ?>
                    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:12px;" onerror="this.style.display='none'">
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p style="margin-bottom:15px;">السعر: <?php echo htmlspecialchars($row['price']); ?> ر.س</p>
                <a href="order_action.php?id=<?php echo $row['id']; ?>" class="order-btn">طلب المنتج</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
