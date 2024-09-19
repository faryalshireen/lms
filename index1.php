<?php
require 'assets/phpmailer/PHPMailer.php';
require 'assets/phpmailer/SMTP.php';
require 'assets/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = "true";
$mail->SMTPSecure = "tls";
$mail->Port = "587";
$mail->Username = "shamza1082@gmail.com";
// $mail->Password = "ch@rtered";
$mail->Password = "imcstfkwgemeonaa";
$mail->Subject = "hello there?";
// $mail->isHTML(true);

$mail->setFrom("shamza1082@gmail.com");
// $mail->Body = "<p>THIS IS PLAIN TEXT.</p>";
$mail->Body = "THIS IS PLAIN TEXT.";
$mail->addAddress("shamza1082@gmail.com");

if($mail->send()) {
    echo "Email Sent..!";
} else {
    echo "failed";
}

$mail->smtpClose();






?>