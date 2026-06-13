<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';
$conn = connectDB();
include 'header.php';
?>
<div class="container">
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="add_product.php" class="add-btn">+ إضافة منتج جديد</a>
    <?php endif; ?>

    <div class="grid">
        <?php
        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $img = $row['image'] ? 'images/' . htmlspecialchars($row['image']) : '';
            echo '
            <div class="card">';
            if ($img) {
                echo '<img src="' . $img . '" alt="' . htmlspecialchars($row['name']) . '" style="width:100%; height:180px; object-fit:cover; border-radius:8px; margin-bottom:12px;" onerror="this.style.display=\'none\'">';
            }
            echo '
                <h3>' . htmlspecialchars($row['name']) . '</h3>
                <p>السعر: ' . htmlspecialchars($row['price']) . '</p>';
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                echo '
                <a href="edit.php?id=' . $row['id'] . '" class="btn-edit">تعديل</a>
                <form action="delete.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button type="submit" class="btn-delete">حذف</button>
                </form>';
            }
            echo '
            </div>';
        }
        ?>
    </div>
</div>
<?php include 'footer.php'; ?>
