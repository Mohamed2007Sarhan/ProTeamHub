<?php
// تأكد من أنك قد أنشأت قاعدة البيانات وجداولها كما ذكرنا سابقًا
require_once 'config.php';

// التحقق مما إذا كانت كلمة المرور قد تم إرسالها في الطلب
if (isset($_POST['password']) && $_POST['password'] === 'Mohamed_proteamhub') {
    // كلمة المرور الأصلية للمستخدم
    $password = 'Mohamed';

    // توليد كلمة مرور مشفرة باستخدام password_hash
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // إعداد الاتصال بقاعدة البيانات
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // فحص الاتصال بقاعدة البيانات
    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // إضافة المستخدم إلى قاعدة البيانات
    $username = 'Mohamed2007';  // اسم المستخدم للتجربة
    $query = "INSERT INTO admins (username, password) VALUES (?, ?)";

    // إعداد الاستعلام
    $stmt = $conn->prepare($query);

    // فحص ما إذا كان التحضير قد تم بنجاح
    if ($stmt === false) {
        die("خطأ في إعداد الاستعلام: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $hashed_password);

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo "تم إضافة المستخدم بنجاح.";
    } else {
        echo "فشل إضافة المستخدم: " . $stmt->error;
    }

    // إغلاق الاتصال
    $stmt->close();
    $conn->close();
} else {
    echo "كلمة المرور غير صحيحة.";
}
?>
