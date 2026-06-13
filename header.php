<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>SKINLUXE</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/search.js" defer></script>
</head>
<body>
<header>
    <div class="logo">SKINLUXE</div>
    <div class="nav-links">
        <a href="index.php">الرئيسية</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="products.php">المنتجات</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin.php">لوحة الأدمن</a>
            <?php endif; ?>
            <a href="logout.php">تسجيل خروج</a>
            <span class="username">مرحباً، <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></span>
        <?php else: ?>
            <a href="login.php">دخول</a>
            <a href="register.php">تسجيل</a>
        <?php endif; ?>
    </div>
</header>
