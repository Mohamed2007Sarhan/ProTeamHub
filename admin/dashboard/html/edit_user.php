<?php
require_once '../../../login/config.php'; // ملف الاتصال بقاعدة البيانات
require_once '../../../encryption.php'; // ملف التشفير

// استقبال البيانات وتنقيتها
$userId = htmlspecialchars($_POST['id_user'] ?? '', ENT_QUOTES, 'UTF-8');
$username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$accountType = htmlspecialchars($_POST['accountType'] ?? '', ENT_QUOTES, 'UTF-8');
$isActive = htmlspecialchars($_POST['active'] ?? '', ENT_QUOTES, 'UTF-8');
$passwordPlain = $_POST['password'] ?? '';
$profilePicture = $_FILES['profile_picture'] ?? null; // الحصول على الصورة

// إعداد بيانات الصورة
$uploadDir = '../../../login/uploads/';
$profilePicturePath = null;

if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // إنشاء المجلد إذا لم يكن موجودًا
    }

    $fileTmpPath = $profilePicture['tmp_name'];
    $fileName = uniqid() . '_' . basename($profilePicture['name']); // اسم فريد للصورة
    $fileSize = $profilePicture['size'];
    $fileType = mime_content_type($fileTmpPath);
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($fileType, $allowedTypes) && $fileSize <= 2 * 1024 * 1024) { // 2 ميجابايت كحد أقصى
        $uploadFile = $uploadDir . $fileName;
        $uploadFile1 = '../../login/uploads/' . $fileName;

        if (move_uploaded_file($fileTmpPath, $uploadFile)) {
            $profilePicturePath = $uploadFile1;
        } else {
            exit("فشل في رفع الصورة.");
        }
    } else {
        exit("الملف المرفوع غير صالح. يرجى رفع صورة (JPEG/PNG/GIF) لا تتجاوز 2 ميجابايت.");
    }
}

// التحقق من البيانات الأساسية
if (empty($userId) || empty($username) || empty($email) || empty($passwordPlain) || empty($accountType)) {
    exit("يرجى تعبئة جميع الحقول المطلوبة.");
}

// التحقق من البريد الإلكتروني في قاعدة البيانات
try {
    $stmtCheck = $conx->prepare("SELECT ID FROM register WHERE email = ? AND ID != ?");
    if (!$stmtCheck) {
        throw new Exception("خطأ في تحضير الاستعلام: " . $conx->error);
    }
    $stmtCheck->bind_param("si", $email, $userId);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        exit("البريد الإلكتروني مستخدم بالفعل. يرجى اختيار بريد إلكتروني آخر.");
    }
    $stmtCheck->close();
} catch (Exception $e) {
    exit("خطأ أثناء التحقق من البريد الإلكتروني: " . $e->getMessage());
}

// تشفير كلمة المرور
$password = encryptData($passwordPlain);

try {
    // التحضير للاستعلام
    $stmt = $conx->prepare(
        "UPDATE register 
        SET Username = ?, email = ?, Password = ?, profile_picture = ?, user_type = ?, verification = ?, updated_at = NOW() 
        WHERE ID = ?"
    );
    echo $password;

    // تحقق من نجاح prepare
    if (!$stmt) {
        throw new Exception("خطأ في تحضير الاستعلام: " . $conx->error);
    }

    // قيمة افتراضية للتحقق
    $verification = $isActive === '1' ? 1 : 0;

    // ربط المتغيرات
    $stmt->bind_param("ssssssi", $username, $email, $password, $profilePicturePath, $accountType, $verification, $userId);

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo "تم تحديث البيانات بنجاح.";
    } else {
        throw new Exception("خطأ أثناء تنفيذ الاستعلام: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    echo "خطأ: " . $e->getMessage();
}

// غلق الاتصال بقاعدة البيانات
$conx->close();
?>
