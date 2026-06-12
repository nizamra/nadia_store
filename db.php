<?php
$host = "localhost";
$dbname = "nadia_progect";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("خطأ في الاتصال: " . $e->getMessage());
}

function connectDB() {
    global $conn;
    return $conn;
}
?>