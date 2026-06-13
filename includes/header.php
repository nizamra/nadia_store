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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <script src="<?php echo BASE_URL; ?>/public/js/search.js" defer></script>
</head>
<body>
<header>
    <div class="logo">SKINLUXE</div>
    <div class="nav-links">
        <a href="<?php echo BASE_URL; ?>/index.php">الرئيسية</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="<?php echo BASE_URL; ?>/pages/products.php">المنتجات</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="<?php echo BASE_URL; ?>/admin/index.php">لوحة الأدمن</a>
            <?php endif; ?>
            <a href="<?php echo BASE_URL; ?>/auth/logout.php">تسجيل خروج</a>
            <span class="username">مرحباً، <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></span>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/auth/login.php">دخول</a>
            <a href="<?php echo BASE_URL; ?>/auth/register.php">تسجيل</a>
        <?php endif; ?>
    </div>
</header>
