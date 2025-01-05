<?php
include('db_connection.php');

// التحقق من وجود معرف الباب في الرابط
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // استعلام جلب البيانات الخاصة بالباب
    $query = "SELECT * FROM doors WHERE id = '$id' AND type = 'interior'";
    $result = mysqli_query($conn, $query);
    
    // التأكد من وجود نتيجة
    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "خطأ في جلب البيانات: " . mysqli_error($conn);
        exit();
    }
}

// التحقق من إرسال البيانات عبر POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استخراج البيانات من النموذج وتأكد من عدم وجود فراغات غير ضرورية
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $door_type = mysqli_real_escape_string($conn, $_POST['door_type']);
    $door_condition = mysqli_real_escape_string($conn, $_POST['door_condition']);

    // طباعة القيم المدخلة للتأكد من أنها تصل بشكل صحيح
    // uncomment the next line for debugging purposes
    // var_dump($model, $size, $quantity, $door_type, $door_condition); exit();

    // استعلام التحديث في قاعدة البيانات
    $update_query = "UPDATE doors SET model='$model', size='$size', quantity='$quantity', door_type='$door_type', door_condition='$door_condition' WHERE id='$id' AND type = 'interior'";

    if (mysqli_query($conn, $update_query)) {
        echo "تم تعديل الباب بنجاح!";
        header("Location: interior_doors.php");
        exit();
    } else {
        echo "خطأ في التحديث: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل باب داخلي</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
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

    <div>
        <h2>تعديل باب داخلي</h2>
        <form method="POST">
            <label for="model">الموديل:</label><br>
            <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($row['model'], ENT_QUOTES); ?>" required><br><br>

            <label for="size">القياس:</label><br>
            <input type="text" id="size" name="size" value="<?php echo htmlspecialchars($row['size'], ENT_QUOTES); ?>" required><br><br>

            <label for="quantity">العدد:</label><br>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($row['quantity'], ENT_QUOTES); ?>" required><br><br>

            <label for="door_type">نوع الباب:</label><br>
            <select id="door_type" name="door_type" required>
                <option value="PVC" <?php if ($row['door_type'] == 'PVC') echo 'selected'; ?>>PVC</option>
                <option value="MDF" <?php if ($row['door_type'] == 'MDF') echo 'selected'; ?>>MDF</option>
                
            </select><br><br>

            <label for="door_condition">حالة الباب:</label><br>
            <select id="door_condition" name="door_condition" required>
                <option value="جديد" <?php if ($row['door_condition'] == 'جديد') echo 'selected'; ?>>جديد</option>
                <option value="متضرر" <?php if ($row['door_condition'] == 'متضرر') echo 'selected'; ?>>متضرر</option>
                <option value="شريط" <?php if ($row['door_condition'] == 'شريط') echo 'selected'; ?>>شريط</option>
            </select><br><br>

            <input type="submit" value="تحديث الباب">
        </form>
    </div>

</body>
</html>
