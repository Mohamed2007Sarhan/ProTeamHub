<?php
// config/news.php

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once __DIR__ . '/../../../login/config.php';
require_once __DIR__ . '/../../../encryption.php';

// Define constants for upload directory and allowed file types
define('UPLOAD_DIR', __DIR__ . '/../../../login/uploads/');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2 MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);

// Start session to manage user data if needed
session_start();

// Decrypt and retrieve username and user ID
$encryptedUsername = $_COOKIE['user_name'] ?? '';
$username = decryptData($encryptedUsername);

$encryptedUserId = $_COOKIE['user_id'] ?? '';
$userId = decryptData($encryptedUserId);

// Check if username or userId is empty (invalid session or cookie data)
if (empty($username) || empty($userId)) {
    die('Session expired or invalid user.');
}

// Validate POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

// Sanitize and validate post content
$postContent = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (empty($postContent)) {
    die('Post content cannot be empty.');
}

// Handle file upload if provided
$uploadedFilePath = null;
if (!empty($_FILES['postImage']['name'])) {
    $file = $_FILES['postImage'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('File upload error.');
    }

    // Validate file type
    $fileType = mime_content_type($file['tmp_name']);
    if (!in_array($fileType, ALLOWED_TYPES)) {
        die('Invalid file type. Only JPEG, PNG, and GIF are allowed.');
    }

    // Validate file size
    if ($file['size'] > MAX_FILE_SIZE) {
        die('File size exceeds the limit of 2 MB.');
    }

    // Generate unique file name to prevent overwriting
    $fileName = uniqid('img_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

    // Ensure upload directory exists
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    // Ensure the file is safe and does not contain executable code
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        die('Invalid file extension.');
    }

    // Move uploaded file to target directory
    $targetFilePath = UPLOAD_DIR . $fileName;
    if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        die('Failed to save uploaded file.');
    }

    $uploadedFilePath = '../../login/uploads/' . $fileName;
} 

// Securely save post to database
try {
    $stmt = $conx->prepare('INSERT INTO news (username, new, img, img_user, user_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $username, $postContent, $uploadedFilePath, htmlspecialchars($_SESSION['user_image'] ?? 'img/default.png'), $userId);
    
    $stmt->execute();

    header("Location: ../news.php?news=good");
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    header("Location: ../news.php?news=bad");
}
?>
