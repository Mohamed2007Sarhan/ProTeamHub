<?php
// بدء جلسة
session_start();

// مسح كل الكوكيز
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode('; ', $_SERVER['HTTP_COOKIE']);
    foreach ($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        // ضبط الكوكيز مع تاريخ انتهاء في الماضي
        setcookie($name, '', time() - 3600, '/');
        // التأكد من مسح الكوكيز في جميع الدومينات الفرعية
        setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
    }
}

// تدمير الجلسة
session_destroy();

// إعادة التوجيه إلى صفحة تسجيل الدخول أو الصفحة الرئيسية
header("Location: index.php");
exit();
?>
