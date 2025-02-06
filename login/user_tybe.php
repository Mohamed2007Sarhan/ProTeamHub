<?php

session_start(); // بداية الجلسة

// تضمين ملف الاتصال بقاعدة البيانات
include('config.php');

// التأكد من وجود الإيميل في الجلسة
if (isset($_SESSION['Email_Session'])) {
    $email = $_SESSION['Email_Session'];

    $sql = "SELECT user_type FROM register WHERE Email = '$email'";
    $result = mysqli_query($conx, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_tybe = $row['user_tybe'];

        if (empty($user_tybe)) {
            if (isset($_GET['choose'])) {
                $choose = $_GET['choose'];

                $update_sql = "UPDATE register SET user_type = '$choose' WHERE Email = '$email'";
                if (mysqli_query($conx, $update_sql)) {
                    
                    header("Location: ../web/dashboard1.php"); 
                    exit();
                } else {
                    // في حالة فشل التحديث
                    echo "حدث خطأ أثناء تحديث نوع المستخدم!";
                }
            } else {
                // إذا كان متغير choose مش موجود، نوجهه لصفحة تانية
                header("Location: welcome.php"); // صفحة مختلفة لو user_tybe فاضية
                exit();
            }
        } else {

        }
    } else {
        // لو مفيش نتيجة من الاستعلام
        header("Location: index.php");
        exit();
    }

} else {
    header("Location: index.php"); 
    exit();
}
?>
