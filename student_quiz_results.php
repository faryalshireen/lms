<?php 

// if (isset($_SESSION['admin'])) {
	include "teachernav.php";
	include "link.php";
    include "db_connect.php";
?>
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

<!DOCTYPE html>
<html>
	<head>
		<title>ALL QUIZES</title>
		<!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
</head>
	<body>
			<div class="container bg-light">
			<div class="row">
				<div class="col-lg-12">
				<h2 class="text-dark">ALL QUIZES:</h2> </div>
				

					<!-- coursename -->

					<?php
					$cid = $_GET['id'];  

				$select2="SELECT * FROM create_quiz WHERE course_id = $cid";
				$sql3=mysqli_query($conn , $select2);
				if(mysqli_num_rows($sql3) > 0){
				$row3=mysqli_fetch_array($sql3);
				$title = $row3['quiz_title'];
				$courseid = $row3['course_id'];
			     
					
					
					$t_id = $_SESSION['id'];

					// echo $title;


					// $cid = $_GET['id'];  
	
				$select0="SELECT * FROM teacher_courses WHERE id = $cid";
				$sql0=mysqli_query($conn , $select0);
				$row0 = mysqli_fetch_array($sql0);
				$sem = $row0['semesters'];
					?>
		

			 <?php
				
			//}
		

			?>
			
			<?php 
				
				
						
// quizes display
                        
 
     
        $select="SELECT * FROM teacher_courses WHERE id= '{$cid}'";  
        $sql2=mysqli_query($conn , $select);
       	$row1= mysqli_fetch_assoc($sql2);
			$courses=$row1['courses_heading'];
			$semester=$row1['semesters'];
			$courseid=$row1['id'];
			//echo $courseid;
			
			$select2="SELECT * FROM create_quiz WHERE course_id='{$cid}'";
			$sql3=mysqli_query($conn , $select2);
			while($row3=mysqli_fetch_assoc($sql3)){
			$title=$row3['quiz_title'];
			$qid=$row3['id'];
			
			
			echo'
						<div class="col-lg-4">
						<div class="card mt-3" style="max-width: 18rem; height:150px;">
						<h4 class="card-header  bg-transparent border-primary">'.$title.'</h4>
						
						<a href="student_quiz_results_view.php?semester='.$semester.'&quiz='.$qid.'" class="btn mt-5 ">view Student Result</a>
					  </div>
					  
					  </div>
						';?>
	     
       <?php
           }
		}else{
			echo '<div class="jumbotron jumbotron-fluid text-center w-100 ">
			<div class="container">
			  <h1 class="display-4 text-danger"><b>OOPS! No Result Found</b></h1>
			  <h4 class="lead"><b>There are no Quizes available</b> </h4>
			</div>
		  </div>';
		 }
       
		?>			
	</div>

	
	</body>
	</html>

				

