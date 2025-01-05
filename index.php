<?php
echo "<h1 class='welcome-title'>مرحباً بك في نظام إدارة الأبواب</h1>";
echo "<div class='logo-container'>
        <span class='logo'>
            المخزن
        </span>
      </div>";
echo "<p class='link'><a href='interior_doors.php'>الأبواب الداخلية</a></p>";
echo "<p class='link'><a href='exterior_doors.php'>الأبواب الخارجية</a></p>";
?>

<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #8e44ad;
        --button-hover-color: #2980b9;
        --button-text-color: #fff;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--button-text-color);
        text-align: center;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
        overflow: hidden;
    }

    h1.welcome-title {
        font-size: 3rem;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        margin-top: 50px;
        margin-bottom: 20px;
        opacity: 0;
        animation: fadeIn 2s forwards;
    }

    .logo-container {
        margin-top: 40px;
        display: inline-block;
    }

    .logo {
        font-size: 5rem;
        font-weight: bold;
        color: var(--button-text-color);
        display: inline-block;
        letter-spacing: 0.1em;
        direction: rtl;
        animation: waveMove 2s ease-in-out infinite;
    }

    .link {
        font-size: 1.5rem;
        margin: 20px;
    }

    .link a {
        color: var(--button-text-color);
        text-decoration: none;
        padding: 10px 20px;
        background-color: var(--primary-color);
        border-radius: 25px;
        border: 2px solid var(--primary-color);
        transition: background-color 0.3s ease, transform 0.3s ease, border 0.3s ease;
    }

    .link a:hover {
        background-color: var(--button-hover-color);
        transform: scale(1.1);
        border-color: var(--button-hover-color);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes waveMove {
        0% {
            transform: translateY(0);
            opacity: 0.5;
        }
        50% {
            transform: translateY(-15px);
            opacity: 1;
        }
        100% {
            transform: translateY(0);
            opacity: 0.5;
        }
    }

    @media screen and (max-width: 768px) {
        h1.welcome-title {
            font-size: 2rem;
        }

        .logo {
            font-size: 3rem;
        }

        .link a {
            font-size: 1.2rem;
            padding: 8px 15px;
        }
    }

    @media screen and (max-width: 480px) {
        body {
            text-align: left;
        }

        h1.welcome-title {
            font-size: 1.5rem;
        }

        .logo {
            font-size: 2.5rem;
        }

        .link a {
            font-size: 1rem;
            padding: 7px 12px;
            display: block;
            margin: 10px auto;
        }
    }
</style>

<script>
    // إضافة التحكم الصوتي
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'ar-SA'; // اللغة العربية السعودية
    recognition.continuous = false; // التأكد من أن التعرف يتوقف بعد النتيجة
    recognition.start();

    // الصوت المساعد
    const voiceHelper = new SpeechSynthesisUtterance();

    // بدء التسجيل الصوتي
    recognition.onstart = function() {
        voiceHelper.text = "أهلاً بك! يمكنك قول 'الأبواب الداخلية' للانتقال إلى الأبواب الداخلية أو 'الأبواب الخارجية' للانتقال إلى الأبواب الخارجية أو 'الصفحة الرئيسية' للرجوع للصفحة الرئيسية.";
        window.speechSynthesis.speak(voiceHelper);
    };

    // تنفيذ الأوامر الصوتية
    recognition.onresult = function(event) {
        const command = event.results[0][0].transcript.toLowerCase();
        console.log('أنت قلت: ', command);

        if (command.includes('الأبواب الداخلية') || command.includes('الأبواب الداخليّة')) {
            voiceHelper.text = "الانتقال إلى الأبواب الداخلية الآن.";
            window.speechSynthesis.speak(voiceHelper);
            setTimeout(() => {
                window.location.href = 'interior_doors.php'; // الانتقال إلى الأبواب الداخلية
            }, 2000); // الانتقال بعد تأكيد الصوت
        } else if (command.includes('الأبواب الخارجية') || command.includes('الأبواب الخارجيّة')) {
            voiceHelper.text = "الانتقال إلى الأبواب الخارجية الآن.";
            window.speechSynthesis.speak(voiceHelper);
            setTimeout(() => {
                window.location.href = 'exterior_doors.php'; // الانتقال إلى الأبواب الخارجية
            }, 2000); // الانتقال بعد تأكيد الصوت
        } else if (command.includes('الصفحة الرئيسية') || command.includes('الرجوع للصفحة الرئيسية')) {
            voiceHelper.text = "الرجوع إلى الصفحة الرئيسية الآن.";
            window.speechSynthesis.speak(voiceHelper);
            setTimeout(() => {
                window.location.href = 'index.php'; // العودة إلى الصفحة الرئيسية
            }, 2000); // العودة بعد تأكيد الصوت
        } else if (command.includes('فتح قائمة الخيارات') || command.includes('فتح الخيارات')) {
            voiceHelper.text = "فتح قائمة الخيارات الآن.";
            window.speechSynthesis.speak(voiceHelper);
            setTimeout(() => {
                alert("تم فتح قائمة الخيارات!");
            }, 2000); // فتح القائمة بعد تأكيد الصوت
        } else {
            voiceHelper.text = "لم أتمكن من فهم الأمر. حاول مجددًا.";
            window.speechSynthesis.speak(voiceHelper);
        }
    };

    recognition.onerror = function(event) {
        console.log('خطأ في التعرف على الصوت: ', event.error);
        voiceHelper.text = "حدث خطأ في التعرف على الصوت. حاول مجددًا.";
        window.speechSynthesis.speak(voiceHelper);
    };

    // إضافة تفاعل مع الحركة باستخدام جهاز المستشعر
    window.addEventListener('deviceorientation', function(event) {
        const tiltX = event.beta; // زاوية الميل على المحور X
        const tiltY = event.gamma; // زاوية الميل على المحور Y
        document.body.style.transform = `rotateX(${tiltX}deg) rotateY(${tiltY}deg)`;
    });
</script>
