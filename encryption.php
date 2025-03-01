<?php
define('ENCRYPTION_KEY', 'proteamhub2024'); // استبدل بـ مفتاح قوي

// دوال التشفير
function encryptData($data) {
    $iv = substr(hash('sha256', ENCRYPTION_KEY), 0, 16);
    return openssl_encrypt($data, 'AES-256-CBC', ENCRYPTION_KEY, 0, $iv);
}

function decryptData($data) {
    $iv = substr(hash('sha256', ENCRYPTION_KEY), 0, 16);
    return openssl_decrypt($data, 'AES-256-CBC', ENCRYPTION_KEY, 0, $iv);
}
