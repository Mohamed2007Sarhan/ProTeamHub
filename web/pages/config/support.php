<?php
include('../../../login/config.php'); // الاتصال بقاعدة البيانات
include('../../../encryption.php'); // أي تشفير مطلوب

// استلام البيانات من النموذج
$username = $_POST['usernme'];
$email = $_POST['useremail'];
$message = $_POST['massage'];

// استلام الـ User ID من الكوكيز
$user_id_no = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : 'Unknown';
$user_id = decryptData($user_id_no);

// الحصول على الـ IP الخاص بالمستخدم
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$user_ip = getUserIP();

// الاتصال بقاعدة البيانات وإدخال البيانات
try {
    $username_db = "root";
    $password_db = "";
    $dbname = "proteamhub";
    $host = "localhost";
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO feedback (username, email, message, user_id, ip_address) 
                            VALUES (:username, :email, :message, :user_id, :ip_address)");
    
    // ربط القيم بالمعاملات
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':ip_address', $user_ip);

    // تنفيذ الاستعلام
    $stmt->execute();

    header("Location: ../support.php?support=good");
} catch (PDOException $e) {
    echo "فشل إدخال البيانات: " . $e->getMessage();
}

?>