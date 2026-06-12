<?php
require_once 'db.php';
$conn = connectDB();

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
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل المنتج</title>
</head>
<body>
    <h2>تعديل بيانات المنتج</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        
        <label>اسم المنتج:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>"><br>
        
        <label>السعر:</label><br>
        <input type="text" name="price" value="<?php echo htmlspecialchars($row['price']); ?>"><br><br>
        
        <button type="submit" name="update">حفظ التعديلات</button>
    </form>
</body>
</html>