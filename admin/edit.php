<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$conn = connectDB();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$row = ['id' => '', 'name' => '', 'price' => '', 'description' => '', 'ingredients' => '', 'results' => '', 'image' => ''];
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
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $results = $_POST['results'];
    $image = $row['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowed)) {
            $oldPath = __DIR__ . '/../public/images/' . $image;
            if ($image && file_exists($oldPath)) {
                unlink($oldPath);
            }
            $image = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../public/images/' . $image);
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, ingredients=?, results=?, image=? WHERE id=?");
    $stmt->execute([$name, $price, $description, $ingredients, $results, $image, $id]);

    header("Location: ../index.php");
    exit();
}

include __DIR__ . '/../includes/header.php';
?>
<div class="container">
    <div class="form-box">
        <h2>تعديل بيانات المنتج</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="اسم المنتج" required>
            <input type="text" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" placeholder="السعر" required>
            <textarea name="description" placeholder="الوصف" style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #555; border-radius:8px; background:#444; color:#fff; font-size:15px; text-align:right; resize:vertical;" rows="3"><?php echo htmlspecialchars($row['description'] ?? ''); ?></textarea>
            <textarea name="ingredients" placeholder="المكونات" style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #555; border-radius:8px; background:#444; color:#fff; font-size:15px; text-align:right; resize:vertical;" rows="3"><?php echo htmlspecialchars($row['ingredients'] ?? ''); ?></textarea>
            <textarea name="results" placeholder="النتائج المتوقعة" style="width:100%; padding:12px; margin-bottom:15px; border:1px solid #555; border-radius:8px; background:#444; color:#fff; font-size:15px; text-align:right; resize:vertical;" rows="3"><?php echo htmlspecialchars($row['results'] ?? ''); ?></textarea>

            <?php if ($row['image']): ?>
                <div style="margin-bottom:15px;">
                    <img src="../public/images/<?php echo htmlspecialchars($row['image']); ?>" style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                </div>
            <?php endif; ?>

            <input type="file" name="image" accept="image/*" style="padding:10px; background:#444; color:#fff; border:1px solid #555; border-radius:8px; width:100%; margin-bottom:15px;">

            <button type="submit" name="update">حفظ التعديلات</button>
        </form>
        <a href="../index.php" class="link">← العودة للرئيسية</a>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
