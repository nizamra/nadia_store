<?php
session_start();
require_once 'db.php';
$conn = connectDB();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    $stmt->execute([$name, $price]);

    header("Location: index.php");
    exit();
}

include 'header.php';
?>
<div class="container">
    <div class="form-box">
        <h2>إضافة منتج جديد</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="اسم المنتج" required>
            <input type="text" name="price" placeholder="السعر" required>
            <button type="submit" name="add">إضافة المنتج</button>
        </form>
        <a href="index.php" class="link">← العودة للرئيسية</a>
    </div>
</div>
<?php include 'footer.php'; ?>
