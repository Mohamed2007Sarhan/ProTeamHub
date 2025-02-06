<?php
// تضمين ملف الإعدادات ودوال التشفير
include('../../login/config.php');
include('../../encryption.php');

// التحقق من وجود الكوكيز للبريد الإلكتروني
if (!isset($_COOKIE['user_email'])) {
    header("Location: ../../login/");
}

// فك تشفير البريد الإلكتروني الموجود في الكوكيز
$encryptedEmail = $_COOKIE['user_email'];
$userEmail = decryptData($encryptedEmail);

// التحقق من صحة البريد الإلكتروني
if (!$userEmail) {
    die("Failed to decrypt the email.");
}



// جلب بيانات المستخدم من قاعدة البيانات
$query = "SELECT ID, Username FROM register WHERE email = ?";
$stmt = mysqli_prepare($conx, $query);

if (!$stmt) {
    die("Failed to prepare the query: " . mysqli_error($conx));
}

// ربط المتغير وتنفيذ الاستعلام
mysqli_stmt_bind_param($stmt, 's', $userEmail);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// التحقق من وجود البيانات
if ($row = mysqli_fetch_assoc($result)) {
    // تشفير البيانات
    $encryptedID = encryptData($row['ID']);
    $encryptedUsername = encryptData($row['Username']);

    // تخزين البيانات في الكوكيز
    setcookie("user_id", $encryptedID, time() + (86400 * 30), "/"); // صلاحية الكوكيز لمدة 30 يومًا
    setcookie("user_name", $encryptedUsername, time() + (86400 * 30), "/");
} else {
    header("Location: ../../login/");
}

// إغلاق الاتصال
mysqli_stmt_close($stmt);
mysqli_close($conx);
