<?php
$password = "00000";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "انسخي هذه الشفرة: " . $hash;
?>