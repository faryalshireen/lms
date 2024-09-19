<?php
include 'db3.php';
if (isset($_POST['f_tokenkey'])) {
    $c_email = "SELECT * FROM `password_reset_temp` WHERE token='{$_POST['f_tokenkey']}'";
    $query_email = mysqli_query($con, $c_email);
    $q_row = mysqli_fetch_array($query_email);
    // Current Date time
    date_default_timezone_set('Asia/Karachi');
    $f_currentDate = date('Y-m-d H:i:s', time());
    // Calculation token expired
    $to_time = strtotime($q_row['expireDate']);
    $from_time = strtotime($f_currentDate);
    // echo round(abs($to_time - $from_time) / 60,2). " minute";
    $t_expiredDate = round(abs($to_time - $from_time) / 60);

    if ($t_expiredDate <= 15 && isset($_POST['f_tokenkey'])) {
        $change_email = $q_row['email'];
        $change_password = sha1($_POST['f_password']);
        $change_confirmPassword = sha1($_POST['f_confirm_password']);
        // $change_security = $_POST['f_security_answer'];

        if ($change_password == $change_confirmPassword) {
            $inserted = "UPDATE `users` SET `password` = '$change_password' WHERE `users`.`email`= '$change_email'";
            $query = mysqli_query($con, $inserted);
            if ($query) {
                echo 1;
                // header("login.php?success=Password Reset Successfully!");
            } else {
                echo 2;
                // header("forgot_password.php?error=Password Failed to Reset!");
            }
        } else {
            echo 3;
            // header("forgot_password.php?error=Password do not Match!");
        }
    } else {
        echo 4;
        // header("location:login.php?error=Token expired!");
    }
} else {
    echo 5;
    // echo "token missing";
    // header("location:login.php?error=Token Missing!");
}
?>