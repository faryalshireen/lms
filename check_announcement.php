<?php
include 'db3.php';
require 'studentnav.php';
$c_announcement_id = $_POST['s_announcement_id'];
if (empty($_POST['s_course_id'])) {
    $c_isRead = 1;
} else {
    $c_isRead = 2;
}
$c_user_id = $_SESSION['id'];
$c_courseId = $_POST['s_course_id'];
$c_role_id = $_SESSION['role_id'];
if(isset($_SESSION['user_section'])) {
    $c_user_section = $_SESSION['user_section'];
} else {
    $c_user_section = NULL;
}

if (empty($_POST['s_course_id']) && !isset($_SESSION['user_section'])) {
    $check_existed = "SELECT * FROM `announcement_status` WHERE user_id='{$_SESSION['id']}' AND announcement_id='{$c_announcement_id}'";
} else if (isset($_SESSION['user_section'])) {
    $check_existed = "SELECT * FROM `announcement_status` WHERE user_id='{$_SESSION['id']}' AND section='{$_SESSION['user_section']}' AND course_id='{$c_courseId}' AND announcement_id='{$c_announcement_id}'";
} else {
    $check_existed = "SELECT * FROM `announcement_status` WHERE user_id='{$_SESSION['id']}' AND course_id='{$c_courseId}' AND announcement_id='{$c_announcement_id}'";
}

$q_existed = mysqli_query($conn, $check_existed);
if (mysqli_num_rows($q_existed) <= 0) {
    $inserted = "INSERT INTO `announcement_status` (`announcement_id`,`is_read`,`user_id`,`course_id`,`role_id`,`section`) VALUES ('$c_announcement_id','$c_isRead','$c_user_id','$c_courseId','$c_role_id', '$c_user_section')";
    $q_result = mysqli_query($conn, $inserted);
    if ($q_result) {
        echo 'Done';
    } else {
        echo "Failed";
    }
} else {
    echo "Existed";
}
