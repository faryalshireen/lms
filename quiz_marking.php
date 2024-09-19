<?php

include 'teachernav.php';
include "link.php";
include "db_connect.php";

if(isset($_POST['submit'])){
$o_marks=$_POST['obtainmarks'];
$t_marks=$_POST['totalmarks'];
$sql="INSERT INTO `quiz_details` (total_marks, obtain_marks) VALUES ('$o_marks', '$t_marks')";
$result=mysqli_query($conn,$sql);
if($result){
  echo "posted";
}else{
  echo "Posted";
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    input[type=text]{
    border:none;
    width:300px;
    border-bottom:1px solid rgb(43, 39, 145);
    border-radius:0px;
    background-color:#e9ecef;
    align-items: center;
    margin: auto;
  }
  .btn{
    
border: 2px solid rgb(188, 187, 187); 
  color:rgb(43, 39, 145);
  background-color:rgb(134, 198, 247);
  font-weight:bold;
}
.btn:hover{
  background-color:rgb(134, 198, 247);
  border: none;
}
 .jumbotron{
    width: 100%;

  border: 1px solid #c3c3c3;
  
  flex-wrap: wrap;
  align-content: center;
  align-items: center;
  text-align: center;
 }  
  h2{
    color:rgb(134, 198, 247);
  }
   </style>
<body>
<!-- <table class="table">
  <thead>
    <tr>
      <th scope="col">Quiz Name</th>
      <th scope="col">Quiz TIme</th>
      <th scope="col" >Enter Marks</th>
      <th scope="col">Announce Result</th>
    </tr>
  </thead>
  <tbody> -->
    <?php
    
    // $qu_id=$_GET['qu_id'];
    // $select="SELECT * FROM `create_quiz` WHERE id= '{$qu_id}'";  
    //     $sql2=mysqli_query($conn , $select);
    //     while($row= mysqli_fetch_assoc($sql2)){
              
          
           
    //     $title=$row['quiz_title'];
    //     $duration=$row['duration'];
    
    //     echo '<tr>
    //     <th scope="row">'.$title.'</th>
    //     <td>'.$duration.'</td>
    //     <td></td>
    //     <td><a href="#" class="btn">Assign Marks</a></td>

    //   </tr>';
        ?>
        
        
        <?php
   //}
    ?>

    
    
  <!-- </tbody>
</table> -->
<form action="quiz_marking.php"  Method="POST">

<div class="container">
<div class="jumbotron">
  <h1 class="mb-5">ASSIGN QUIZ MARKS:</h1>
 

  <?php
 $qu_id=$_GET['qu_id'];
  $select="SELECT * FROM `create_quiz` WHERE id= '{$qu_id}'";  
      $sql2=mysqli_query($conn , $select);
      while($row= mysqli_fetch_assoc($sql2)){
       $qu_id=$row['id'];     
        
         
      $title=$row['quiz_title'];
      $duration=$row['duration'];

      echo '
   <h2 >Quiz Name : '.$title.'</h2>
     <h2 >Quiz Time : '.$duration.' minute</h2>
  
      <hr class="my-4">
      <input type="text" class="form-control text-center mb-5" placeholder="Total Marks" name="totalmarks" required>

      <input type="text" class="form-control text-center mb-5" placeholder="Obtain Marks" name="obtainmarks" required>
      <button class="btn btn-primary btn-lg" name="submit" type="submit" >Assign Marks</button>
      ';
      }
 
 

  ?>
</div>
    </div>
    </form>
</body>
</html>