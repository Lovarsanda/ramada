<?php
include('db_connection.php');

// التحقق من وجود الـ id في الرابط والتأكد من أنه غير فارغ
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // استعلام للحصول على بيانات الباب المحدد
    $query = "SELECT * FROM doors WHERE id = ? AND type = 'exterior'"; // تحديد نوع الباب كـ 'exterior'
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // ربط المعامل مع الاستعلام (i تعني أنه عدد صحيح)
    $stmt->execute();
    $result = $stmt->get_result();
    
    // التحقق من وجود النتائج
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // نفي وجود الباب
        echo "<div class='error-message'>لم يتم العثور على الباب المطلوب. معرّف الباب: $id</div>";
        exit();
    }
} else {
    // نفي وجود الـ id في الرابط
    echo "<div class='error-message'>معرف الباب غير موجود في الرابط.</div>";
    exit();
}

// التحقق إذا كان الطلب هو POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جمع البيانات من النموذج
    $model = $_POST['model'];
    $size = $_POST['size'];
    $direction = $_POST['direction'];
    $serial_number = $_POST['serial_number'];
    $status = $_POST['status'];
    $hall_number = $_POST['hall_number'];

    // استعلام التحديث باستخدام prepared statements
    $update_query = "UPDATE doors 
                     SET model = ?, 
                         size = ?, 
                         direction = ?, 
                         serial_number = ?, 
                         status = ?, 
                         hall_number = ? 
                     WHERE id = ? AND type = 'exterior'";

    $stmt = $conn->prepare($update_query);

    // ربط المعاملات
    $stmt->bind_param("ssssssi", $model, $size, $direction, $serial_number, $status, $hall_number, $id);


    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo "<div class='success-message'>تم تعديل الباب بنجاح!</div>";
        header("Location: exterior_doors.php");
        exit();
    } else {
        echo "<div class='error-message'>خطأ أثناء التعديل: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل باب خارجي</title>
    <style>
        /* تنسيق عام */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3498db, #8e44ad);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        label {
            font-size: 1rem;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 2px solid #bdc3c7;
            font-size: 1rem;
            background-color: #f4f6f7;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #3498db;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.5);
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            font-size: 1.2rem;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>تعديل باب خارجي</h2>

        <form method="POST">
            <label for="model">الموديل:</label>
            <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($row['model'] ?? '', ENT_QUOTES); ?>" required>

            <label for="size">القياس:</label>
            <input type="text" id="size" name="size" value="<?php echo htmlspecialchars($row['size'] ?? '', ENT_QUOTES); ?>" required>

            <label for="direction">الاتجاه:</label>
            <select id="direction" name="direction" required>
                <option value="يمين" <?php echo ($row['direction'] == 'يمين') ? 'selected' : ''; ?>>يمين</option>
                <option value="يسار" <?php echo ($row['direction'] == 'يسار') ? 'selected' : ''; ?>>يسار</option>
            </select>

            <label for="serial_number">الفقرة:</label>
            <input type="text" id="serial_number" name="serial_number" value="<?php echo htmlspecialchars($row['serial_number'] ?? '', ENT_QUOTES); ?>" required>

            <label for="status">الحالة:</label>
            <select id="status" name="status" required>
                <option value="جديد" <?php echo ($row['status'] == 'جديد') ? 'selected' : ''; ?>>جديد</option>
                <option value="متضرر" <?php echo ($row['status'] == 'متضرر') ? 'selected' : ''; ?>>متضرر</option>
            </select>

            <label for="hall_number">رقم القاعة:</label>
            <input type="number" id="hall_number" name="hall_number" value="<?php echo htmlspecialchars($row['hall_number'] ?? '', ENT_QUOTES); ?>" required>

            <input type="submit" value="تحديث الباب">
        </form>
    </div>
</body>
</html>
