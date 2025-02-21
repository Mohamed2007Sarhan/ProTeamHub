<?php
// تضمين ملف الاتصال بقاعدة البيانات وملف التشفير
include('../config.php');
include('../../encryption.php'); // ملف يحتوي على دوال التشفير وفك التشفير

// بدء الجلسة
session_start();

// التحقق من وجود الـ Cookies
if (!isset($_COOKIE['user_email'])) {
    header("Location: ../index.php");
    exit();
}

// فك تشفير البريد الإلكتروني من الـ Cookies
$email_encrypted = $_COOKIE['user_email'];
$email = decryptData($email_encrypted);

// التحقق من صحة فك التشفير
if (!$email) {
    die("خطأ في فك التشفير");
}

if (isset($_POST['bio'])) {
    $bio = $_POST['bio'];

    // التحقق من أن الـ bio غير فارغ
    if (!empty($bio)) {
        $stmt = $conx->prepare("UPDATE `register` SET `bio` = ? WHERE `email` = ?");
        $stmt->bind_param("ss", $bio, $email);

        // تنفيذ الاستعلام وتحقق من النتيجة
        if ($stmt->execute()) {
            // التحديث تم بنجاح
        } else {
            // التعامل مع فشل التحديث
            echo "حدث خطأ أثناء التحديث.";
        }

        // إغلاق الجلسة
        $stmt->close();
    }
}

// جلب user_id الخاص بالمستخدم
$sql_user_id = "SELECT ID, user_type FROM register WHERE email = ?";
$stmt = $conx->prepare($sql_user_id);
$stmt->bind_param("s", $email);
$stmt->execute();
$result_user_id = $stmt->get_result();

if ($result_user_id->num_rows > 0) {
    $row = $result_user_id->fetch_assoc();
    $user_id = $row['ID'];
    $type = $row['user_type'];

    $stmt->close();

    // التأكد من أن المستخدم هو عضو
    if ($type !== "member") {
        header("Location: index.php");
        exit();
    }

    // التحقق إذا كان يوجد user_id بالفعل في جدول members
    $sql_check_members = "SELECT * FROM members WHERE user_id = ?";
    $stmt = $conx->prepare($sql_check_members);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result_check_members = $stmt->get_result();

    // إذا تم العثور على سجل للمستخدم
    if ($result_check_members->num_rows > 0) {
        // تحديث السيرة الذاتية
        $sql_update_bio = "UPDATE register SET bio = ? WHERE email = ?";
        $stmt_update = $conx->prepare($sql_update_bio);
        $bio_value = 'Table_member'; // القيم الجديدة
        $stmt_update->bind_param("ss", $bio_value, $email);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            header("Location: ../../web/index.php");
            exit();
        }
        $stmt_update->close();
    }
} else {
    header("Location: ../index.php");
    exit();
}

// معالجة التحديث عند إرسال البيانات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // حفظ المهارات والخبرة
    if (isset($_POST['skills'], $_POST['experience'])) {
        $skills = $conx->real_escape_string($_POST['skills']);
        $experience = $conx->real_escape_string($_POST['experience']);

        // التحقق إذا كان يوجد user_id بالفعل في الجدول members
        $sql_check_user = "SELECT * FROM members WHERE user_id = ?";
        $stmt = $conx->prepare($sql_check_user);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // تحديث المهارات والخبرة
            $sql_update_members = "UPDATE members SET skills = ?, experience = ? WHERE user_id = ?";
            $stmt_update = $conx->prepare($sql_update_members);
            $stmt_update->bind_param("ssi", $skills, $experience, $user_id);
            $stmt_update->execute();
        } else {
            // إدخال بيانات جديدة في حال عدم وجود سجل
            $sql_insert_members = "INSERT INTO members (skills, experience, user_id) VALUES (?, ?, ?)";
            $stmt_insert = $conx->prepare($sql_insert_members);
            $stmt_insert->bind_param("ssi", $skills, $experience, $user_id);
            $stmt_insert->execute();
        }

        $stmt->close();
    }

    // رفع السيرة الذاتية
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cv = $_FILES['cv'];
        $allowed_extensions = ['pdf', 'doc', 'docx'];
        $file_extension = pathinfo($cv['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            $new_file_name = uniqid('cv_', true) . '.' . $file_extension;
            $upload_directory = '../uploads/';

            if (!is_dir($upload_directory)) {
                mkdir($upload_directory, 0755, true);
            }

            $upload_path = $upload_directory . $new_file_name;

            if (move_uploaded_file($cv['tmp_name'], $upload_path)) {
                $description = $conx->real_escape_string($_POST['description'] ?? '');
                $created_at = date('Y-m-d H:i:s');

                $sql_insert_cv = "INSERT INTO cvs (user_id, cv_file, description, created_at) VALUES (?, ?, ?, ?)";
                $stmt_insert_cv = $conx->prepare($sql_insert_cv);
                $stmt_insert_cv->bind_param("isss", $user_id, $new_file_name, $description, $created_at);
                $stmt_insert_cv->execute();
                $stmt_insert_cv->close();
            }
        }
    }

    // رفع الصورة
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
                // حفظ اسم الصورة في قاعدة البيانات
                $sql_update_img = "UPDATE members SET img = ? WHERE user_id = ?";
                $stmt_update_img = $conx->prepare($sql_update_img);
                $stmt_update_img->bind_param("si", $new_file_name, $user_id);
                $stmt_update_img->execute();
                $stmt_update_img->close();
            }
        }
    }

    // إعادة التوجيه بعد التحديث
    echo "<script>window.location.href='../../web/dashboard1.php';</script>";
    exit();
}

// جلب البيانات الحالية لعرضها في النموذج
$sql_members_data = "SELECT skills, experience FROM members WHERE user_id = ?";
$stmt = $conx->prepare($sql_members_data);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_members_data = $stmt->get_result();

if ($result_members_data->num_rows > 0) {
    $row = $result_members_data->fetch_assoc();
    $skills = $row['skills'];
    $experience = $row['experience'];
} else {
    $skills = '';
    $experience = '';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completion Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #4a90e2;
            font-size: 36px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 25px;
            display: none;
            opacity: 0;
            animation: slideIn 1s ease-out forwards;
        }

        .form-group:nth-child(1) {
            animation-delay: 0s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.6s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.9s;
        }

        .form-group:nth-child(5) {
            animation-delay: 1.2s;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #344955;
            font-weight: 600;
        }

        textarea,
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 14px;
            background-color: #fafafa;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        textarea:focus,
        input[type="text"]:focus,
        input[type="file"]:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 12px rgba(74, 144, 226, 0.3);
        }

        button {
            width: 100%;
            padding: 16px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            transform: scale(1);
            font-weight: bold;
        }

        button:hover {
            background-color: #357abd;
            transform: scale(1.05);
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: #f0f0f0;
            border-radius: 10px;
            margin-top: 25px;
            margin-bottom: 35px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .progress-bar span {
            display: block;
            height: 100%;
            background-color: #4a90e2;
            width: 0%;
            border-radius: 10px;
            transition: width 0.5s ease-out;
        }

        .progress-bar-label {
            text-align: center;
            margin-top: 12px;
            font-size: 15px;
            color: #4a90e2;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* تحسينات على التأثيرات */
        input[type="file"] {
            padding: 12px;
            background-color: #f7f7f7;
        }

        input[type="file"]:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Completion Profile</h2>

        <form id="profileForm" action="member.php" method="POST" enctype="multipart/form-data">
            <!-- قسم المهارات -->
            <div class="form-group" id="skillsSection">
                <label for="skills">Skills:</label>
                <textarea id="skills" name="skills" rows="5" required></textarea>
                <p>Enter your skills to help others understand your expertise.</p>
            </div>

            <!-- قسم الخبرة -->
            <div class="form-group" id="experienceSection">
                <label for="experience">Experience:</label>
                <textarea id="experience" name="experience" rows="5" required></textarea>
                <p>Describe your professional experience, including relevant job roles.</p>
            </div>

            <!-- قسم السيرة الذاتية -->
            <div class="form-group" id="cvSection">
                <label for="cv">Upload CV (PDF, DOC, DOCX):</label>
                <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx">
                <label for="description">CV Description:</label>
                <input type="text" id="description" name="description" placeholder="Optional description">
                <p>Upload your CV to provide more details about your qualifications.</p>
            </div>

            <!-- قسم السيرة الذاتية -->
            <div class="form-group" id="bioSection">
                <label for="bio">Your BIO in the Team</label>
                <input type="text" name="bio" id="bio" required>
                <p class="description">Enter a short description of yourself.</p>
            </div>

            <!-- قسم الصورة الشخصية -->
            <div class="form-group" id="imgSection">
                <label for="img">Upload Profile Picture (JPG, JPEG, PNG):</label>
                <input type="file" id="img" name="img" accept="image/*">
                <p>Upload your profile picture to personalize your profile.</p>
            </div>

            <div class="progress-bar">
                <span id="progress"></span>
            </div>

            <p class="progress-bar-label" id="progressLabel">Step 1 of 5</p>

            <button type="button" onclick="nextSection()">Next</button>
        </form>
    </div>

    <script>
        let currentSection = 0;
        const sections = document.querySelectorAll('.form-group');
        const progressBar = document.getElementById('progress');
        const progressLabel = document.getElementById('progressLabel');
        const nextButton = document.querySelector('button');

        function showSection(index) {
            sections[index].style.display = 'block';
            sections[index].style.animation = 'slideIn 1s ease-out forwards';
        }

        function hideSections() {
            sections.forEach(section => {
                section.style.display = 'none';
            });
        }

        function updateProgress() {
            const progress = ((currentSection + 1) / sections.length) * 100;
            progressBar.style.width = progress + '%';
            progressLabel.textContent = `Step ${currentSection + 1} of ${sections.length}`;
        }

        function nextSection() {
            const skills = document.getElementById('skills');
            const experience = document.getElementById('experience');

            if (currentSection === 0 && skills.value.trim() === '') {
                alert('Please fill in your skills.');
                return;
            }

            if (currentSection === 1 && experience.value.trim() === '') {
                alert('Please fill in your experience.');
                return;
            }

            if (currentSection < sections.length - 1) {
                hideSections();
                currentSection++;
                showSection(currentSection);
                updateProgress();
            } else {
                nextButton.textContent = 'Submit';
                nextButton.onclick = function() {
                    document.getElementById('profileForm').submit();
                };
            }
        }

        showSection(currentSection);
        updateProgress();
    </script>
</body>

</html>
