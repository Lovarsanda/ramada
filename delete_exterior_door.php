<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM doors WHERE id = '$id' AND type = 'exterior'";
    if (mysqli_query($conn, $query)) {
        echo "تم حذف الباب بنجاح!";
        header("Location: exterior_doors.php");
    } else {
        echo "خطأ: " . mysqli_error($conn);
    }
}
?>
