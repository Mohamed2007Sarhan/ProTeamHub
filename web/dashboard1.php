<?php
session_start(); // بداية الجلسة

include('../login/config.php'); 
include('../encryption.php'); 

// التحقق من وجود الإيميل في الجلسة
if (isset($_SESSION['Email_Session'])) {
    $email = $_SESSION['Email_Session'];

    // استخدام Prepared Statements لحماية استعلام SQL
    $stmt = $conx->prepare("SELECT user_type, bio FROM register WHERE Email = ?");
    $stmt->bind_param("s", $email); // ربط البريد الإلكتروني
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_type = $row['user_type'];
        $bio = $row['bio'];

        // التحقق من الحقول
        if (empty($user_type)) {
            header("Location: ../login/welcome.php"); 
            exit();
        } elseif (empty($bio)) {
            $encrypted_email = encryptData($email);
            $encrypted_user_type = encryptData($user_type);

            // تخزين البيانات المشفرة في Cookies
            setcookie("user_email", $encrypted_email, time() + 3600, "/");
            setcookie("user_type", $encrypted_user_type, time() + 3600, "/");
            header("Location: ../login/complete-login/");
            exit();
        } else {
            // تشفير البيانات
            $encrypted_email = encryptData($email);
            $encrypted_user_type = encryptData($user_type);

            // تخزين البيانات المشفرة في Cookies
            setcookie("user_email", $encrypted_email, time() + 3600, "/");
            setcookie("user_type", $encrypted_user_type, time() + 3600, "/");
            header("Location: pages/img_user.php");
        }
    } else {
        header("Location: ../login/index.php");
        exit();
    }
} else {
    header("Location: ../login/index.php");
    exit();
}
?>



