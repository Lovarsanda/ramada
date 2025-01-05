<?php
include('db_connection.php');

// استعلام للحصول على الأبواب الخارجية
$query = "SELECT * FROM doors WHERE type = 'exterior'";
$result = mysqli_query($conn, $query);

// تحديد اسم الملف
$filename = "exterior_doors_" . date('Y-m-d') . ".csv";

// فتح الملف للتصدير
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// فتح ملف CSV للكتابة
$output = fopen('php://output', 'w');

// كتابة عناوين الأعمدة
fputcsv($output, array('ID', 'الموديل', 'القياس', 'الاتجاه', 'الرقم التسلسلي'));

// كتابة البيانات
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// إغلاق الملف
fclose($output);
exit();
?>
