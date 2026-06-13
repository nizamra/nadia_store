<?php
session_start();
require_once __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';
$conn = connectDB();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 9;
$offset = ($page - 1) * $perPage;

if ($search !== '') {
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE name LIKE ?");
    $countStmt->execute(['%' . $search . '%']);
    $total = $countStmt->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    $stmt->execute(['%' . $search . '%']);
} else {
    $total = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    $stmt->execute();
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = ceil($total / $perPage);
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
                $img = $row['image'] ? '../public/images/' . htmlspecialchars($row['image']) : '';
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

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">← السابق</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="page-link <?php echo $i == $page ? 'page-active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">التالي →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
