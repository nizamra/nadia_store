<?php
session_start();
include 'header.php';
require_once 'db.php';
$conn = connectDB();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? ORDER BY created_at DESC");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container" style="text-align:center;">
    <form method="GET" class="search-form">
        <input type="text" name="search" class="search-input" placeholder="🔍 ابحث عن منتج..." value="<?php echo htmlspecialchars($search); ?>">
        <?php if ($search !== ''): ?>
            <a href="products.php" class="search-clear">إلغاء</a>
        <?php endif; ?>
    </form>

    <h2 style="color:#d4af37;">مجموعة منتجات SKINLUXE</h2>

    <?php if (count($products) > 0): ?>
        <div class="product-grid">
            <?php foreach ($products as $row):
                $img = $row['image'] ? 'images/' . htmlspecialchars($row['image']) : '';
            ?>
                <div class="product-card">
                    <?php if ($img): ?>
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:12px;" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p style="margin-bottom:8px;">السعر: <?php echo htmlspecialchars($row['price']); ?> ر.س</p>
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>" style="color:#d4af37; text-decoration:none; font-size:0.85rem; display:block; margin-bottom:10px;">عرض التفاصيل</a>
                    <a href="order_action.php?id=<?php echo $row['id']; ?>" class="order-btn">طلب المنتج</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="padding:60px 0; color:#666;">
            <?php if ($search !== ''): ?>
                لا توجد نتائج لـ "<?php echo htmlspecialchars($search); ?>"
            <?php else: ?>
                لا توجد منتجات حالياً
            <?php endif; ?>
        </p>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
