<?php
session_start(); // ضروري للتحقق من حالة الدخول
require_once 'db.php';
$conn = connectDB();
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>SKINLUXE - مجموعة العناية</title>
    <style>
        body { background-color: #2a2a2a; color: #fff; font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .logo { font-size: 2.5rem; color: #d4af37; text-align: center; margin-bottom: 10px; font-weight: bold; }
        
        /* تنسيق أزرار التنقل */
        .nav-links { text-align: center; margin-bottom: 20px; }
        .nav-links a { color: #d4af37; margin: 0 10px; text-decoration: none; font-size: 1.1rem; }
        .nav-links a:hover { color: #fff; }

        .add-btn { display: block; width: 220px; margin: 20px auto; padding: 12px; background: #d4af37; color: #000; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .card { background: #333; padding: 20px; border-radius: 10px; border: 1px solid #444; text-align: center; }
        .card h3 { color: #d4af37; margin-bottom: 10px; }
        .btn-edit { color: #5dade2; text-decoration: none; margin-left: 15px; font-weight: bold; }
        .btn-delete { background: transparent; border: 1px solid #e74c3c; color: #e74c3c; cursor: pointer; padding: 5px 10px; border-radius: 3px; }
    </style>
</head>
<body>

    <header>
        <div class="logo">SKINLUXE</div>
        
        <div class="nav-links">
            <a href="index.php">الرئيسية</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php">تسجيل خروج</a>
            <?php else: ?>
                <a href="login.php">تسجيل دخول</a>
                <a href="register.php">تسجيل حساب</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <a href="created_at.php" class="add-btn">+ إضافة منتج جديد</a>

        <div class="grid">
        <?php
        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo '
            <div class="card">
                <h3>' . htmlspecialchars($row['name']) . '</h3>
                <p>السعر: ' . htmlspecialchars($row['price']) . '</p>
                
                <a href="edit.php?id=' . $row['id'] . '" class="btn-edit">تعديل</a>
                
                <form action="delete.php" method="POST" style="display:inline; margin-right:10px;">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button type="submit" class="btn-delete" onclick="return confirm(\'هل أنت متأكد من الحذف؟\')">حذف</button>
                </form>
            </div>';
        }
        ?>
        </div>
    </div>
</body>
</html>