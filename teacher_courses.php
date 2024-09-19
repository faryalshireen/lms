<?php
include "teachernav.php";
include "link.php";
include "db_connect.php";
?>

<style>
  .card {
    height: 350px;
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Courses</title>
</head>

<body>

<!-- <div class="container">
<div class="card text-center" style="width: 18rem; height:150px;">
  <div class="card-body">
    <h5 class="card-title">QUIZES</h5>
    <p class="card-text">COURSE 1</p>
    <a href="manage_quiz.php" class="btn btn-primary">SET QUIZ</a>
  </div>
</div>
</div> -->

  <!-- <table class="table ml-2 mr-2 mb-3" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.NO</th>
      <th scope="col">Courses</th>
      <th scope="col">teacher</th>
      <th scope="col">Course Category</th>
      <th scope="col">Course description</th>

    </tr>
  </thead> -->

  <!-- <tbody> -->
  <?php
  //   $sql="SELECT * FROM `teacher_courses`";
  //   $result=mysqli_query($conn,$sql);
  //   while($row= mysqli_fetch_assoc($result)){
  //   // echo $row['id'];
  //   // echo $row['courses_heading'];
  //   $ID= $row['id'];
  //   $teacher=$row['courses_assign_teacher'];
  //   $heading= $row['courses_heading'];
  //   $cat= $row['courses_cat'];
  //   $des= $row['courses_des'];
  //   $string = strip_tags($des);
  //  if(strlen($string)>50){
  //   $srtingcut=substr($string,0,100);
  //   $endpoint=strrpos($srtingcut,' ');
  //   $string=$endpoint?substr($srtingcut,0,$endpoint):substr($srtingcut,0);
  //   $string.='...';
  //  }?>
  <!-- <div class="col-sm-4">
    <tr>
      <th scope="row"><?php //echo $ID; ?></th>
      <td><?php //echo $heading; ?></td>
      <?php //$select = "SELECT * FROM `teachers` WHERE `id` = $teacher";
      //$query=mysqli_query($conn , $select);
     
      //while($row1 = mysqli_fetch_assoc($query)){?>
      <td><?php //echo $row1['teacher_name'];?></td>
      <?php //} ?>
      <td><?php //echo $cat; ?></td>
      <td><?php //echo $string; ?></td>
   
    </tr>
    </div> -->
  <?php //}
    ?>


  <!-- </tbody>
 </table> -->


  <!-- updated -->
  <div class="row">
  <?php
$t_name = $_SESSION['name'];
$t_id = $_SESSION['id'];
// print_r($t_id);
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

       echo'<div class="col-lg-4">
       <div class="card">
       <div class="card-body">
     
       <a href="manage_quiz.php" class="btn mt-5">'.$semester.'</a>
         <h3 class="card-title mt-3">'.$course.'</h3>
         <p class="card-text">'.$string.'</p>
         </div>
       </div>
     </div>';
  $string = strip_tags($course_des);
     if(strlen($string)>50){
      $srtingcut=substr($string,0,100);
      $endpoint=strrpos($srtingcut,' ');
      $string=$endpoint?substr($srtingcut,0,$endpoint):substr($srtingcut,0);
      $string.='...';
     }
  
  }
  }
}
}


?>





  <!-- <div class="col-sm-4">
    <div class="card">
    <div class="card-body">
      <div class="number"> 2 </div>
      <a href="#" class="btn mt-5">Go somewhere</a>
        <h3 class="card-title mt-3">Web Development</h3>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
       <div class="number"> 3 </div>
      <a href="#" class="btn mt-5">Go somewhere</a>
        <h3 class="card-title mt-3">Special title treatment</h3>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
    <div class="card-body">
      <div class="number"> 4 </div>
      <a href="#" class="btn mt-5">Go somewhere</a>
        <h3 class="card-title mt-3">Special title treatment</h3>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div> -->
  </div>
</body>

</html>