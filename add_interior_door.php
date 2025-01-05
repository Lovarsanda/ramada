<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = $_POST['model'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $door_type = $_POST['door_type'];  // نوع الباب
    $door_condition = $_POST['door_condition'];  // حالة الباب

    // التحقق إذا كان الموديل والقياس موجودين في قاعدة البيانات
    $check_query = "SELECT * FROM doors WHERE model = ? AND size = ? AND type = 'interior'";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ss", $model, $size);  // الربط باستخدام prepared statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // إذا كان موجودًا، نقوم بتحديث العدد الحالي بإضافة العدد الجديد
        $row = mysqli_fetch_assoc($result);
        $new_quantity = $row['quantity'] + $quantity;

        // تحديث السجل في قاعدة البيانات
        $update_query = "UPDATE doors SET quantity = ?, door_type = ?, door_condition = ? WHERE model = ? AND size = ? AND type = 'interior'";
        $stmt_update = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt_update, "issss", $new_quantity, $door_type, $door_condition, $model, $size);  // الربط مع قيم جديدة
        if (mysqli_stmt_execute($stmt_update)) {
            echo "تم تحديث العدد بنجاح!";
            header("Location: interior_doors.php");
        } else {
            echo "خطأ في التحديث: " . mysqli_error($conn);
        }
    } else {
        // إذا لم يكن موجودًا، نقوم بإضافة المدخل الجديد
        $insert_query = "INSERT INTO doors (model, size, quantity, type, door_type, door_condition) VALUES (?, ?, ?, 'interior', ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt_insert, "ssiss", $model, $size, $quantity, $door_type, $door_condition);
        if (mysqli_stmt_execute($stmt_insert)) {
            echo "تم إضافة الباب بنجاح!";
            header("Location: interior_doors.php");
        } else {
            echo "خطأ: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة باب داخلي جديد</title>
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
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
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
        <h2>إضافة باب داخلي جديد</h2>
        <form method="POST">
            <label for="model">الموديل:</label>
            <input type="text" id="model" name="model" required>

            <label for="size">القياس:</label>
            <input type="text" id="size" name="size" required>

            <label for="quantity">العدد:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="door_type">نوع الباب:</label>
            <select id="door_type" name="door_type" required>
                <option value="PVC">PVC</option>
                <option value="MDF">MDF</option>
            </select>

            <label for="door_condition">حالة الباب:</label>
            <select id="door_condition" name="door_condition" required>
                <option value="جديد">جديد</option>
                <option value="متضرر">متضرر</option>
                <option value="شريط">شريط</option>
            </select>

            <input type="submit" value="إضافة الباب">
        </form>
    </div>

</body>
</html>
