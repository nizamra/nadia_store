<link rel='stylesheet' href='style.css'>
<?php

require_once 'db.php';

$conn = connectDB();

$id = $_GET['id'];

$stmt = $conn->prepare(
    "DELETE FROM nadia WHERE id=?"
);

$stmt->execute([$id]);

header("Location: index.php");

?>