<?php
// تضمين ملف الكونفيج
include('../config.php');
session_start();

if(isset($_SESSION['Email_Session'])) {
    $email = $_SESSION['Email_Session'];

    // عمل استعلام للتحقق من user_tybe
    $sql = "SELECT user_type FROM register WHERE Email = '$email'";
    $result = mysqli_query($conx, $sql);

    // لو في نتيجة من الاستعلام
    if (mysqli_num_rows($result) > 0) {
        // جلب القيمة
        $row = mysqli_fetch_assoc($result);
        $user_type = $row['user_type'];

        // إذا كانت user_tybe موجودة، نبعت المستخدم لصفحة معينة
        if ($user_type == 'member'){
            header("Location: member.php");
        } elseif($user_type == 'company'){
            header("Location: company.php");
        }elseif($user_type == 'organizer'){
            header("Location: organizer.php");
        }elseif($user_type == 'expert'){
            header("Location: expert.php");
        }
    } else {
        header("Location: ../index.php");
        exit();
    }

} else {
    // لو الإيميل مش موجود في الجلسة، نرجع لصفحة تسجيل الدخول
    header("Location: ../index.php"); // رجوع لصفحة تسجيل الدخول
    exit();
}

// إغلاق الاتصال
$conx->close();
?>
