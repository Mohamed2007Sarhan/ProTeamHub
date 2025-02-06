<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $conx = new mysqli('localhost', 'root', '', 'proteamhub');

    $sqlUpdate = "UPDATE notviation SET active = 2 WHERE id = ?";
    $stmtUpdate = $conx->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $id);
    if ($stmtUpdate->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
}
