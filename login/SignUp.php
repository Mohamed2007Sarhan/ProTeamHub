<?php
session_start();
if (isset($_SESSION['Email_Session'])) {
    header("Location: ../web/dashboard1.php");
    die();
}
require_once '../encryption.php';
include('config.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$msg = "";
$Error_Pass = "";
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conx, $_POST['Username']);
    $email = mysqli_real_escape_string($conx, $_POST['Email']);
    $Phone = mysqli_real_escape_string($conx, $_POST['Phone']);
    $Password = mysqli_real_escape_string($conx, encryptData($_POST['Password']));
    $Confirm_Password = mysqli_real_escape_string($conx, encryptData($_POST['Conf-Password']));
    $Code = mysqli_real_escape_string($conx, encryptData(rand()));
    if (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM register where email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>This Email:'{$email}' has been alredy existe.</div>";
    } else {
        if ($Password === $Confirm_Password) {
            $query = "INSERT INTO register(`Username`, `email`, `Password`, `CodeV`,`phone_number`) values('$name','$email','$Password','$Code','$Phone')";
            $result = mysqli_query($conx, $query);
            if ($result) {
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'proteamhub44@gmail.com';                     //SMTP username
                    $mail->Password   = 'yqok hzjr twby qunx';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('proteamhub44@gmail.com', 'ProTeamHub');
                    $mail->addAddress($email, $name);
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Welcome to ProTeamHub! 🌟'; // Title with an emoji
                    $mail->Body    = '<p>Welcome to <b>ProTeamHub</b>! 🎉</p>';
                    $mail->Body   .= '<p>We\'re excited to have you on board, ' . $name . ' 😄. You\'ve just joined a community of professionals, and we are thrilled to help you grow your network and achieve your goals! 🚀</p>';
                    $mail->Body   .= '<p>To get started, please verify your account by clicking the link below:</p>';
                    $mail->Body   .= '<p><b><a href="http://localhost/website/proteamhub/login/?Verification=' . $Code . '">Verify Your Account</a></b></p>';
                    $mail->Body   .= '<p>Once you verify, you\'ll be able to explore our platform, build teams, and manage your projects with ease. We\'re here to help you every step of the way! 🌟</p>';
                    $mail->Body   .= '<p>If you have any questions, feel free to reach out to us. We\'re always happy to assist you! 💬</p>';

                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $msg = "<div class='alert alert-info'>we've send a verification code on Your email Address</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something was Wrong</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password is not match</div>";
            $Error_Pass = 'style="border:1px Solid red;box-shadow:0px 1px 11px 0px red"';
        }
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <title>Sign up - ProTeamHub</title>
    <style>
        .alert {
            padding: 1rem;
            border-radius: 5px;
            color: white;
            margin: 1rem 0;
            font-weight: 500;
            width: 65%;
        }

        .alert-success {
            background-color: #42ba96;
        }

        .alert-danger {
            background-color: #fc5555;
        }

        .alert-info {
            background-color: #2E9AFE;
        }

        .alert-warning {
            background-color: #ff9966;
        }
    </style>
</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <?php echo $msg ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="Username" placeholder="Username" value="<?php if (isset($_POST['Username'])) {
                                                                                                echo $name;
                                                                                            } ?>" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="Email" placeholder="Email" value="<?php if (isset($_POST['Email'])) {
                                                                                        echo $email;
                                                                                    } ?>" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-phone"></i>
                        <input type="Phone Number" name="Phone" placeholder="Phone Number" value="<?php if (isset($_POST['Phone'])) {
                                                                                                        echo $Phone;
                                                                                                    } ?>" />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass ?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Password" placeholder="Password" />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass ?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Conf-Password" placeholder="Confirm Password" />
                    </div>
                    <input type="submit" name="submit" class="btn" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>
                        Welcome to ProTeamHub – Your journey to building and joining the perfect team starts here!
                    </p>
                    <a href="index.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">
                        Sign in
                    </a>
                </div>
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    </div>
</body>

</html>