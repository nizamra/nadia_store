<?php
// هذا الكود سيحول 00000 إلى شفرة احترافية
$password = "00000";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "انسخي هذه الشفرة: " . $hash;
?>