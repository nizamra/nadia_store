<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$conn = connectDB();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$targetId = $_POST['user_id'] ?? null;

if ($targetId && $targetId != $_SESSION['user_id']) {
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$targetId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $newRole = ($user['role'] === 'admin') ? 'user' : 'admin';
        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->execute([$newRole, $targetId]);
    }
}

header("Location: index.php");
exit();
