<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/db.php';
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
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = ceil($total / $perPage);

include 'includes/header.php';
?>
<div class="container">
    <form method="GET" class="search-form">
        <input type="text" name="search" class="search-input" placeholder="🔍 ابحث عن منتج..." value="<?php echo htmlspecialchars($search); ?>">
        <?php if ($search !== ''): ?>
            <a href="index.php" class="search-clear">إلغاء</a>
        <?php endif; ?>
    </form>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="admin/add_product.php" class="add-btn">+ إضافة منتج جديد</a>
    <?php endif; ?>

    <div class="grid">
        <?php if (count($results) > 0): ?>
            <?php foreach ($results as $row):
                $img = $row['image'] ? 'public/images/' . htmlspecialchars($row['image']) : '';
            ?>
                <div class="card">
                    <?php if ($img): ?>
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width:100%; height:180px; object-fit:cover; border-radius:8px; margin-bottom:12px;" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p>السعر: <?php echo htmlspecialchars($row['price']); ?> ر.س</p>
                    <a href="pages/product_detail.php?id=<?php echo $row['id']; ?>" style="color:#d4af37; text-decoration:none; font-size:0.9rem;">عرض التفاصيل</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <div style="margin-top:10px;">
                            <a href="admin/edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">تعديل</a>
                            <form action="admin/delete.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn-delete">حذف</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column:1/-1; text-align:center; padding:60px 0; color:#666;">
                <?php if ($search !== ''): ?>
                    لا توجد نتائج لـ "<?php echo htmlspecialchars($search); ?>"
                <?php else: ?>
                    لا توجد منتجات حالياً
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

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
<?php include 'includes/footer.php'; ?>
