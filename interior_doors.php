<?php
include('db_connection.php');

// التحقق من وجود كلمة البحث في الـ GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';  // تأكد من إزالة الفراغات غير الضرورية

// استعلام آمن باستخدام Prepared Statements لعرض الأبواب الداخلية مع البحث إذا كان موجودًا
$query = "SELECT * FROM doors WHERE type = 'interior' AND 
    (model LIKE ? OR size LIKE ? OR quantity LIKE ? OR door_type LIKE ? OR door_condition LIKE ?)";
$stmt = $conn->prepare($query);

// تمرير الكلمة المدخلة إلى الاستعلام
$searchParam = "%" . $search . "%";  // نضيف النسبة المئوية للبحث جزئيًا
$stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

// التحقق من وجود نتائج
if ($result->num_rows > 0) {
    // هناك نتائج لعرضها
} else {
    echo "<p>لا توجد نتائج للبحث!</p>";
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأبواب الداخلية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        // وظيفة الطباعة
        function printTable() {
            var content = document.getElementById('doorsTable').outerHTML;
            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>طباعة الأبواب الداخلية</title>');
            printWindow.document.write('<style>table { width: 100%; border-collapse: collapse; } table, th, td { border: 1px solid black; } th, td { padding: 8px; text-align: center; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<style>@media print { .no-print { display: none; } }</style>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        // دالة لتأكيد الحذف
        function confirmDelete(id) {
            var result = confirm("هل أنت متأكد من أنك تريد حذف هذا الباب؟");
            if (result) {
                window.location.href = 'delete_interior_door.php?id=' + id;
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
            direction: rtl;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            justify-content: flex-start;
        }

        .back-btn-container {
            display: flex;
            justify-content: flex-start;
            width: 100%;
            padding: 10px 20px;
        }

        .back-btn {
            padding: 12px 20px;
            background-color: #e74c3c;
            color: white;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .back-btn:hover {
            background-color: #c0392b;
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 10px 20px;
            background-color: #3498db;
            margin-top: 20px;
        }

        .search-container form {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .search-container input[type="text"] {
            padding: 12px 20px;
            font-size: 16px;
            width: 250px;
            border-radius: 25px;
            border: 2px solid #bdc3c7;
            background-color: rgba(189, 195, 199, 0.1);
            transition: all 0.3s ease;
        }

        .search-container input[type="submit"] {
            padding: 12px 25px;
            background-color: #f39c12;
            color: white;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-left: 10px;
        }

        .search-container input[type="submit"]:hover {
            background-color: #e67e22;
            transform: scale(1.05);
        }

        .action-buttons {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 10px;
        }

        .print-btn, .add-door-btn {
            padding: 12px 20px;
            background-color: #f39c12;
            color: white;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-left: 10px;
        }

        .print-btn:hover, .add-door-btn:hover {
            background-color: #e67e22;
            transform: scale(1.05);
        }

        .print-btn i, .add-door-btn i {
            margin-left: 10px;
        }

        table {
            width: 80%;
            margin-top: 30px;
            border-collapse: collapse;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 15px;
            border: 1px solid rgba(200, 200, 200, 0.5);
            font-size: 16px;
        }

        table th {
            background-color: #3498db;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: rgba(240, 240, 240, 0.7);
        }

        table tr:hover {
            background-color: rgba(231, 76, 60, 0.3);
            color: white;
            cursor: pointer;
        }

        @media print {
            table th:nth-child(6),
            table th:nth-child(7),
            table td:nth-child(6),
            table td:nth-child(7) {
                display: none;
            }
        }

        @media screen and (max-width: 768px) {
            table {
                width: 95%;
                margin-top: 20px;
            }

            .search-container input[type="text"] {
                width: 200px;
            }

            .back-btn {
                padding: 10px 15px;
                font-size: 14px;
            }

            .print-btn, .add-door-btn {
                font-size: 14px;
                padding: 10px 15px;
            }
        }

        @media screen and (max-width: 480px) {
            table {
                width: 100%;
            }

            .search-container input[type="text"] {
                width: 180px;
            }

            .back-btn {
                font-size: 12px;
                padding: 8px 12px;
            }

            .print-btn, .add-door-btn {
                font-size: 12px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>

    <!-- زر الرجوع في أعلى الصفحة -->
    <div class="back-btn-container">
        <a href="index.php">
            <button class="back-btn">رجوع</button>
        </a>
    </div>

    <!-- نموذج البحث وأزرار الطباعة -->
    <div class="search-container">
        <form method="GET">
            <input type="text" name="search" placeholder="ابحث حسب الموديل أو القياس أو العدد أو نوع الباب أو حالة الباب" value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>">
            <input type="submit" value="بحث">
        </form>
    </div>

    <!-- أزرار إضافة وطباعة -->
    <div class="action-buttons">
        <button class="print-btn" onclick="printTable()">
            <span>طباعة الجدول</span>
            <i class="fas fa-print"></i>
        </button>

        <button class="add-door-btn" onclick="window.location.href='add_interior_door.php'">
            <span>إضافة باب داخلي</span>
        </button>
    </div>

    <!-- عرض الأبواب الداخلية في جدول -->
    <table id="doorsTable">
        <thead>
            <tr>
                <th>الموديل</th>
                <th>القياس</th>
                <th>العدد</th>
                <th>نوع الباب</th>  <!-- تم استبدال الاسم بنوع الباب -->
                <th>حالة الباب</th>
                <th class="no-print">التعديل</th>
                <th class="no-print">الحذف</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['model'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['size'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantity'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['door_type'], ENT_QUOTES) . "</td>";  // عرض نوع الباب
                echo "<td>" . htmlspecialchars($row['door_condition'], ENT_QUOTES) . "</td>";
                echo "<td class='no-print'><a href='update_interior_door.php?id=" . $row['id'] . "'>تعديل</a></td>";
                // إضافة وظيفة الحذف مع تأكيد
                echo "<td class='no-print'><a href='javascript:void(0);' onclick='confirmDelete(" . $row['id'] . ")'>حذف</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
