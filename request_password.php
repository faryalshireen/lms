<?php
include "link.php";
include "db_connect.php";
if (!isset($_SESSION['username']) && !isset($_SESSION['id'])) {
} else {
    header("Location:login.php");
}
?>

<?php
require 'assets/phpmailer/PHPMailer.php';
require 'assets/phpmailer/SMTP.php';
require 'assets/phpmailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer();

if (isset($_POST['requestPassword_submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $requested_email = $_POST['r_email'];
    $status_query = "SELECT * FROM `users` WHERE email= '{$requested_email}' AND is_active= 1";
    $status_sql = mysqli_query($conn, $status_query);
    if (mysqli_num_rows($status_sql) >= 1) {
        $token_key = bin2hex(random_bytes(50)); // Auto Generated Token
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        // $mail->Username = "shamza1082@gmail.com";
        $mail->Username = "shamza1082@gmail.com";
        // $mail->Password = "ch@rtered";
        $mail->Password = "nqnnjpjxojwajeuy";
        $mail->Subject = "Request Change Password - LMS";
        $mail->isHTML(true);
        $mail->setFrom("shamza1082@gmail.com");
        $mail->Body = "<p>This email is to inform you that you have requested to change your password.</p>
        <p>Please follow this url for password reset</p>
        <a href='http://localhost/ProjectFY/forgot_password.php?key=`$token_key`' target='_blank'>Request Password</a>";
        // $mail->Body = "THIS IS PLAIN TEXT.";
        $mail->addAddress($requested_email);
        if ($mail->send()) {
            date_default_timezone_set('Asia/Karachi');
            $u_currentDate = date('Y-m-d H:i:s', time());
            $inserted = "INSERT INTO `password_reset_temp` (`email`,`token`,`expireDate`) VALUES ('$requested_email','$token_key','$u_currentDate')";
            mysqli_query($conn, $inserted);
            header("location:login.php?success=Please check email!");
        } else {
            header("location:request_password.php?error=Email Failed to Sent!");
        }
        $mail->smtpClose();
    } else {
        header("location:request_password.php?error=User doesnt exist!");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Request Password</title>
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
    html {
    height: 100%;
}
body {
  
    height: 100%;
    margin: 0;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

/* Text Align */
.text-c {
    text-align: center;
}
.text-l {
    text-align: left;
}
.text-r {
    text-align: right
}
.text-j {
    text-align: justify;
}

/* Text Color */
.text-whitesmoke {
    color: whitesmoke
}
.text-darkyellow {
    color: whitesmoke
}

/* Lines */

.line-b {
    border-bottom: 1px solid #FFEB3B !important;
}

/* Buttons */
.button {
    border-radius: 3px;
}
.form-button {
    background-color:gray;
    border-color:black;
    color: whitesmoke;
}
.form-button:hover,
.form-button:focus,
.form-button:active,
.form-button.active,
.form-button:active:focus,
.form-button:active:hover,
.form-button.active:hover,
.form-button.active:focus {
    background-color:black;
    border-color: rgba(255, 235, 59, 0.473);
    color: #e6e6e6;
}
.button-l {
    width: 100% !important;
}

/* Margins g(global) - l(left) - r(right) - t(top) - b(bottom) */

.margin-g {
    margin: 15px;
}
.margin-g-sm {
    margin: 10px;
}
.margin-g-md {
    margin: 20px;
}
.margin-g-lg {
    margin: 30px;
}

.margin-l {
    margin-left: 15px;
}
.margin-l-sm {
    margin-left: 10px;
}
.margin-l-md {
    margin-left: 20px;
}
.margin-l-lg {
    margin-left: 30px;
}

.margin-r {
    margin-right: 15px;
}
.margin-r-sm {
    margin-right: 10px;
}
.margin-r-md {
    margin-right: 20px;
}
.margin-r-lg {
    margin-right: 30px;
}

.margin-t {
    margin-top: 15px;
}
.margin-t-sm {
    margin-top: 10px;
}
.margin-t-md {
    margin-top: 20px;
}
.margin-t-lg {
    margin-top: 30px;
}

.margin-b {
    margin-bottom: 15px;
}
.margin-b-sm {
    margin-bottom: 10px;
}
.margin-b-md {
    margin-bottom: 20px;
}
.margin-b-lg {
    margin-bottom: 30px;
}

/* Bootstrap Form Control Extension */

.form-control,
.border-line {
    background-color: #5f5f5f;
    background-image: none;
    border: 1px solid #424242;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
.form-control:focus,
.border-line:focus {
    border-color: #FFEB3B;
    background-color: #616161;
    color: #e6e6e6;
}
.form-control,
.form-control:focus {
    box-shadow: none;
}
.form-control::-webkit-input-placeholder { color: #BDBDBD; }

/* Container */

.container-content {
    background-color: #3a3a3aa2;
    color: inherit;
    padding: 15px 20px 20px 20px;
    border-color: #FFEB3B;
    border-image: none;
    border-style: solid solid none;
    border-width: 1px 0;
}

/* Backgrounds */

.main-bg {

    background-image: url('https://e0.pxfuel.com/wallpapers/177/481/desktop-wallpaper-login-background-for-android-tip.jpg');
    background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}

/* Login & Register Pages*/

.login-container {
    max-width: 400px;
    z-index: 100;
    margin: 0 auto;
    padding-top: 100px;
}
.login.login-container {
    width: 300px;
}
.wrapper.login-container {
    margin-top: 140px;
}
.logo-badge {
    color: #e6e6e6;
    font-size: 80px;
    font-weight: 800;
    letter-spacing: -10px;
    margin-bottom: 0;
}
</style>
</head>




<body class="main-bg">
        <div class="login-container text-c animated flipInX">
                <div>
                    <h1 class="logo-badge text-whitesmoke"><span class="fa fa-user-circle"></span></h1>
                </div>
                    <h3 class="text-whitesmoke"> BookEducation Learning Management System</h3>
                    <p class="text-whitesmoke"> Forgot Password Reset</p>
                    <?php if (isset($_GET['error'])) { ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_GET['error'] ?>
                                                </div><?php
                                                    } ?>
                                            <?php if (isset($_GET['success'])) { ?>
                                                <div class="alert alert-success" role="alert">
                                                    <?= $_GET['success'] ?>
                                                </div><?php
                                                    } ?>
                <div class="container-content">
                    <form class="margin-t"action="request_password.php" method="post">
                        <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="r_email" name="r_email" placeholder="Email Address" required></div>
                        <button type="submit" type="submit" name="requestPassword_submit" class="form-button button-l margin-b">Request Password</button>
        
                        <a class="text-darkyellow" href="login.php"><small>Back to Login</small></a>
                    </form>
                   
                </div>
            </div>
           <!-- Bootstrap core JavaScript-->
            <script src="assets/vendor/jquery/jquery.min.js"></script>
            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>