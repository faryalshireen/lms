<?php include "db_connect.php";
include "link.php";
include "teachernav.php";
?>

<?php
if (isset($_POST['add_existing_submit'])) {
	$previous = $_POST['q_courseId'];
	$question_id = $_GET['qid'];
	$user_stdBatch = date('y');
	// $t_uSectionId = $_POST['tu_section'];

	$sql = "UPDATE `questions` SET `quiz_id` = '$question_id', `student_batch` = '$user_stdBatch', `section` = '{$_GET['sec']}' WHERE `questions`.`qid` = $previous";
	$execute = mysqli_query($conn, $sql);

	// $assign_sql = "INSERT INTO `questions` (`qno`, `question`, `ans1`, `ans2`, `ans3`, `ans4`, `correct_answer`, `quiz_id`, `course_id`, `section`, `student_batch`) SELECT `qno`, `question`, `ans1`, `ans2`, `ans3`, `ans4`, `correct_answer`, '{$question_id}', `course_id`, '{$_GET['sec']}', '{$user_stdBatch}' FROM `questions` WHERE qid = '$previous'";
	// $execute = mysqli_query($conn, $assign_sql);
?>
	<script>
		$('#addExistngModal').modal('toggle');
	</script>
<?php
	if (mysqli_affected_rows($conn) > 0) {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		 Previous Question Added Successfully!
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div> ';
	} else {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		 Question Failed to Add or Already Added!
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div> ';
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>View Quiz Questions</title>
	<link rel="stylesheet" href="style3.css">
	<link rel="stylesheet" href="assets/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<!-- Data Table CSS -->
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/style1.css"> -->
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
	<!-- <style>
		.container {
			width: 100%;
		}

		h1 {
			font-size: 40px;
		}
	</style> -->
</head>

<body>
	<div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-md-6">
				<h4 class="text-primary pl-2 pt-2">Quiz Questions</h4>
			</div>
			<div class="col-md-6">
				<?php
				$select = "SELECT * FROM create_quiz WHERE id='{$_GET['qid']}'";
				$sql = mysqli_query($conn, $select);
				$row = mysqli_fetch_array($sql);
				$qu_courseId = $row['course_id'];
				?>
				<a class="btn btn-primary btn-sm float-right mt-2 text-white" href="add_quiz_questions.php?qu_id=<?php echo $row['id'] ?>&qid=<?php echo $row['course_id'] ?>&sec=<?php echo $_GET['sec'] ?>">Add New Questions</a>
				<a class="btn btn-primary btn-sm float-right mt-2 mr-1 text-white" data-toggle="modal" data-target="#addExistngModal">Add Existing</a>
			</div>
		</div>
	</div>

	<!-- Add Previous Questins Modal -->
	<div class="modal fade" id="addExistngModal" tabindex="-1" role="dialog" aria-labelledby="addExistngModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add Previous Questions</h5>
					<button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="view_quizz_questions.php?qid=<?php echo $_GET['qid'] ?>&sec=<?php echo $_GET['sec'] ?>" method="POST">
					<div class="modal-body">
						<div class="mt-2">
							<label>Select Questions:</label>
							<select class="form-control" name="q_courseId" id="q_courseId">
								<?php
								$select_sql = "SELECT * FROM teacher_courses Where id='{$qu_courseId}'";
								$result_sql = mysqli_query($conn, $select_sql);
								$q_row = mysqli_fetch_assoc($result_sql);

								$select = "SELECT * FROM `questions` WHERE course_id='{$q_row['id']}'";
								$sql = mysqli_query($conn, $select);
								if (mysqli_num_rows($sql) >= 1) {
									while ($row = mysqli_fetch_assoc($sql)) {
								?>
										<option value="<?php echo $row['qid']; ?>"><?php echo $row['question']; ?></option>
									<?php
									}
								} else {
									?>
									<option value="">No Previous Found</option>
								<?php
								} ?>
							</select>
						</div>
					</div>
					<div class="modal-footer pt-0 pb-0">
						<button type="submit" name="add_existing_submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Add Question</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Add Previous Questins Modal Ends Here -->


	<div class="container mt-2 mb-5 px-3 py-1 align-center">
		<div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pt-3 pb-2">
			<div class="align-center">
				<table class="table" id="myTable">
					<thead>
						<tr>
							<th scope="col">Sr.</th>
							<th scope="col">Question</th>
							<th scope="col">Option #1</th>
							<th scope="col">Option #2</th>
							<th scope="col">Option #3</th>
							<th scope="col">Option #4</th>
							<th scope="col">Correct</th>
							<th scope="col">Section</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$c = 1;
						$q_select = "SELECT * FROM questions WHERE quiz_id	= '{$_GET['qid']}'";
						$query = mysqli_query($conn, $q_select);
						while ($result = mysqli_fetch_array($query)) {
						?>
							<tr>
								<td><?php echo $result['qno'] ?> </td>
								<td><?php echo $result['question'] ?></td>
								<td><?php echo $result['ans1'] ?></td>
								<td><?php echo $result['ans2'] ?></td>
								<td><?php echo $result['ans3'] ?></td>
								<td><?php echo $result['ans4'] ?></td>
								<td><?php echo $result['correct_answer'] ?></td>
								<td><?php echo $result['section'] ?></td>
								<td>
									<a class="Edit btn btn-info btn-sm btn-inline text-light pl-3 pr-3" href="editquestion.php?qno=<?php echo $result['qid'] ?>&sec=<?php echo $_GET['sec'] ?>" name="edit">Edit</a>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#myTable').DataTable();
		});
	</script>
</body>

</html>