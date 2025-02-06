<?php
// Include encryption header
include('header.php');

// Check if the decryption function exists (assuming you have an external shell or encryption method)
if (!function_exists('decryptData')) {
    die("Decryption function not found.");
}

// Check cookies before decryption
if (isset($_COOKIE['user_email'], $_COOKIE['user_name'], $_COOKIE['user_id'])) {
    $encryptedUserId = $_COOKIE['user_id'];
    $userId = decryptData($encryptedUserId);
    // $userId = $_GET["id"];

    // Validate decryption result
    if (!$userId) {
        die("Invalid session. Please login again.");
    }
} else {
    header("Refresh:0");
    exit();
}

/**
 * Mask email for privacy
 *
 * @param string $email
 * @return string
 */
function maskEmail($email)
{
    $parts = explode('@', $email);
    $username = substr($parts[0], 0, 3) . '...';
    return $username . '@' . $parts[1];
}

// Include the database configuration
include('../../login/config.php');

// Verify database connection
if ($conx->connect_error) {
    die("Database connection failed: " . $conx->connect_error);
}

// Fetch user data
$sql = "SELECT * FROM register WHERE ID = ?";
$stmt = $conx->prepare($sql);

if (!$stmt) {
    die("Statement preparation failed: " . $conx->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $userImageUrl_user = !empty($user_data['profile_picture']) ? $user_data['profile_picture'] : 'img/default.png';
    $user_type = $user_data['user_type'];

    // Check if the image is the default and fetch the user's specific image if necessary
    if ($userImageUrl_user === 'img/default.png') {
        $userImageUrl_user = getUserImage($conx, $userId, $user_type);

        // Update the database with the new image URL
        $updateSql = "UPDATE register SET profile_picture = ? WHERE ID = ?";
        $updateStmt = $conx->prepare($updateSql);
        if ($updateStmt) {
            $updateStmt->bind_param("si", $userImageUrl_user, $userId);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            die("Failed to prepare update statement: " . $conx->error);
        }
    }

    // Mask the email for privacy
    $maskedEmail = maskEmail($user_data['email']);
} else {
    exit("User not found.");
}

$stmt->close();
$conx->close();

/**
 * Get the user image URL based on their user type
 *
 * @param mysqli $conx
 * @param int $userId
 * @param string $userType
 * @return string
 */
function getUserImage($conx, $userId, $userType)
{
    $defaultImage = 'img/default.png';
    $imagePath = '../../login/uploads/';

    // Define the tables for each user type
    $tables = [
        'organizer' => 'team_founders',
        'expert' => 'experts',
        'company' => 'companies',
        'member' => 'members'
    ];

    // Check if user type is valid
    if (!isset($tables[$userType])) {
        return $defaultImage; // Return default image if user type is invalid
    }

    // Query the respective table for the user's image
    $sql = "SELECT img FROM {$tables[$userType]} WHERE user_id = ?";
    $stmt = $conx->prepare($sql);
    if (!$stmt) {
        return $defaultImage; // Return default image if statement preparation fails
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return !empty($data['img']) ? $imagePath . $data['img'] : $defaultImage;
    }

    return $defaultImage; // Return default image if no image is found
}

header("Location: index.php");
?>

