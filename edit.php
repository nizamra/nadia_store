<?php
session_start();
require_once 'db.php';
$conn = connectDB();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$row = ['id' => '', 'name' => '', 'price' => ''];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    $stmt = $conn->prepare("UPDATE products SET name=?, price=? WHERE id=?");
    $stmt->execute([$name, $price, $id]);
    
    header("Location: index.php");
    exit();
}

include 'header.php';
?>
<div class="container">
    <div class="form-box">
        <h2>تعديل بيانات المنتج</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="اسم المنتج" required>
            <input type="text" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" placeholder="السعر" required>
            <button type="submit" name="update">حفظ التعديلات</button>
        </form>
        <a href="index.php" class="link">← العودة للرئيسية</a>
    </div>
</div>
<?php include 'footer.php'; ?>
