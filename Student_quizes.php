<?php 

//session_start();
	include "studentnav.php";
	include "link.php";
    include "db_connect.php";
?>
<style>
	.jumbotron-fluid {
    padding-right: 0;
    padding-left: 0;
    border-radius: 0;
    width: 100%;
    text-align: center;
    font-size: 37px;
}
.lead {
    font-size: 49px;
    font-weight: 300;
}
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
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

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
				}else{
					echo'<div class="jumbotron jumbotron-fluid ">
					<div class="container">
					 
					  <h2 class="lead">No quiz Assign yet</h2>
					</div>
				  </div>';
				}
			?>
			<div class="container mt-5">
        <table class="table ml-2 mr-2 mb-3" id="myTable">

            <thead>
                <tr>
                    <th scope="col">SNO</th>
                    <th scope="col">Quiz</th>
                    <th scope="col">Time</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
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
				$sid=$row3['id'];
				$title=$row3['quiz_title'];
				$time=$row3['duration'];
			
			
			echo'
			<tr>
			<th scope="row">'.$sid.'</th>
			<td>'.$title.'</td>
			<td>'.$time.'</td>
			<td><a href="http://localhost/Final_project_lms/quiz_student/home.php?quizid='.$sid.'">Attempt Quiz</a></td>
		  </tr>
						';?>
	     
       <?php
           }
          
       
		?>			


	</tbody>
        </table>
		</div>
        <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
        </script>
	</body>
	</html>

				

