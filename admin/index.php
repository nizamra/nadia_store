<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$conn = connectDB();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$users = $conn->query("SELECT id, username, email, role, created_at FROM users")->fetchAll(PDO::FETCH_ASSOC);
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>
<div class="container">
    <div class="admin-links">
        <a href="add_product.php">+ إضافة منتج جديد</a>
        <a href="../index.php">العودة للمتجر</a>
        <a href="../auth/logout.php" style="color:#e74c3c;">تسجيل خروج</a>
    </div>

    <h2 style="color:#d4af37; text-align:center;">لوحة تحكم الأدمن</h2>

    <h3 style="margin-top:30px;">المستخدمون</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>المعرف</th>
                <th>اسم المستخدم</th>
                <th>البريد الإلكتروني</th>
                <th>الصلاحية</th>
                <th>تاريخ التسجيل</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <?php if ($row['id'] != $_SESSION['user_id']): ?>
                                <form action="role_action.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="<?php echo $row['role'] == 'admin' ? 'btn-delete' : 'btn-edit'; ?>" style="border:none; padding:5px 10px; border-radius:3px; cursor:pointer;">
                                        <?php echo $row['role'] == 'admin' ? 'إزالة صلاحية' : 'تعيين أدمن'; ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span style="color:#666; font-size:0.85rem;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">لا يوجد مستخدمون</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3 style="margin-top:40px;">المنتجات</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>المعرف</th>
                <th>الصورة</th>
                <th>اسم المنتج</th>
                <th>السعر</th>
                <th>تاريخ الإضافة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['id']); ?></td>
                        <td>
                            <?php if ($p['image']): ?>
                                <img src="../public/images/<?php echo htmlspecialchars($p['image']); ?>" style="width:50px; height:50px; object-fit:cover; border-radius:5px;">
                            <?php else: ?>
                                <span style="color:#666;">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                        <td><?php echo htmlspecialchars($p['price']); ?> ر.س</td>
                        <td><?php echo htmlspecialchars($p['created_at']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $p['id']; ?>" class="btn-edit">تعديل</a>
                            <form action="delete.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف <?php echo htmlspecialchars($p['name']); ?>؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">لا يوجد منتجات</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
