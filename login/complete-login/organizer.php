<?php
// Include the database connection and encryption file
include('../config.php');
include('../../encryption.php'); // File containing encryption and decryption functions

// Start the session
session_start();

// Generate a CSRF token if not set
// if (empty($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// }

// Check if the cookies exist


// Decrypt the email from the cookies
$email_encrypted = $_COOKIE['user_email'];
$email = decryptData($email_encrypted);

// Check if decryption is successful
if (!$email) {
    die("Decryption error");
}

// Fetch the user ID associated with the email
$stmt = $conx->prepare("SELECT ID, user_type FROM register WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result_user_id = $stmt->get_result();

if ($result_user_id->num_rows > 0) {
    $row = $result_user_id->fetch_assoc();
    $user_id = $row['ID'];
    $type = $row['user_type'];

    if ($type !== "organizer") {
        header("Location: index.php");
        exit();
    }
    
    // Check if the user is a team founder
    $stmt_check_founder = $conx->prepare("SELECT * FROM team_founders WHERE user_id = ?");
    $stmt_check_founder->bind_param("i", $user_id);
    $stmt_check_founder->execute();
    $result_check_founder = $stmt_check_founder->get_result();

    if ($result_check_founder->num_rows > 0) {
        // If the user is a team founder, redirect to the team dashboard
        header("Location: ../../web/index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

// Process the form when it's submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    // if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    //     die("Invalid request.");
    // }

    // Save bio
    if (isset($_POST['bio']) && !empty($_POST['bio'])) {
        $bio = htmlspecialchars($_POST['bio'], ENT_QUOTES, 'UTF-8');
        $stmt = $conx->prepare("UPDATE `register` SET `bio` = ? WHERE `email` = ?");
        $stmt->bind_param("ss", $bio, $email);
        if (!$stmt->execute()) {
            die("Error updating bio.");
        }
        $stmt->close();
    }

    // Save team name and role
    if (isset($_POST['team_name'], $_POST['role'])) {
        $team_name = $conx->real_escape_string($_POST['team_name']);
        $role = $conx->real_escape_string($_POST['role']);

        $stmt_check_founder = $conx->prepare("SELECT * FROM team_founders WHERE user_id = ?");
        $stmt_check_founder->bind_param("i", $user_id);
        $stmt_check_founder->execute();
        $result = $stmt_check_founder->get_result();

        if ($result->num_rows > 0) {
            // If the user is already a founder, update the data
            $stmt_update_founder = $conx->prepare("UPDATE team_founders SET team_name = ?, role = ? WHERE user_id = ?");
            $stmt_update_founder->bind_param("ssi", $team_name, $role, $user_id);
            $stmt_update_founder->execute();
        } else {
            // Insert new founder data
            $stmt_insert_founder = $conx->prepare("INSERT INTO team_founders (team_name, role, user_id) VALUES (?, ?, ?)");
            $stmt_insert_founder->bind_param("ssi", $team_name, $role, $user_id);
            $stmt_insert_founder->execute();
        }
    }

    // Upload CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cv = $_FILES['cv'];
        $allowed_extensions = ['pdf', 'doc', 'docx'];
        $file_extension = pathinfo($cv['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            if ($_FILES['cv']['size'] > 5000000) { // 5MB max size
                die("File is too large.");
            }

            $new_file_name = uniqid('cv_', true) . '.' . $file_extension;
            $upload_directory = '../uploads/';
            if (!is_dir($upload_directory)) {
                mkdir($upload_directory, 0755, true);
            }

            $upload_path = $upload_directory . $new_file_name;

            if (move_uploaded_file($cv['tmp_name'], $upload_path)) {
                $description = $conx->real_escape_string($_POST['description'] ?? '');
                $created_at = date('Y-m-d H:i:s');

                $stmt_insert_cv = $conx->prepare("INSERT INTO cvs (user_id, cv_file, description, created_at) VALUES (?, ?, ?, ?)");
                $stmt_insert_cv->bind_param("isss", $user_id, $new_file_name, $description, $created_at);
                $stmt_insert_cv->execute();
            }
        } else {
            die("Invalid file type.");
        }
    }

    // Upload image
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['img'];
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = pathinfo($img['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            $new_file_name = uniqid('img_', true) . '.' . $file_extension;
            $upload_directory = '../uploads/';
            if (!is_dir($upload_directory)) {
                mkdir($upload_directory, 0755, true);
            }

            $upload_path = $upload_directory . $new_file_name;

            if (move_uploaded_file($img['tmp_name'], $upload_path)) {
                $stmt_update_img = $conx->prepare("UPDATE team_founders SET img = ? WHERE user_id = ?");
                $stmt_update_img->bind_param("si", $new_file_name, $user_id);
                $stmt_update_img->execute();
            }
        } else {
            die("Invalid image file.");
        }
    }

    // Redirect after updating
    header("Location: ../../web/index.php");
    exit();
}

// Fetch current data to display in the form
$stmt_founder_data = $conx->prepare("SELECT team_name, role FROM team_founders WHERE user_id = ?");
$stmt_founder_data->bind_param("i", $user_id);
$stmt_founder_data->execute();
$result_founder_data = $stmt_founder_data->get_result();

if ($result_founder_data->num_rows > 0) {
    $row = $result_founder_data->fetch_assoc();
    $team_name = $row['team_name'];
    $role = $row['role'];
} else {
    $team_name = '';
    $role = '';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Team Founders Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #70e1f5, #ffd194);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 700px;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
            font-size: 28px;
            font-weight: 700;
        }

        .form-group {
            display: none;
            margin-bottom: 20px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 16px;
        }

        textarea,
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 16px;
            background-color: #fafafa;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        textarea:focus,
        input[type="text"]:focus,
        input[type="file"]:focus {
            border-color: #4A90E2;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #4A90E2;
            color: #fff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #357ABD;
        }

        .progress-bar {
            width: 100%;
            height: 5px;
            background-color: #ddd;
            border-radius: 5px;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .progress-bar span {
            display: block;
            height: 100%;
            background-color: #4A90E2;
            width: 0%;
            border-radius: 5px;
        }

        .form-group img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-top: 10px;
            transition: transform 0.3s ease;
        }

        .form-group img:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Update Team Founders Profile</h2>
        <form action="organizer.php" method="POST" enctype="multipart/form-data">
            <!-- Section 1: Team Information -->
            <div class="form-group" id="team-info">
                <label for="team_name">Team Name</label>
                <input type="text" name="team_name" id="team_name" value="<?php echo $team_name; ?>" required>
            </div>

            <div class="form-group" id="role-info">
                <label for="role">Your Role in the Team</label>
                <input type="text" name="role" id="role" value="<?php echo $role; ?>" required>
            </div>

            <!-- Section 2: Profile Image -->
            <div class="form-group" id="image-upload">
                <label for="img">Upload Profile Image</label>
                <input type="file" name="img" id="img">
                <?php if (isset($row['img']) && $row['img'] != ""): ?>
                    <img src="../uploads/<?php echo $row['img']; ?>" alt="Profile Image">
                <?php endif; ?>
            </div>

            <!-- Section 3: Your BIO -->
            <div class="form-group" id="bio">
                <label for="bio">Your BIO in the Team</label>
                <input type="text" name="bio" id="bio" value="" required>
            </div>

            <!-- Section 4: Upload CV -->
            <div class="form-group" id="cv-upload">
                <label for="cv">Upload Your CV</label>
                <input type="file" name="cv" id="cv" required>
            </div>

            <!-- Section 5: Description -->
            <div class="form-group" id="description-upload">
                <label for="description">CV Description (optional)</label>
                <textarea name="description" id="description"><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea>
            </div>

            <!-- Next Button -->
            <button type="submit" id="next-btn" onclick="nextSection()">Next</button>

        </form>

        <div class="progress-bar">
            <span></span>
        </div>
    </div>

    <script>
        let currentSection = 0;
        const sections = document.querySelectorAll('.form-group');
        const progressBar = document.querySelector('.progress-bar span');

        function nextSection() {
            // Hide the current section
            sections[currentSection].style.display = 'none';
            sections[currentSection].style.opacity = '0';

            // Move to the next section
            currentSection++;

            if (currentSection < sections.length) {
                // Show the next section
                sections[currentSection].style.display = 'block';
                sections[currentSection].style.opacity = '1';

                // Update the progress bar
                progressBar.style.width = ((currentSection + 1) * 100) / sections.length + '%';
            }

            // Change button text when it's the last section
            if (currentSection >= sections.length - 1) {
                document.getElementById('next-btn').textContent = 'Submit';
            }
        }

        // Initially display the first section
        sections[currentSection].style.display = 'block';
        sections[currentSection].style.opacity = '1';
    </script>

</body>

</html>
