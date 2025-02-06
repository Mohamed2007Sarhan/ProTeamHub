<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../login/vendor/autoload.php';
require_once '../encryption.php'; // تضمين ملف التشفير

// Get email and name from cookies and decrypt them
$user_email = isset($_COOKIE['user_email']) ? decryptData($_COOKIE['user_email']) : '';
$user_name = isset($_COOKIE['user_name']) ? decryptData($_COOKIE['user_name']) : '';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                   // Enable SMTP authentication
    $mail->Username   = 'proteamhub44@gmail.com';  // SMTP username
    $mail->Password   = 'yqok hzjr twby qunx';  // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable implicit TLS encryption
    $mail->Port       = 587;                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Recipients
    $mail->setFrom('proteamhub44@gmail.com', 'ProTeamHub');
    $mail->addAddress($user_email, $user_name);  // Add recipient's email and name here

    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->CharSet = 'UTF-8'; // Ensure that the email uses UTF-8 encoding for special characters and emojis
    $mail->Subject = 'Welcome to ProTeamHub! 🎉';  // Title with an emoji

    // تصميم البريد الإلكتروني مع صورة وشعار
    $mail->Body    = '
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                color: #333;
                padding: 20px;
                margin: 0;
            }
            .header {
                background-color: #2e5e7e;
                color: white;
                text-align: center;
                padding: 30px 0;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .header h1 {
                font-size: 36px;
                margin: 0;
            }
            .content {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 10px;
                margin-top: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .content p {
                font-size: 18px;
                line-height: 1.6;
            }
            .cta-button {
                background-color: #4CAF50;
                color: white;
                padding: 12px 20px;
                font-size: 18px;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 20px;
                display: inline-block;
            }
            .footer {
                text-align: center;
                font-size: 14px;
                color: #777;
                margin-top: 30px;
            }
            /* إزالة النقاط من القائمة */
            ul {
                list-style-type: none; /* إزالة النقاط */
                padding-left: 0;
                margin: 0;
            }
            li {
                font-size: 18px;
                margin-bottom: 10px;
            }
            /* تخصيص الروابط */
            a {
                color: #4CAF50;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Welcome to <span style="color: #f3a536;">ProTeamHub</span>! 🎉</h1>
        </div>
        
        <div class="content">
            <p>Dear <b>' . $user_name . '</b>,</p>
            <p>We are thrilled to welcome you to the ProTeamHub community! 🚀 You\'ve just taken the first step towards unlocking endless opportunities to grow, connect, and achieve your professional goals. We are excited to have you on board! 🎉</p>
            
            <p><b>What’s Next?</b> 🧐</p>
            <p>Now that you\'re a member of ProTeamHub, here are some things you can do right away:</p>
            <ul>
                <li><b>Create your first team:</b> Start building your dream team and collaborate on exciting projects.</li>
                <li><b>Explore job opportunities:</b> Browse available positions and join teams that match your skills and aspirations.</li>
                <li><b>Connect with professionals:</b> Expand your network and interact with like-minded people.</li>
            </ul>
            
            <p>We are here to support you at every step of the way. Whether you want to manage your projects, find new opportunities, or simply connect with others, ProTeamHub is designed to help you succeed. 💼</p>
            
            <p>Ready to start your journey? Click below to explore your personalized dashboard:</p>
            <p><a href="http://localhost/website/proteamhub/web/pages/" class="cta-button">Go to ProTeamHub Pages</a></p>
        </div>

        <div class="footer">
            <p>If you have any questions or need help, our support team is here for you. Feel free to reach out to us anytime! 💬</p>
            <p>Best regards,<br> The ProTeamHub Team</p>
        </div>
    </body>
    </html>';

    // Send the email
    $mail->send();
    echo 'Message has been sent';
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
