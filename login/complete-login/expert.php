<?php
// 🌟 Include configuration file
include('../config.php');

// 🚀 Start session
session_start();

// 🛑 Check if user is logged in
if (!isset($_SESSION['Email_Session'])) {
    header("Location: ../");
    exit();
}

$email = $_SESSION['Email_Session'];

// ✅ Retrieve user data safely
$sql = $conx->prepare("SELECT user_type, Username, bio, profile_picture, ID FROM register WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 0) {
    header("Location: ../logout.php"); // 🚪 Redirect to logout if session is tampered
    exit();
}

$row = $result->fetch_assoc();
$user_type = $row['user_type'];
$username = $row['Username'];
$expert_description = $row['bio'];
$profile_picture = $row['profile_picture'];
$user_id = $row['ID'];

// 🔒 Check if user is an expert
if ($user_type !== 'expert') {
    header('Location: index.php');
    exit();
}

// 📋 Retrieve expert details
$sql_expert = $conx->prepare("SELECT expertise_area, portfolio_url FROM experts WHERE user_id = ?");
$sql_expert->bind_param("i", $user_id);
$sql_expert->execute();
$result_expert = $sql_expert->get_result();

$expert_data = $result_expert->fetch_assoc() ?? ['expertise_area' => '', 'portfolio_url' => ''];
$expertise_area = $expert_data['expertise_area'];
$portfolio_url = $expert_data['portfolio_url'];

// 🔄 Redirect to dashboard if description is set
if (!empty($expert_description)) {
    header("Location: ../../web/dashboard1.php");
    exit;
}

// 🖊️ Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 🛡️ Sanitize and validate form inputs
    $new_username = htmlspecialchars(trim($_POST['username']));
    $new_expert_description = htmlspecialchars(trim($_POST['bio']));
    $new_expertise_area = htmlspecialchars(trim($_POST['expertise_area'] ?? ''));

    // 🖼️ Process profile picture upload
    $image_path = $profile_picture; // Default to existing profile picture
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_picture']['name'];
        $image_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $file_type = mime_content_type($image_tmp_name);
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($file_type, $allowed_types)) {
            die("<p class='error'>❌ Invalid image type. Only JPG, PNG, and GIF are allowed.</p>");
        }

        if ($_FILES['profile_picture']['size'] > 5000000) { // Max size 5MB
            die("<p class='error'>❌ Image size must be less than 5MB.</p>");
        }

        $image_path = '../uploads/' . uniqid() . basename($image_name);
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            die("<p class='error'>❌ Failed to upload image.</p>");
        }
    }

    // 📂 Process portfolio file upload
    $portfolio_path = $portfolio_url; // Default to existing portfolio
    if (isset($_FILES['portfolio']) && $_FILES['portfolio']['error'] === UPLOAD_ERR_OK) {
        $portfolio_name = $_FILES['portfolio']['name'];
        $portfolio_tmp_name = $_FILES['portfolio']['tmp_name'];
        $file_type = mime_content_type($portfolio_tmp_name);
        $allowed_portfolio_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        if (!in_array($file_type, $allowed_portfolio_types)) {
            die("<p class='error'>❌ Invalid portfolio file type. Only PDF or Word documents are allowed.</p>");
        }

        if ($_FILES['portfolio']['size'] > 10000000) { // Max size 10MB
            die("<p class='error'>❌ Portfolio size must be less than 10MB.</p>");
        }

        $portfolio_path = '../uploads/' . uniqid() . basename($portfolio_name);
        if (!move_uploaded_file($portfolio_tmp_name, $portfolio_path)) {
            die("<p class='error'>❌ Failed to upload portfolio.</p>");
        }
    }

    // 📝 Update user data
    $sql_update = $conx->prepare("UPDATE register SET Username = ?, bio = ?, profile_picture = ? WHERE ID = ?");
    $sql_update->bind_param("sssi", $new_username, $new_expert_description, $image_path, $user_id);

    if (!$sql_update->execute()) {
        die("<p class='error'>❌ Error updating user data: " . $conx->error . "</p>");
    }

    // 📌 Update or insert into experts table
    $sql_expert_update = $conx->prepare(
        "INSERT INTO experts (user_id, expertise_area, portfolio_url) 
         VALUES (?, ?, ?) 
         ON DUPLICATE KEY UPDATE expertise_area = ?, portfolio_url = ?"
    );
    $sql_expert_update->bind_param("issss", $user_id, $new_expertise_area, $portfolio_path, $new_expertise_area, $portfolio_path);

    if (!$sql_expert_update->execute()) {
        die("<p class='error'>❌ Error updating expert data: " . $conx->error . "</p>");
    }

    // 🎉 Success
    header("Location: ../../web/dashboard1.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Expert Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .expert-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            margin-top: 10px;
        }

        /* Hide steps initially */
        .step {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Complete Your Expert Information</h2>
    <form method="POST" enctype="multipart/form-data" id="expertForm">

        <!-- Step 1: Username -->
        <div class="form-group step" id="step1">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>

        <!-- Step 2: Expert Description -->
        <div class="form-group step" id="step2">
            <label for="bio">Expert Description</label>
            <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($expert_description); ?></textarea>
        </div>

        <!-- Step 3: Profile Picture -->
        <div class="form-group step" id="step3">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" id="profile_picture" name="profile_picture">
            <?php if ($profile_picture) { ?>
                <img class="expert-image" src="<?php echo $profile_picture; ?>" alt="Profile Picture">
            <?php } ?>
        </div>

        <!-- Step 4: Area of Expertise -->
        <div class="form-group step" id="step4">
            <label for="expertise_area">Area of Expertise</label>
            <input type="text" id="expertise_area" name="expertise_area" value="<?php echo htmlspecialchars($expertise_area); ?>">
        </div>

        <!-- Step 5: Portfolio -->
        <div class="form-group step" id="step5">
            <label for="portfolio">Portfolio (optional)</label>
            <input type="file" id="portfolio" name="portfolio">
        </div>

        <!-- Buttons to navigate between steps -->
        <div class="form-group">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)" style="display:none;">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            <button type="submit" id="submitBtn" style="display:none;">Submit</button>
        </div>
    </form>
</div>

<script>
    var currentStep = 0; // Current step is set to 0

    // Show the first step
    showStep(currentStep);

    function showStep(n) {
        // Hide all steps
        var steps = document.getElementsByClassName("step");
        for (var i = 0; i < steps.length; i++) {
            steps[i].style.display = "none";
        }

        // Show the current step
        steps[n].style.display = "block";

        // Hide or show the previous and next buttons
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n == (steps.length - 1)) {
            document.getElementById("nextBtn").style.display = "none";
            document.getElementById("submitBtn").style.display = "inline";
        } else {
            document.getElementById("nextBtn").style.display = "inline";
            document.getElementById("submitBtn").style.display = "none";
        }
    }

    function nextPrev(n) {
        // Validate the current step
        var steps = document.getElementsByClassName("step");
        if (n == 1 && !validateStep()) return false;

        // Hide the current step
        steps[currentStep].style.display = "none";

        // Increase or decrease the current step by 1
        currentStep = currentStep + n;

        // If we've reached the last step, submit the form
        if (currentStep >= steps.length) {
            document.getElementById("expertForm").submit();
            return false;
        }

        // Show the next step
        showStep(currentStep);
    }

    function validateStep() {
        // Placeholder for validation, add checks as needed
        var currentStepFields = document.getElementsByClassName("step")[currentStep];
        if (currentStepFields.querySelector("input") && currentStepFields.querySelector("input").value == "") {
            alert("Please fill in the required fields.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
