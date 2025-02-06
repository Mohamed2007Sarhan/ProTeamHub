<?php
// URL الصفحة التي تريد الوصول إليها
$url = "http://localhost/website/proteamhub/web/pages/img_user.php?id=6";

// ملف تعريف الارتباط لتسجيل الدخول (في حال كان مطلوباً)
$cookieFile = "cookie.txt";

// تهيئة cURL
$ch = curl_init();

// إعداد خيارات cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // إرسال ملف تعريف الارتباط
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);  // تخزين ملفات تعريف الارتباط

// إرسال الطلب
$response = curl_exec($ch);

// التحقق من الأخطاء
if (curl_errno($ch)) {
    echo "خطأ: " . curl_error($ch);
} else {
    // عرض النص الناتج
    echo $response;
}

// إغلاق جلسة cURL
curl_close($ch);
?>