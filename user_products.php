<?php
session_start();
include 'header.php';
require_once 'db.php';
$conn = connectDB();

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="padding: 20px; color: white; text-align: center;">
    <h2>مجموعة منتجات SKINLUXE</h2>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px;">
        <?php foreach ($products as $row): ?>
            <div style="border: 1px solid #d4af37; padding: 20px; border-radius: 10px; width: 200px; background: #333;">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p>السعر: <?php echo htmlspecialchars($row['price']); ?> ر.س</p>
                <a href="order_action.php?id=<?php echo $row['id']; ?>" style="background: #d4af37; color: #000; padding: 10px; text-decoration: none; border-radius: 5px; display: block;">طلب المنتج</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>