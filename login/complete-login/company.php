<?php
// Include configuration and encryption files
include('../config.php');
include('../../encryption.php'); // File containing encryption and decryption functions

// Start session
session_start();

// Check for Cookies
if (!isset($_COOKIE['user_email'])) {
    header("Location: ../index.php");
    exit();
}

// Decrypt email from Cookies
$email_encrypted = $_COOKIE['user_email'];
$email = decryptData($email_encrypted);

if (!$email) {
    die("Decryption error");
}

// Retrieve user_id for the logged-in user
$stmt = $conx->prepare("SELECT ID FROM register WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$result_user_id = $stmt->get_result();

if ($result_user_id->num_rows > 0) {
    $row = $result_user_id->fetch_assoc();
    $user_id = $row['ID'];

    $stmt_companies = $conx->prepare("SELECT * FROM companies WHERE user_id = ?");
    $stmt_companies->bind_param('i', $user_id);
    $stmt_companies->execute();
    $result_check_companies = $stmt_companies->get_result();

    if ($result_check_companies->num_rows > 0) {
        header("Location: ../../web/index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['company_name'], $_POST['company_address'], $_POST['company_phone'], $_POST['website_url'], $_POST['bio'])) {
        // Sanitize inputs
        $company_name = htmlspecialchars(trim($_POST['company_name']));
        $company_address = htmlspecialchars(trim($_POST['company_address']));
        $company_phone = filter_var(trim($_POST['company_phone']), FILTER_SANITIZE_NUMBER_INT);
        $website_url = filter_var(trim($_POST['website_url']), FILTER_VALIDATE_URL);
        $bio = htmlspecialchars(trim($_POST['bio']));

        // Handle image upload
        $img_name = null;
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $img = $_FILES['img'];
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $file_extension = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));

            if (in_array($file_extension, $allowed_extensions)) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $img['tmp_name']);
                finfo_close($finfo);

                $allowed_mime_types = ['image/jpeg', 'image/png'];
                if (in_array($mime_type, $allowed_mime_types)) {
                    $new_file_name = uniqid('img_', true) . '.' . $file_extension;
                    $upload_directory = '../uploads/';
                    if (!is_dir($upload_directory)) {
                        mkdir($upload_directory, 0755, true);
                    }

                    $upload_path = $upload_directory . $new_file_name;
                    if (move_uploaded_file($img['tmp_name'], $upload_path)) {
                        $img_name = $new_file_name;
                    } else {
                        die("File upload failed.");
                    }
                } else {
                    die("Unsupported file type.");
                }
            } else {
                die("Unsupported file extension.");
            }
        }

        // Insert data into companies table
        $stmt_insert = $conx->prepare(
            "INSERT INTO companies (user_id, company_name, company_address, company_phone, website_url, bio, img) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt_insert->bind_param('issssss', $user_id, $company_name, $company_address, $company_phone, $website_url, $bio, $img_name);

        if ($stmt_insert->execute()) {
            header("Location: ../../web/index.php");
            exit();
        } else {
            die("Data insertion error: " . $stmt_insert->error);
        }
    } else {
        die("Please fill all required fields.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile Completion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }

        input[type="text"],
        input[type="file"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4A90E2;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px;
            margin-right: 4%;
            display: inline-block;
        }

        button:hover {
            background-color: #357ABD;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .progress-bar {
            height: 20px;
            background-color: #f4f7fc;
            border-radius: 10px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .progress-bar-fill {
            height: 100%;
            width: 0;
            background-color: #4A90E2;
            transition: width 0.3s;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .back-btn {
            background-color: #ccc;
        }

        .back-btn:hover {
            background-color: #bbb;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = document.querySelectorAll('.step');
            const nextBtns = document.querySelectorAll('.next-btn');
            const backBtns = document.querySelectorAll('.back-btn');
            const progressBarFill = document.querySelector('.progress-bar-fill');
            let currentStep = 0;

            function showStep(index) {
                steps.forEach((step, i) => {
                    step.classList.toggle('active', i === index);
                });

                progressBarFill.style.width = `${((index + 1) / steps.length) * 100}%`;

                // إخفاء أو إظهار زر "Back"
                backBtns.forEach((btn, i) => {
                    btn.style.display = i === index && index !== 0 ? 'inline-block' : 'none';
                });

                // تغيير نص زر "Next" إلى "Save Profile" في آخر خطوة
                nextBtns.forEach((btn, i) => {
                    btn.textContent = i === steps.length - 1 ? 'Save Profile' : 'Next';
                });
            }

            nextBtns.forEach((btn, index) => {
                btn.addEventListener('click', function () {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    } else {
                        document.getElementById('profileForm').submit();
                    }
                });
            });

            backBtns.forEach((btn, index) => {
                btn.addEventListener('click', function () {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            showStep(currentStep);
        });
    </script>
</head>

<body>
    <div class="container">
        <h2>Complete Your Company Profile</h2>
        <div class="progress-bar">
            <div class="progress-bar-fill"></div>
        </div>
        <form id="profileForm" action="company.php" method="POST" enctype="multipart/form-data">
            <div class="step active">
                <div class="form-group">
                    <label for="company_name">Company Name:</label>
                    <input type="text" id="company_name" name="company_name" required>
                </div>
                <div class="buttons-container">
                    <button type="button" class="next-btn">Next</button>
                </div>
            </div>

            <div class="step">
                <div class="form-group">
                    <label for="company_address">Company Address:</label>
                    <input type="text" id="company_address" name="company_address">
                </div>
                <div class="buttons-container">
                    <button type="button" class="next-btn">Next</button>
                </div>
            </div>

            <div class="step">
                <div class="form-group">
                    <label for="company_phone">Company Phone Number:</label>
                    <input type="number" id="company_phone" name="company_phone">
                </div>
                <div class="buttons-container">
                    <button type="button" class="next-btn">Next</button>
                </div>
            </div>

            <div class="step">
                <div class="form-group">
                    <label for="website_url">Company Website:</label>
                    <input type="text" id="website_url" name="website_url">
                </div>
                <div class="buttons-container">
                    <button type="button" class="next-btn">Next</button>
                </div>
            </div>

            <div class="step">
                <div class="form-group">
                    <label for="bio">Company Bio:</label>
                    <textarea id="bio" name="bio" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="img">Upload Company Image (JPG, JPEG, PNG):</label>
                    <input type="file" id="img" name="img" accept="image/*">
                </div>

                <div class="buttons-container">
                    <button type="submit" class="next-btn">Save Profile</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
