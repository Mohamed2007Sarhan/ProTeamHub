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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completion Profile</title>
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
            position: relative;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            display: none;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }

        textarea,
        input[type="text"],
        input[type="file"] {
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

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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
                <textarea id="skills" name="skills" rows="5" required><?= htmlspecialchars($skills) ?></textarea>
                <p>Enter your skills to help others understand your expertise.</p>
            </div>

            <!-- قسم الخبرة -->
            <div class="form-group" id="experienceSection">
                <label for="experience">Experience:</label>
                <textarea id="experience" name="experience" rows="5" required><?= htmlspecialchars($experience) ?></textarea>
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
            <div class="form-group" id="bio">
                <label for="bio">Your BIO in the Team</label>
                <input type="text" name="bio" id="bio" value="" required>
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

            <button type="button" onclick="nextSection()">Next</button>
        </form>
    </div>

    <script>
        let currentSection = 0;
        const sections = document.querySelectorAll('.form-group');
        const progressBar = document.getElementById('progress');
        const nextButton = document.querySelector('button');

        function showSection(index) {
            sections[index].style.display = 'block';
        }

        function hideSections() {
            sections.forEach(section => {
                section.style.display = 'none';
            });
        }

        function updateProgress() {
            const progress = ((currentSection + 1) / sections.length) * 100;
            progressBar.style.width = progress + '%';
        }

        function nextSection() {
            const skills = document.getElementById('skills');
            const experience = document.getElementById('experience');

            // تحقق من أن الحقول المطلوبة غير فارغة
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