<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = $_POST['model'];
    $size = $_POST['size'];
    $direction = $_POST['direction'];
    $serial_number = $_POST['serial_number'];
    $status = $_POST['status'];  // إضافة الحقل الجديد
    $hall_number = $_POST['hall_number'];  // إضافة الحقل الجديد

    // تحديث الاستعلام لإضافة الحقول الجديدة إلى قاعدة البيانات
    $query = "INSERT INTO doors (model, size, direction, serial_number, status, hall_number, type) 
              VALUES ('$model', '$size', '$direction', '$serial_number', '$status', '$hall_number', 'exterior')";

    if (mysqli_query($conn, $query)) {
        echo "<div class='success-message'>تم إضافة الباب بنجاح!</div>";
        header("Location: exterior_doors.php");
    } else {
        echo "<div class='error-message'>خطأ: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة باب خارجي جديد</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3498db, #8e44ad); /* خلفية جمالية */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-attachment: fixed;
            background-size: cover;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        form {
            background-color: rgba(255, 255, 255, 0.9); /* خلفية نموذج شفافة */
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

        .success-message, .error-message {
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            font-size: 1rem;
            border-radius: 5px;
            display: none;
        }

        .success-message {
            background-color: #2ecc71;
            color: #fff;
        }

        .error-message {
            background-color: #e74c3c;
            color: #fff;
        }

        /* تحسين الاستجابة (responsive) للأجهزة الصغيرة */
        @media (max-width: 768px) {
            form {
                width: 90%; /* تكييف العرض ليكون مناسبًا للشاشات الصغيرة */
            }
        }

    </style>
</head>
<body>

    <div>
        <h2>إضافة باب خارجي جديد</h2>
        <form method="POST">
            <label for="model">الموديل:</label>
            <input type="text" id="model" name="model" required>

            <label for="size">القياس:</label>
            <input type="text" id="size" name="size" required>

            <label for="direction">الاتجاه:</label>
            <select id="direction" name="direction" required>
                <option value="يمين">يمين</option>
                <option value="يسار">يسار</option>
            </select>

            <label for="serial_number">الفقرة:</label>
            <input type="text" id="serial_number" name="serial_number" required>

            <!-- إضافة الحقول الجديدة -->
            <label for="status">الحالة:</label>
            <select id="status" name="status" required>
                <option value="جديد">جديد</option>
                <option value="متضرر">متضرر</option>
            </select>

            <label for="hall_number">رقم القاعة:</label>
            <select id="hall_number" name="hall_number" required>
                <?php for ($i = 1; $i <= 11; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>

            <input type="submit" value="إضافة الباب">
        </form>
    </div>

    <div class="success-message" id="successMessage">
        تم إضافة الباب بنجاح!
    </div>
    <div class="error-message" id="errorMessage">
        حدث خطأ أثناء إضافة الباب.
    </div>

</body>
</html>
