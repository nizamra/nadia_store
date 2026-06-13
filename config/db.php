<?php
$host = "localhost";
$dbname = "nadia_project";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("خطأ في الاتصال: " . $e->getMessage());
}

$projectRoot = str_replace('\\', '/', dirname(__DIR__));
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
define('BASE_URL', str_replace($docRoot, '', $projectRoot));

function connectDB() {
    global $conn;
    return $conn;
}
?>