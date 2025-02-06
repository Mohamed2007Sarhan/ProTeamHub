<?php
// Include the configuration file
require_once 'config.php';

// Start the session
session_start();

// Encryption and decryption keys
require_once '../../encryption.php';

// CSRF Token Validation (Generate if it doesn't exist)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a new CSRF token
}

// Handle POST request for login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF Token
    if ($csrf_token !== $_SESSION['csrf_token']) {
        echo "Invalid CSRF Token!";
        exit();
    }

    // Validate input fields
    if (empty($username) || empty($password)) {
        echo "Please enter both username and password.";
        exit();
    }

    // Create database connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Protect against SQL Injection
    $username = $conn->real_escape_string($username);

    // Prepare query to check if username exists
    $query = "SELECT id, username, password FROM admins WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $row['password'])) {
            // Regenerate session ID securely
            session_regenerate_id(true);

            // Store session data
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Encrypt the admin ID and store it in a cookie
            $encrypted_admin_id = encryptData($row['id']);
            setcookie('admin_id', $encrypted_admin_id, time() + 3600, '/', '', true, true);

            // Redirect to the admin dashboard
            header("Location: ../dashboard/");
            exit();
        } else {
            echo "Incorrect password.";
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt_time'] = time();
        }
    } else {
        echo "Username not found.";
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
    }

    $conn->close();
}

// Function to read the cookie and decrypt the admin ID
if (isset($_COOKIE['admin_id'])) {
    $decrypted_admin_id = decryptData($_COOKIE['admin_id']);
    // Use the decrypted admin ID as needed
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
