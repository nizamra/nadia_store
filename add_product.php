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
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowed)) {
            $image = uniqid() . '.' . $ext;
            $dest = __DIR__ . '/images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $dest);
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $stmt->execute([$name, $price, $image]);

    header("Location: index.php");
    exit();
}

include 'header.php';
?>
<div class="container">
    <div class="form-box">
        <h2>إضافة منتج جديد</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="اسم المنتج" required>
            <input type="text" name="price" placeholder="السعر" required>
            <input type="file" name="image" accept="image/*" style="padding:10px; background:#444; color:#fff; border:1px solid #555; border-radius:8px; width:100%; margin-bottom:15px;">
            <button type="submit" name="add">إضافة المنتج</button>
        </form>
        <a href="index.php" class="link">← العودة للرئيسية</a>
    </div>
</div>
<?php include 'footer.php'; ?>
