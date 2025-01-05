<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM doors WHERE id = '$id' AND type = 'interior'";
    if (mysqli_query($conn, $query)) {
        echo "تم حذف الباب بنجاح!";
        header("Location: interior_doors.php");
    } else {
        echo "خطأ: " . mysqli_error($conn);
    }
}
?>
<head>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>