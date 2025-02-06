<?php
include "../../../../login/config.php";
include "../../../../encryption.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $encryptedUserId = $_COOKIE['user_id'];
    $userId = decryptData($encryptedUserId);

    // تحقق من وجود الإعجاب بالفعل
    $checkSql = "SELECT * FROM likes WHERE idpost = '$postId' AND userid = '$userId'";
    $result = $conx->query($checkSql);

    if ($result->num_rows > 0) {
        // حذف الإعجاب إذا كان موجودًا
        $deleteSql = "DELETE FROM likes WHERE idpost = '$postId' AND userid = '$userId'";
        if ($conx->query($deleteSql) === TRUE) {
            echo "disliked"; // الإعجاب تم إزالته
        } else {
            echo "خطأ: " . $conx->error;
        }
    } else {
        // إضافة الإعجاب إذا لم يكن موجودًا
        $insertSql = "INSERT INTO likes (idpost, userid) VALUES ('$postId', '$userId')";
        if ($conx->query($insertSql) === TRUE) {
            echo "liked"; // الإعجاب تم إضافته
        } else {
            echo "خطأ: " . $conx->error;
        }
    }

    $conx->close();
}
?>
