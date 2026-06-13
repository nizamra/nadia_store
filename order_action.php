<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'header.php';
?>
<div class="container" style="text-align:center; padding:80px 0;">
    <h2 style="color:#d4af37; font-size:2rem;">تم استلام طلبك بنجاح!</h2>
    <p style="margin:20px 0; font-size:1.2rem;">شكراً لاختيارك SKINLUXE</p>
    <a href="products.php" style="color:#d4af37;">← العودة للمنتجات</a>
</div>
<?php include 'footer.php'; ?>
