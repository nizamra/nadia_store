<?php
session_start();
// التأكد من أن المستخدم مسجل دخول قبل الطلب
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// هنا يمكنكِ وضع كود إضافة الطلب لقاعدة البيانات مستقبلاً
// حالياً سنعرض رسالة تأكيد فقط
echo "<div style='text-align:center; padding:50px; color:white;'>
        <h1>تم استلام طلبك بنجاح!</h1>
        <p>شكراً لاختيارك SKINLUXE</p>
        <a href='user_products.php'>العودة للمنتجات</a>
      </div>";
?>