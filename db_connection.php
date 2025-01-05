<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "door_inventory";

// إنشاء الاتصال
$conn = mysqli_connect($servername, $username, $password, $dbname);

// التحقق من الاتصال
if (!$conn) {
    die("الاتصال فشل: " . mysqli_connect_error());
}
?>
<head>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>