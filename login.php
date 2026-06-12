<?php
session_start();
require_once "db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        if ($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة!";
    }
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>SKINLUXE - دخول</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #2a2a2a;
            color: #fff;
            font-family: Tahoma, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .auth-box {
            background: #333;
            padding: 40px;
            border-radius: 15px;
            border: 1px solid #d4af37;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .auth-box h2 {
            color: #d4af37;
            margin-bottom: 25px;
            font-size: 28px;
        }
        .auth-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #555;
            border-radius: 8px;
            background: #444;
            color: #fff;
            font-size: 15px;
            text-align: right;
        }
        .auth-box input::placeholder { color: #999; }
        .auth-box button {
            width: 100%;
            padding: 12px;
            background: #d4af37;
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .auth-box button:hover { background: #c5a030; }
        .auth-box .error {
            color: #e74c3c;
            margin-bottom: 15px;
        }
        .auth-box .link {
            display: block;
            margin-top: 18px;
            color: #999;
            text-decoration: none;
        }
        .auth-box .link:hover { color: #d4af37; }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #d4af37;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="auth-box">
        <div class="logo">SKINLUXE</div>
        <h2>تسجيل الدخول</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول</button>
        </form>
        <a href="register.php" class="link">ليس لديك حساب؟ سجل الآن</a>
    </div>
</body>
</html>
