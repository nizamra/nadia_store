<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
echo "<div style='text-align:center; padding:50px; color:white;'>
        <h1>تم استلام طلبك بنجاح!</h1>
        <p>شكراً لاختيارك SKINLUXE</p>
        <a href='user_products.php'>العودة للمنتجات</a>
      </div>";
?>