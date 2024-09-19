<?php
include 'db_connect.php';
if(isset($_POST['submit'])){
$quiz_id=$_POST['quiz_id'];

   $update= "UPDATE `student_total_quiz_marks` SET `is_posted` = '1' WHERE `student_total_quiz_marks`.`quiz_id` = $quiz_id";
   $result=mysqli_query($conn, $update);
   if($result){
    echo 'posted';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
     exit;
    
   }else{
    echo 'no';
   }

}



?>