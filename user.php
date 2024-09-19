<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Dashoard</title>
    <style>
.item1{
  animation-name: colors;
  animation-duration: 15s;
}

@keyframes colors {
  0%   {color: white;}
  25%  {color: Grey;}
  50%  {color: blue;}
  100% {color: pink;}
}
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
crossorigin="anonymous"></script>
</head>
<body>
<?php
    include 'studentnav.php';
    
?>
<!-- <script>
       $(document).ready(function(){
        setInterval(function(){
        $("#show").load("userdashboard.php");
        },0);
        });
    </script> -->
<p id="show"></p>
<?php
include 'db3.php';
?>

<div class="container mt-3 col-lg-12 col-md-12 col-sm-12">
<h3 class="pb-2" style="color:black;">My Courses( <span style="color: #A995E0;">Fall 2021 </span>  )</h3>
</div>

<div class="card" style="width: 22rem;min-height : 25rem;position: relative;float: right;margin-right:2em;text-align:justify; padding: 15px;border-radius:30px;">
<h4 style="text-align:center;color:red;font-size:30px;background-color:black;margin-bottom : 1em;border-radius:30px;padding-bottom:3px;" class="item1">Announcements</h4>

<?php
include 'db3.php';
?>
<?php

// Start of Announcement
    


function announced($a) {
include 'db1.php';
$announce = "SELECT * from $a ORDER BY id desc"; 
$queryannoun = mysqli_query($con,$announce); 
  if (mysqli_num_rows($queryannoun) == 0){
?>

<p style = "text-align:center;margin-top:40%;">     <?php  echo "You Don't Have Any Announcement yet !";?> </p> 
      <?php
      }
  while($resu = mysqli_fetch_assoc($queryannoun)){
?>


  <p style = "color:red;line-height: 1.0;"><?php echo $resu['teachername'].' : ';?> <span style="color:grey;"><?php echo $resu['announcements'].'<br>';?> </span></p>
 <?php
      
      }
}

//  Start of Announcement logic Work 

$user = $_SESSION['username'];
$resulted = mysqli_query($con,"SELECT * from `userdata` where First ='$user'");
while($row1 = $resulted->fetch_assoc()){


  // echo $row1[1];
  
// $row1 = mysqli_result($and);

if(($row1['Semester']) == '1'){
  announced('semester1');   
 }
 elseif(($row1['Semester']) == '2'){
  announced('semester2'); 
 }
 elseif(($row1['Semester']) == '3'){
  announced('semester3'); 
 }
 elseif(($row1['Semester']) == '4'){
  announced('semester4'); 
 }
 elseif(($row1['Semester']) == "5"){
  announced('semester5'); 
 }
 elseif(($row1['Semester']) == '6'){
  announced('semester6'); 
 } 
 elseif(($row1['Semester']) == '7'){
  announced('semester7'); 
 } 
 elseif(($row1['Semester']) == '8'){
  announced('semester8'); 
 }
else{
  ?>
  <p style = "text-align:center;margin-top:40%;"><?php  echo "You Don't Have Any Announcement yet !";?> </p> 
  <?php 
}


}

?>
</div>


<!-- End of Announcement -->


<!-- Start Of Classes in Dashboard -->

<?php

function courses($clas){

include 'db3.php';
$user = $_SESSION['username'];
$query1 = "SELECT Semester FROM `userdata` where First ='$user' ";
$result1 = mysqli_query($con,$query1);

$result2 = mysqli_fetch_assoc($result1);
$semester = $result2['Semester'];

if(!empty($clas)){
include 'db3.php';
$query2 = "SELECT * FROM courses WHERE semester = $semester ";
$result2 = mysqli_query($con, $query2);

while($resulttwo = mysqli_fetch_assoc($result2)){

$querychecking = "SELECT * FROM trainers WHERE courses = '$clas' and semester = '$semester' ";
$resultchecking = mysqli_query($con, $querychecking);
$resultcheckm = mysqli_fetch_assoc($resultchecking);


if(!empty($resultcheckm['courses'])){
$teachername = $resultcheckm['teachers'];
?>  
  <div class="card mt-2 mb-5 mx-5" style="width: 28rem; ">
    <div class="card-header" style="background-image:linear-gradient(rgba(0.8,0.8,0.8,1.5),#A593DF, #9484DC);">
    <h5><a href="display.php" style="color:white;text-decoration:none"> <?php echo $clas?></a></h5> 
  
    <h5><a href="#" style="color:white;text-decoration:none"> <?php echo $teachername?></a></h5> 

</div>
   
<div class="card-body">
    <div>  <img src="assets/img/admin.jpg" id="admin" alt=""  style="width:75px">
    <a href="#" class="btn " id="btn"><strong style="background-color: rgba(255, 255, 255, 0.781);
    outline-style: solid;
    color: #A995E0;
    border-radius: 50px;
    padding: 8px;
    height: 40px;
    width: 200px;
    margin-left:15em">187</strong></a>
  </div>        
    <p class="card-text mt-4">Credit Hour : <?php echo $resultcheckm['credit']?></p>
    <p class="card-text"> <?php echo $resultcheckm['details']?></p>  
    </div>
</div>
<?php 
}
else{

}

?>

    

<?php

}
}

else{

}
}

?> 
<?php

include 'db3.php';
$user = $_SESSION['username'];
$query3 = "SELECT Semester FROM `userdata` where First ='$user' ";
$result3 = mysqli_query($con,$query3);

$result4 = mysqli_fetch_assoc($result3);
$semester2 = $result4['Semester'];

$query4 = "SELECT * FROM courses where semester = $semester2 ";
$result5 = mysqli_query($con, $query4);
$result6 = mysqli_fetch_array($result5);
if(!isset($result6['semester']) == '0' ){
courses($result6['course1']);
courses($result6['course2']);
courses($result6['course3']);
courses($result6['course4']);
courses($result6['course5']);
}
else{
  ?>

<div>

  <div class="toast-header" style= "width:25em;height : 15em;margin-left:2em;border-radius:10px;border-color:black;">
    <h6 style="margin:auto; "> You Don't Have Any Class Right Now.</h6>
  </div>

</div>


<?php
}
?>




<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

</body>
</html>