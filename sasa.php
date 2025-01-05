<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نموذج طلبية</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            padding: 20px;
            background-color: #f9f9f9;
            margin: 0;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .submit-btn {
            background-color: #25D366;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 6px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #128C7E;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .divider {
            border-top: 2px dashed #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<h2>نموذج طلبية</h2>

<form id="orderForm">
    <div class="form-group">
        <label for="orderNumber">رقم الطلبية</label>
        <input type="text" id="orderNumber" name="orderNumber" required>
    </div>
    
    <div class="form-group">
        <label for="branch">الفرع</label>
        <input type="text" id="branch" name="branch" required>
    </div>
    
    <div class="form-group">
        <label for="saleType">نوع البيع</label>
        <select id="saleType" name="saleType" required>
            <option value="بيع وتجهيز">بيع وتجهيز</option>
            <option value="بيع وحجز">بيع وحجز</option>
        </select>
    </div>
    
    <!-- حقل تحديد نوع الباب -->
    <div class="form-group">
        <label for="doorType">نوع الباب</label>
        <select id="doorType" name="doorType" onchange="toggleDoorFields()" required>
            <option value="خارجي">خارجي</option>
            <option value="داخلي">داخلي</option>
            <option value="خارجي وداخلي">خارجي وداخلي</option>
        </select>
    </div>
    
    <!-- عدد الأبواب الخارجية -->
    <div class="form-group">
        <label for="externalDoorsCount">عدد الأبواب الخارجية</label>
        <input type="number" id="externalDoorsCount" name="externalDoorsCount" min="0" oninput="generateExternalFields()" placeholder="أدخل عدد الأبواب الخارجية">
    </div>
    
    <!-- عدد الأبواب الداخلية -->
    <div class="form-group">
        <label for="internalDoorsCount">عدد الأبواب الداخلية</label>
        <input type="number" id="internalDoorsCount" name="internalDoorsCount" min="0" oninput="showInternalFieldsQuestion()" placeholder="أدخل عدد الأبواب الداخلية">
    </div>
    
    <!-- سؤال عن وجود موديلات متعددة للأبواب الداخلية -->
    <div class="form-group" id="internalModelsQuestion" style="display: none;">
        <label for="multipleInternalModels">هل الأبواب الداخلية متعددة الموديلات؟</label>
        <select id="multipleInternalModels" name="multipleInternalModels" onchange="generateInternalFields()" required>
            <option value="نعم">نعم</option>
            <option value="لا">لا</option>
        </select>
    </div>
    
    <!-- حقل فقرة الأبواب الخارجية -->
    <div id="externalDoorsContainer"></div>
    
    <!-- حقل فقرة الأبواب الداخلية -->
    <div id="internalDoorsContainer"></div>
    
    <!-- حقل الملاحظات -->
    <div class="form-group">
        <label for="remarks">الملاحظات</label>
        <textarea id="remarks" name="remarks"></textarea>
    </div>

    <!-- حقل العملة -->
    <div class="form-group">
        <label for="currency">العملة</label>
        <select id="currency" name="currency" required>
            <option value="دولار">دولار</option>
            <option value="دينار عراقي">دينار عراقي</option>
        </select>
    </div>

    <!-- حقل مبلغ الشد -->
    <div class="form-group">
        <label for="payment">مبلغ الشد</label>
        <input type="number" id="payment" name="payment" placeholder="مبلغ الشد إن وجد">
    </div>

    <!-- حقل النقل -->
    <div class="form-group">
        <label for="delivery">النقل</label>
        <select id="delivery" name="delivery" required>
            <option value="نقل واصل">نقل واصل</option>
            <option value="نقل غير واصل">نقل غير واصل</option>
        </select>
    </div>

    <!-- حقل الزبون -->
    <div class="form-group">
        <label for="customerName">اسم الزبون</label>
        <input type="text" id="customerName" name="customerName" required>
    </div>
    <div class="form-group">
        <label for="customerPhone">رقم الزبون</label>
        <input type="text" id="customerPhone" name="customerPhone" required>
    </div>
    <div class="form-group">
        <label for="customerAddress">عنوان الزبون</label>
        <input type="text" id="customerAddress" name="customerAddress" required>
    </div>

    <button type="button" class="submit-btn" onclick="generateMessage()">إرسال</button>
</form>

<script>
    function toggleDoorFields() {
        // إظهار/إخفاء الحقول بناءً على نوع الباب
        const doorType = document.getElementById('doorType').value;
        if (doorType === "خارجي" || doorType === "خارجي وداخلي") {
            document.getElementById('externalDoorsCount').style.display = "block";
        } else {
            document.getElementById('externalDoorsCount').style.display = "none";
        }
        if (doorType === "داخلي" || doorType === "خارجي وداخلي") {
            document.getElementById('internalDoorsCount').style.display = "block";
        } else {
            document.getElementById('internalDoorsCount').style.display = "none";
        }
    }

    function showInternalFieldsQuestion() {
        const internalDoorsCount = document.getElementById('internalDoorsCount').value;
        const questionContainer = document.getElementById('internalModelsQuestion');
        if (internalDoorsCount > 0) {
            questionContainer.style.display = "block";
        } else {
            questionContainer.style.display = "none";
        }
    }

    function generateExternalFields() {
        const count = document.getElementById('externalDoorsCount').value;
        const container = document.getElementById('externalDoorsContainer');
        container.innerHTML = ''; // إفراغ الحاوية من الحقول السابقة

        for (let i = 1; i <= count; i++) {
            container.innerHTML += `
                <div class="section-title">باب خارجي رقم ${i}</div>
                <div class="form-group">
                    <label for="externalModel${i}">الموديل</label>
                    <input type="text" id="externalModel${i}" name="externalModel${i}" placeholder="مثل S7006 بنل">
                </div>
                <div class="form-group">
                    <label for="externalDimensions${i}">القياس (العرض × الارتفاع × السماكة)</label>
                    <input type="text" id="externalDimensions${i}" name="externalDimensions${i}" placeholder="مثل 120*265*24">
                </div>
                <div class="form-group">
                    <label for="externalDirection${i}">اتجاه الباب</label>
                    <select id="externalDirection${i}" name="externalDirection${i}">
                        <option value="يمين">يمين</option>
                        <option value="يسار">يسار</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="externalRoom${i}">القاعه</label>
                    <input type="text" id="externalRoom${i}" name="externalRoom${i}" placeholder="مثل BSH1141">
                </div>
                <div class="divider"></div>
            `;
        }
    }

    function generateInternalFields() {
        const multipleModels = document.getElementById('multipleInternalModels').value;
        const count = document.getElementById('internalDoorsCount').value;
        const container = document.getElementById('internalDoorsContainer');
        container.innerHTML = ''; // إفراغ الحاوية من الحقول السابقة

        if (multipleModels === "نعم") {
            for (let i = 1; i <= count; i++) {
                container.innerHTML += `
                    <div class="section-title">باب داخلي رقم ${i}</div>
                    <div class="form-group">
                        <label for="internalModel${i}">الموديل</label>
                        <input type="text" id="internalModel${i}" name="internalModel${i}" placeholder="مثل 116 رصاصي غامق">
                    </div>
                    <div class="form-group">
                        <label for="internalDimensions${i}">القياس (العرض × الارتفاع)</label>
                        <input type="text" id="internalDimensions${i}" name="internalDimensions${i}" placeholder="مثل 100*210">
                    </div>
                    <div class="divider"></div>
                `;
            }
        } else {
            container.innerHTML += `
                <div class="section-title">باب داخلي موحد</div>
                <div class="form-group">
                    <label for="internalModel">الموديل</label>
                    <input type="text" id="internalModel" name="internalModel" placeholder="مثل 116 رصاصي غامق">
                </div>
                <div class="form-group">
                    <label for="internalDimensions">القياس (العرض × الارتفاع)</label>
                    <input type="text" id="internalDimensions" name="internalDimensions" placeholder="مثل 100*210">
                </div>
                <div class="divider"></div>
            `;
        }
    }

    function generateMessage() {
        let message = '';
        
        // الحصول على البيانات من النموذج
        const orderNumber = document.getElementById('orderNumber').value;
        const branch = document.getElementById('branch').value;
        const saleType = document.getElementById('saleType').value;
        const customerName = document.getElementById('customerName').value;
        const customerPhone = document.getElementById('customerPhone').value;
        const customerAddress = document.getElementById('customerAddress').value;
        const currency = document.getElementById('currency').value;
        const payment = document.getElementById('payment').value;
        const delivery = document.getElementById('delivery').value;
        const remarks = document.getElementById('remarks').value;

        // إضافة التفاصيل العامة
        message += `طلبية رقم: ${orderNumber} ${branch}\n`;
        message += `${saleType}\n`;

        // إضافة الأبواب الخارجية
        const externalDoorsCount = document.getElementById('externalDoorsCount').value;
        if (externalDoorsCount > 0) {
            message += `أبواب خارجية (عدد ${externalDoorsCount}):\n`;
            for (let i = 1; i <= externalDoorsCount; i++) {
                const model = document.getElementById(`externalModel${i}`).value;
                const dimensions = document.getElementById(`externalDimensions${i}`).value;
                const direction = document.getElementById(`externalDirection${i}`).value;
                const room = document.getElementById(`externalRoom${i}`).value;
                message += `- موديل: ${model}, قياس: ${dimensions}, اتجاه: ${direction}, قاعة: ${room}\n`;
            }
        }

        // إضافة الأبواب الداخلية
        const internalDoorsCount = document.getElementById('internalDoorsCount').value;
        if (internalDoorsCount > 0) {
            message += `أبواب داخلية (عدد ${internalDoorsCount}):\n`;
            const multipleModels = document.getElementById('multipleInternalModels').value;
            if (multipleModels === "نعم") {
                for (let i = 1; i <= internalDoorsCount; i++) {
                    const model = document.getElementById(`internalModel${i}`).value;
                    const dimensions = document.getElementById(`internalDimensions${i}`).value;
                    message += `- موديل: ${model}, قياس: ${dimensions}\n`;
                }
            } else {
                const model = document.getElementById('internalModel').value;
                const dimensions = document.getElementById('internalDimensions').value;
                message += `- موديل: ${model}, قياس: ${dimensions}\n`;
            }
        }

        // إضافة الملاحظات
        if (remarks) {
            message += `الملاحظات: ${remarks}\n`;
        }

        // إضافة التفاصيل المالية
        message += `العملة: ${currency}, مبلغ الشد: ${payment}, النقل: ${delivery}\n`;
        message += `اسم الزبون: ${customerName}, رقم الزبون: ${customerPhone}, عنوان الزبون: ${customerAddress}\n`;

        // عرض الرسالة
        alert(message);
    }
</script>

</body>
</html>
