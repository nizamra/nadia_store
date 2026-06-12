<?php
session_start();
require_once "config/db.php"; // تأكدي من مسار ملف الاتصال

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    
    // 1. هنا نقوم بتشفير كلمة المرور قبل الحفظ
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // 2. نقوم بحفظ البيانات المشفرة في القاعدة
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'user')");
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password
    ]);

    // 3. إعادة توجيه لصفحة الدخول بعد التسجيل
    header("Location: login.php");
    exit();
}
?>