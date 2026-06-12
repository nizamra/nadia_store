<?php
// تأكدي أن هذه أول سطر في الملف تماماً
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// إظهار الأخطاء في حال وجود مشكلة
ini_set('display_errors', 1);
error_reporting(E_ALL);

// الاتصال بقاعدة البيانات
require_once 'db.php';
$conn = connectDB();
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>SKINLUXE - الصفحة الرئيسية</title>
    <style>
        body { background-color: #2a2a2a; color: #fff; }
        header { text-align: center; margin-bottom: 30px; }
        .nav-bar { margin-top: 15px; }
        .nav-bar a { color: #fff; margin: 0 10px; text-decoration: none; }
        .nav-bar a:hover { color: #d4af37; }

        .add-btn { display: block; width: 220px; margin: 20px auto; text-align: center; background: #d4af37; color: #000; padding: 10px; text-decoration: none; border-radius: 5px; }
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; padding: 20px; }
        .card { background: #333; padding: 20px; border-radius: 10px; }
        .card h3 { color: #d4af37; }
        .btn-edit { color: #5dade2; text-decoration: none; }
        .btn-delete { background: none; border: 1px solid #e74c3c; color: #e74c3c; cursor: pointer; padding: 5px; }
    </style>
</head>
<body>

<header>
    <div class="logo">SKINLUXE</div>
    
    <div class="nav-bar">
        <a href="index.php">الرئيسية</a>

        <?php if(session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_id'])): ?>
            <a href="logout.php">تسجيل خروج</a>
            
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin.php">لوحة الأدمن</a>
            <?php endif; ?>
            
            <a href="user_products.php">المنتجات</a>
        <?php else: ?>
            <a href="login.php">دخول</a>
            <a href="register.php">تسجيل</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="created_at.php" class="add-btn">+ إضافة منتج جديد</a>
    <?php endif; ?>

    <div class="grid">
        <?php
        // جلب المنتجات
        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo '
            <div class="card">
                <h3>' . htmlspecialchars($row['name']) . '</h3>
                <p>السعر: ' . htmlspecialchars($row['price']) . '</p>
                <a href="edit.php?id=' . $row['id'] . '" class="btn-edit">تعديل</a>
                <form action="delete.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button type="submit" class="btn-delete">حذف</button>
                </form>
            </div>';
        }
        ?>
    </div>
</div>
</body>
</html>