<?php
    include 'teachernav.php';
    include "link.php";
    include "db_connect.php";
?>
<?php

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
	
	.btn{
  /* border: 2px solid rgb(188, 187, 187); */
  color:white;
  background-color:rgb(134, 198, 247);
  font-size:17px;
}
.btn:hover{
  background-color:rgb(134, 198, 247);
  border: none;
  text-decoration:none;
  color:blue;
}
	</style>
<body>

<header style="background:white;">

			<div class="container mt-5 mb-3" >
            <div class="row">
				<div class="col-lg-6">
				<a href="#" class="btn">All Questions</a>
				<a href="add_quiz_questions.php" class="btn">Add Question</a>
				<!-- <a href="view_quizz_questions.php" class="btn">All Questions</a>
				<a href="players.php" class="btn">Players</a> -->
</div>
<div class="col-lg-6">
<!-- <form action="quiz_questions.php" method="POST"> 
<div class="form-group">
    <label for="exampleFormControlSelect1">Select quiz</label>
    <select class="form-control" name="course" id="exampleFormControlSelect1">
    <?php //$select = "SELECT * FROM `create_quiz`";
//   $sql=mysqli_query($conn , $select);
//   while($row= mysqli_fetch_assoc($sql)){?>
    <option value="<?php //echo $row['id']; ?>"><?php //echo $row['quiz_title']; ?></option> 
 <?php //}
  ?> 
    </select>
  </div>
  </form> -->
  </div>
</div>
				
</div>
</header>
</body>
</html>