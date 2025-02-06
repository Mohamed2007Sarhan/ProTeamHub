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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Selection Cards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            max-width: 1200px;
            width: 100%;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .card-description {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }
        .card-features {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
            color: #555;
        }
        .card-features li {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 8px;
        }
        .card-features li span {
            margin-left: 8px;
            font-size: 16px;
        }
        .card-features li.correct {
            color: #4CAF50; /* Green for correct */
        }
        .card-features li.incorrect {
            color: #F44336; /* Red for incorrect */
        }
        .card-btn {
            display: inline-block;
            padding: 8px 18px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }
        .card-btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr 1fr; /* Two cards per row */
            }
        }

        @media (max-width: 480px) {
            .card-container {
                grid-template-columns: 1fr; /* One card per row */
                text-align: center;
            }
            .card-btn {
                width: 100%;
            }
        }
        .blue-line {
            border-top: 2px solid rgb(15, 15, 176); /* خط أزرق */
            margin-bottom: 1; /* المسافة بين الخطين */
        }
    </style>
</head>
<body>

    <div class="card-container">
        <!-- Member Card -->
        <div class="card">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACuElEQVR4nNWZv4oUQRDGv/zuDIS7HTc2EMwEH8PwMPPPRMJuYHDgc+gjXHygLyDC3aYmt39OQ0VWMRAMRDk452iokbK3e7Zruqtn5oMOlp2G+nVXf93VDYTpNoADDFx3AKwBrAAUGDDEVwAVtYsOYO4DeA3gB4BfAGYAHraFmBFEbpjHAC7ZQPL2SgpxBmCXgs8JUwK48kDU7VAKAQtEG6ZkEJ8bQE6lEEZTBqA5MyWDeA7gJoD3HpCfUohaEwpcK81KC6KWD+Z7GwgujTTzQTTBnNib3Zq5kwQiVZptg+Awn+g742b3/v1DO7YkGL5WUqRZKATo/4q+N9a8IWkw9Vqx+0ph2kKUTR+2Hdm2bqYCEQsjdTNVCL5mFtT5I4AxwjVifX39nzKIF4EQfwE8Qwu1mZkQN8syE7Ew29zsqAsIDTeruoJI5Wa9gIiFedMniLZultWdtGB6DREKMwiIbTCDgqiVcp8wA7OPDuXaK6QQBd2ZnXcNcxQJwQdi3tWNZuzZyVUCzHPDpDoAukqAeS4YDXeySwADdQuK0jiK+0qAhdbMaNUTTSXAgmarFxD7AdbaVAIsU8HEQpwL94mpI82iYWLTqQaRutHEkWatYVK5E4eRutHIcrMPwguR5Av7gGZEMjOFx82CnwG13InDhFjrtMHNtsI8Ub7tsGFGEW628sHcAPA7Q43N6xnJPjH1pNnGzD4IDC7FRQFfxBI3mtBTyIz6run3f3rJps13NkpZ2fE0M24U4mY7AN5Rn28A7ro+WlpFkh2sRnlqw4xjIcYUoH2pVgetWWOHwOyEQBg9ckDU7SrD5ZlZIyuPG+3S22ZFb53mzdOr4wYQ0/6QNWtq5IARQRh9cQS/JAMwbraHPCoYzAVzpyAIo7cEc0xpJjrPKMJUEog+qiAYs08MFqKWcbONzc6la/81Kct6w+prAAAAAElFTkSuQmCC" alt="design--v1">
            <div class="card-title">Member (Join a Team)</div>
            <div class="card-description">
                This membership is for those who are looking to join a team. Limited access to teams and messaging.
            </div>
            <div class="blue-line"></div>
            <div class="blue-line"></div>
            <ul class="card-features">
                <li class="correct"><span>✔</span> Access to basic team listings</li>
                <li class="correct"><span>✔</span> Send limited messages</li>
                <li class="incorrect"><span>✘</span> Browse team members</li>
            </ul>
            <a href="user_tybe.php?choose=member" class="card-btn">Choose Membership</a>
        </div>

        <!-- Organizer Card -->
        <div class="card">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAA00lEQVR4nO2RMQ6CQBBFXyMHsNQr2ekB6CxsRW+gWOkFPILGcAYre46w0tugjZhNRkJY2YVCE5WX/GR3/syfwELL3+IBK+AMKCCUWl3fiR7ISgob+E6UDAXATM6qgV97wQyYWxZU+QZ9IAISyy9YFvpdvkEkTQe5exKiLI9s8w0SCe/x7XQBH9gDMXARxVKbiHYVvi8ZBh1gAaQvHi8r6e7wU8nSmTnbwvAJWANjYCTS5414zwVHYGjxdWbOVYpTYOBQIL03h6+/JCd7kz63oOWHeQCPlJxaHxqPQAAAAABJRU5ErkJggg==" alt="user-group-man-woman">

            <div class="card-title">Organizer (Create a Team)</div>
            <div class="card-description">
                For those who want to create and manage a team. Add members and organize projects.
            </div>
            <div class="blue-line"></div>
            <div class="blue-line"></div>


            <ul class="card-features">
                <li class="correct"><span>✔</span> Create one team</li>
                <li class="correct"><span>✔</span> Add team members</li>
                <li class="incorrect"><span>✘</span> Access advanced project tools</li>
            </ul>
            <a href="user_tybe.php?choose=organizer" class="card-btn">Choose Membership</a>
        </div>

        <!-- Company Card -->
        <div class="card">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAA00lEQVR4nO2RMQ6CQBBFXyMHsNQr2ekB6CxsRW+gWOkFPILGcAYre46w0tugjZhNRkJY2YVCE5WX/GR3/syfwELL3+IBK+AMKCCUWl3fiR7ISgob+E6UDAXATM6qgV97wQyYWxZU+QZ9IAISyy9YFvpdvkEkTQe5exKiLI9s8w0SCe/x7XQBH9gDMXARxVKbiHYVvi8ZBh1gAaQvHi8r6e7wU8nSmTnbwvAJWANjYCTS5414zwVHYGjxdWbOVYpTYOBQIL03h6+/JCd7kz63oOWHeQCPlJxaHxqPQAAAAABJRU5ErkJggg==" alt="user-group-man-woman">
            <div class="card-title">Company (Manage Multiple Teams)</div>
            <div class="card-description">
                Designed for companies who need to manage multiple teams. Advanced reporting and team tools.
            </div>
            <div class="blue-line"></div>
            <div class="blue-line"></div>

            <ul class="card-features">
                <li class="correct"><span>✔</span> Manage multiple teams</li>
                <li class="correct"><span>✔</span> Advanced reporting & analytics</li>
                <li class="incorrect"><span>✘</span> Create unlimited teams</li>
            </ul>
            <a href="user_tybe.php?choose=company" class="card-btn">Choose Membership</a>
        </div>

        <!-- Expert Card -->
        <div class="card">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAtklEQVR4nO2VQQ6AIAwE+/9PryeuNoAtpc4mHjxInGynmJH7oo+e4xEgRiOlRum4MwLEaCQkcmZ69b2MI21AxNayfzSiqHtIyY4A4oVGNtfv7IiWXb/XgyB7NdlXz3EDyC0XorrIriAQr8kRHFHS1kofrRFArIgj6iK7gkBwpJrsq+e4AWSxkXRH1EV2BYF4TYY78vYzV8muj0DSR2sEEGs+WukgmviZmW/THREgRiPaGS1iB/MAmdNHABZD2NEAAAAASUVORK5CYII=" alt="company">

            <div class="card-title">Expert (Contribute to Projects)</div>
            <div class="card-description">
                For experts who wish to contribute to projects and earn based on their expertise.
            </div>
            <div class="blue-line"></div>
            <div class="blue-line"></div>

            <ul class="card-features">
                <li class="correct"><span>✔</span> Access project tools</li>
                <li class="correct"><span>✔</span> Show portfolio</li>
                <li class="incorrect"><span>✘</span> Team creation tools</li>
            </ul>
            <a href="user_tybe.php?choose=expert" class="card-btn">Choose Membership</a>
        </div>
    </div>

</body>
</html>
