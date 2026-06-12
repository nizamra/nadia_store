<?php
require_once 'db.php';
$conn = connectDB();

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    $stmt->execute([$name, $price]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<body>
    <h2>إضافة منتج جديد</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="اسم المنتج" required>
        <input type="text" name="price" placeholder="السعر" required>
        <button type="submit" name="add">إضافة المنتج</button>
    </form>
</body>
</html>