<?php
include('db_connection.php');

// استعلام للحصول على الأبواب الداخلية
$query = "SELECT * FROM doors WHERE type = 'interior'";
$result = mysqli_query($conn, $query);

// تحديد اسم الملف
$filename = "interior_doors_" . date('Y-m-d') . ".csv";

// فتح الملف للتصدير
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// فتح ملف CSV للكتابة
$output = fopen('php://output', 'w');

// كتابة عناوين الأعمدة
fputcsv($output, array('ID', 'الموديل', 'القياس', 'العدد'));

// كتابة البيانات
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// إغلاق الملف
fclose($output);
exit();
?>
