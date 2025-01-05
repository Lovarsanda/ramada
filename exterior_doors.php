<?php
include('db_connection.php');

// التحقق من وجود كلمة البحث في الـ GET
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$hall_number = isset($_GET['hall_number']) ? $_GET['hall_number'] : '';

// استعلام آمن باستخدام Prepared Statements لعرض الأبواب الخارجية مع البحث حسب الموديل أو القياس أو الاتجاه أو الرقم التسلسلي أو الفئة أو الحالة أو رقم القاعة
$query = "SELECT * FROM doors WHERE type = 'exterior' 
          AND (model LIKE ? OR size LIKE ? OR direction LIKE ? OR serial_number LIKE ? OR category LIKE ? 
          OR status LIKE ? OR hall_number LIKE ?)";

$stmt = $conn->prepare($query);

// إعداد متغيرات البحث
$searchParam = "%" . $search . "%";
$categoryParam = "%" . $category . "%";
$statusParam = "%" . $status . "%";
$hallNumberParam = "%" . $hall_number . "%";

// الربط بين المتغيرات والاستعلام
$stmt->bind_param("sssssss", $searchParam, $searchParam, $searchParam, $searchParam, $categoryParam, $statusParam, $hallNumberParam);

// تنفيذ الاستعلام
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأبواب الخارجية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* تنسيق الصفحة */
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

        h2 {
            margin-top: 30px;
            color: #333;
            font-size: 24px;
            text-align: center;
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
            margin-top: 50px;
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

        .action-buttons {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 10px;
        }

        .action-buttons .print-btn, .action-buttons .add-door-btn {
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

        .action-buttons .print-btn:hover, .action-buttons .add-door-btn:hover {
            background-color: #e67e22;
            transform: scale(1.05);
        }

        .action-buttons .print-btn i, .action-buttons .add-door-btn i {
            margin-left: 10px;
        }

        @media print {
            table th:nth-child(5),
            table th:nth-child(6),
            table td:nth-child(5),
            table td:nth-child(6) {
                display: none;
            }
        }
    </style>

    <script>
        function printTable() {
            var content = document.getElementById('doorsTable').outerHTML;
            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>طباعة الأبواب الخارجية</title>');
            printWindow.document.write('<style>table { width: 100%; border-collapse: collapse; } table, th, td { border: 1px solid black; } th, td { padding: 8px; text-align: center; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<style>@media print { .no-print { display: none; } }</style>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</head>
<body>

    <div class="back-btn-container">
        <a href="index.php">
            <button class="back-btn">رجوع</button>
        </a>
    </div>

    <div class="search-container">
        <form method="GET">
            <input type="text" name="search" placeholder="ابحث حسب الموديل أو القياس أو الاتجاه أو الرقم التسلسلي" value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>">

            <input type="submit" value="بحث">
        </form>
    </div>

    <div class="action-buttons">
        <button class="print-btn" onclick="printTable()">
            <span>طباعة الجدول</span>
            <i class="fas fa-print"></i>
        </button>
        <button class="add-door-btn" onclick="window.location.href='add_exterior_door.php'">
            <span>إضافة باب خارجي</span>
        </button>
    </div>

    <table id="doorsTable">
        <thead>
            <tr>
                <th>الموديل</th>
                <th>القياس</th>
                <th>الاتجاه</th>
                <th>الفقرة</th>
                <th>الحالة</th>
                <th>رقم القاعة</th>
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
                echo "<td>" . htmlspecialchars($row['direction'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['serial_number'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['status'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['hall_number'], ENT_QUOTES) . "</td>";
                echo "<td class='no-print'><a href='update_exterior_door.php?id=" . $row['id'] . "'>تعديل</a></td>";
                echo "<td class='no-print'><a href='delete_exterior_door.php?id=" . $row['id'] . "'>حذف</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
