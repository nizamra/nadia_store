<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$conn = connectDB();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_POST['id'];

$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product && $product['image']) {
    $imagePath = __DIR__ . '/../public/images/' . $product['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->execute([$id]);

header("Location: ../index.php");
?>