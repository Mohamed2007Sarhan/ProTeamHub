<?php
session_start(); // بداية الجلسة

// تضمين ملف الاتصال بقاعدة البيانات
include('../login/config.php');

// التأكد من وجود الإيميل في الجلسة
if (isset($_SESSION['Email_Session'])) {
    $email = $_SESSION['Email_Session'];

    // عمل استعلام للتحقق من user_tybe
    $sql = "SELECT user_type FROM register WHERE Email = '$email'";
    $result = mysqli_query($conx, $sql);

    // لو في نتيجة من الاستعلام
    if (mysqli_num_rows($result) > 0) {
        // جلب القيمة
        $row = mysqli_fetch_assoc($result);
        $user_type = $row['user_type'];

        // إذا كانت user_tybe موجودة، نبعت المستخدم لصفحة معينة
        if (!empty($user_type)) {
            header("Location: ../web/dashboard1.php"); // هنا تضع الصفحة التي تريد توجيه المستخدم إليها
            exit();
        } else {

        }
    } else {
        // لو مفيش نتيجة من الاستعلام (يعني الإيميل مش موجود في قاعدة البيانات)
        header("Location: index.php");
        exit();
    }

} else {
    // لو الإيميل مش موجود في الجلسة، نرجع لصفحة تسجيل الدخول
    header("Location: index.php"); // رجوع لصفحة تسجيل الدخول
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Membership Selection</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e1e2f, #3a3a59);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1300px;
            padding: 20px;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 6px 40px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(12px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 320px;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.3);
        }
        .card-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .card-description {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .card-features {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }
        .card-features li {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .correct { color: #4CAF50; }
        .incorrect { color: #F44336; }
        .card-btn {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(90deg, #ffcc00, #ff8800);
            color: #333;
            font-weight: bold;
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s;
        }
        .card-btn:hover {
            background: linear-gradient(90deg, #ffaa00, #ff6600);
            transform: scale(1.08);
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card">
            <div class="card-title">🎯 Member</div>
            <div class="card-description">Join a team and collaborate efficiently.</div>
            <ul class="card-features">
                <li class="correct">✔ Access to team listings</li>
                <li class="correct">✔ Limited messaging</li>
                <li class="correct">✔ Community Support</li>
                <li class="incorrect">✘ No admin control</li>
            </ul>
            <a href="user_tybe.php?choose=member" class="card-btn">Choose Membership</a>
        </div>
        <div class="card">
            <div class="card-title">🚀 Organizer</div>
            <div class="card-description">Create and manage your own team.</div>
            <ul class="card-features">
                <li class="correct">✔ Create one team</li>
                <li class="correct">✔ Add members</li>
                <li class="correct">✔ Event Planning Tools</li>
                <li class="incorrect">✘ Limited analytics</li>
            </ul>
            <a href="user_tybe.php?choose=organizer" class="card-btn">Choose Membership</a>
        </div>
        <div class="card">
            <div class="card-title">🏢 Company</div>
            <div class="card-description">Manage multiple teams and advanced tools.</div>
            <ul class="card-features">
                <li class="correct">✔ Manage multiple teams</li>
                <li class="correct">✔ Advanced reporting</li>
                <li class="correct">✔ Priority Customer Support</li>
                <li class="incorrect">✘ Limited storage</li>
            </ul>
            <a href="user_tybe.php?choose=company" class="card-btn">Choose Membership</a>
        </div>
        <div class="card">
            <div class="card-title">💡 Expert</div>
            <div class="card-description">Contribute to projects and showcase skills.</div>
            <ul class="card-features">
                <li class="correct">✔ Access project tools</li>
                <li class="correct">✔ Showcase portfolio</li>
                <li class="correct">✔ Exclusive Networking Events</li>
                <li class="incorrect">✘ No team creation</li>
            </ul>
            <a href="user_tybe.php?choose=expert" class="card-btn">Choose Membership</a>
        </div>
    </div>
</body>
</html>
