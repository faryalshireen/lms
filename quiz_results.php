<?php
    include 'teachernav.php';
    include "link.php";
    include "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashoard</title>
    <style>
    .card {
        height: 250px;
        margin: 10px 10px 0px 10px;
    }

    .number {

        width: 25px;
        height: 25px;
        border: 0.5px solid rgb(188, 187, 187);
        text-align: center;
        border-radius: 10px;
        font-size: 15px;


    }

    .btn {
        /* border: 2px solid rgb(188, 187, 187); */
        color: rgb(43, 39, 145);
    }

    .btn:hover {
        background-color: rgb(134, 198, 247);
        border: none;
    }
    </style>
</head>

<body>

    <?php 
if ($_SESSION['message']) {
  echo $_SESSION['message'];
}    

?>

    <!-- updated -->
    <div class="row">
        <?php
$t_name = $_SESSION['name'];
$t_id = $_SESSION['id'];

$sql="SELECT * FROM `assigned_courses` WHERE teacher_id= '{$t_id}'";
if($result = mysqli_query($conn, $sql)){
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
  $course_id = $row['course_id'];
  
  $select="SELECT * FROM `teacher_courses` WHERE id= '{$course_id}'";
       $result2=mysqli_query($conn,$select);
       while($row=mysqli_fetch_assoc($result2)){
       $course=$row['courses_heading'];
       $semester=$row['semesters'];
       $course_des=$row['courses_des'];
       $id = $row['id'];
       $_SESSION['semester'] = $semester;

     }
       echo'<div class="col-lg-4">
       <div class="card">
       <div class="card-body">
       <span class="btn mt-5">Semester '.$semester.'</span>
         <h3 class="card-title mt-3">'.$course.'</h3>
         <a href="student_quiz_results.php?id='.$id.'" class="btn btn-sm btn-primary text-light">See Results </a>
         </div>
       </div>
     </div>';
 
  
    }
  }
  }



?>


    </div>



</body>

</html>