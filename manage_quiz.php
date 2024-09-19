<?php
include "teachernav.php";
include "link.php";
include "db_connect.php";
?>

<?php
// Delete
if (isset($_GET['Delete'])) {
	$id = $_GET['Delete'];
	$d_sql = "DELETE FROM `create_quiz` WHERE `id` = $id";
	$d_result = mysqli_query($conn, $d_sql);
	if ($d_result) {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		Quizz Deleted Successfully!
			<button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>';
	}
}
// Edit
if (isset($_POST['snoEdit'])) {
	$editno = $_POST['snoEdit'];
	$quizTitle = $_POST['q_title'];
	$quizDuration = $_POST['q_duration'];
	$quiz_courseId = $_POST['q_course'];
	$quiz_sectionId = $_POST['q_usection'];
	$quiz_dueDate = $_POST['q_dueDate'];
	$sql = "UPDATE `create_quiz` SET `quiz_title` = '$quizTitle', `duration` = '$quizDuration', `course_id` = '$quiz_courseId', `section` = '$quiz_sectionId', `due_date` = '$quiz_dueDate' WHERE `create_quiz`.`id` = $editno";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
       Quiz Updated successfully!
       <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
	} else {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Quiz Failed to Update!
       <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
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
	<title>Manage Quiz</title>
	<link rel="stylesheet" href="style3.css">
	<link rel="stylesheet" href="assets/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
	<div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
		<div class="row mt-4">
			<div class="col-md-6">
				<h4 class="text-primary ml-3 mt-1">Manage Quizz</h4>
			</div>
			<div class="col-md-6">
				<?php
				if (isset($_GET['id'])) {
					echo '<a class="btn btn-primary btn-sm float-right text-white" href="create_quiz.php?id=' . $_GET['id'] . '">Create New Quiz</a>';
				} else {
				?>
					<a class="btn btn-primary btn-sm float-right text-white" data-toggle="modal" data-target="#createQuizModal">Create New Quiz</a>
					<!-- Modal Starts Here -->
					<div class="modal fade" id="createQuizModal" tabindex="-1" role="dialog" aria-labelledby="createQuizModalTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Select Course</h5>
									<button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form action="manage_quiz.php" method="POST">
										<div class="mb-2">
											<label>Select Course</label>
											<select class="form-control" name="c_courseId" id="c_courseId" required>
												<?php include "db_connect.php";
												$t_id = $_SESSION['id'];
												$select = "SELECT * FROM `teacher_courses` WHERE section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}'";
												$sql = mysqli_query($conn, $select);
												while ($row = mysqli_fetch_assoc($sql)) { ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
												<?php }
												?>
											</select>
										</div>
										<button type="button" onclick="location.href='create_quiz.php?id='+document.getElementById('c_courseId').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Continue to Create</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal End Here -->
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<div class="container mt-2 mb-5 px-3 py-1 align-center">
		<div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3">
			<div class="align-center text-center">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Sr.</th>
							<th scope="col">Quiz Title</th>
							<th scope="col">Course Name</th>
							<th scope="col">Section</th>
							<th scope="col">Due Date</th>
							<th scope="col">Duration</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$c = 1;
						$t_user_stdBatch = date('y');
						if (isset($_GET['id'])) {
							$c_query = "SELECT * FROM `create_quiz` WHERE course_id= '{$_GET['id']}' AND student_batch='{$t_user_stdBatch}' AND teacher_id= '{$_SESSION['id']}'";
						} else {
							$c_query = "SELECT * FROM `create_quiz` WHERE teacher_id= '{$_SESSION['id']}' AND student_batch='{$t_user_stdBatch}'";
						}
						$c_sql = mysqli_query($conn, $c_query);
						// $select = "SELECT * FROM `userdata` WHERE semester='{$c_row['semester']}'";
						// $query = mysqli_query($conn, $select);
						while ($result = mysqli_fetch_array($c_sql)) {
						?>
							<tr>
								<td><?php echo $c++ ?></td>
								<td><?php echo $result['quiz_title'] ?></td>
								<td>
									<?php
									$course_query = "SELECT * FROM `teacher_courses` WHERE id= '{$result['course_id']}'";
									$course_sql = mysqli_query($conn, $course_query);
									$course_row = mysqli_fetch_array($course_sql);
									echo $course_row['courses_heading'];
									?>
								</td>
								<td style="display: none !important;"><?php
																		$course_query = "SELECT * FROM `teacher_courses` WHERE id= '{$result['course_id']}'";
																		$course_sql = mysqli_query($conn, $course_query);
																		$course_row = mysqli_fetch_array($course_sql);
																		echo $course_row['id'];
																		?></td>
								<td><?php echo $result['section'] ?></td>
								<td><?php echo $result['due_date'] ?></td>
								<td><?php echo $result['duration'] ?> Mins.</td>
								<td style="display: none !important;"><?php echo $result['duration'] ?></td>
								<td>
									<a href="student_quiz_results_view.php?quiz=<?php echo $result['id'] ?>" data-toggle="tooltip" title="Students Submission" class="btn btn-secondary btn-sm btn-inline text-light">
										<i class="fas fa-users"></i>
									</a>
									<a class="btn btn-primary btn-sm btn-inline text-light" href="view_quizz_questions.php?qid=<?php echo $result['id'] ?>&sec=<?php echo $result['section'] ?>">View</a>
									<button class="Edit btn btn-info btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="edit">Edit</button>
									<button class="Delete btn btn-danger btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="delete">Delete</button>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<?php
				if (isset($_GET['id'])) {
					$f_select = "SELECT * FROM `create_quiz` WHERE course_id= '{$_GET['id']}' AND student_batch='{$t_user_stdBatch}' AND teacher_id= '{$_SESSION['id']}'";
				} else {
					$f_select = "SELECT * FROM `create_quiz` WHERE teacher_id= '{$_SESSION['id']}' AND student_batch='{$t_user_stdBatch}'";
				}
				$f_query = mysqli_query($conn, $f_select);
				if (mysqli_num_rows($f_query) <= 0) {
					echo "<p class='text-center'>No Records Found!</p>";
				}
				?>
			</div>
		</div>
	</div>

	<!-- Modal Edit Form Starts Here -->
	<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="EditModalLabel">Edit Quiz</h5>
					<button type="button" class="close close__box_shadow_none" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="manage_quiz.php" method="POST">
						<input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
						<div class="form-group">
							<label>Quiz Title</label>
							<input type="text" name="q_title" class="form-control" id="q_title">
						</div>
						<div class="form-group">
							<label>Course</label>
							<select class="form-control" name="q_course" id="q_course">
								<?php include "db_connect.php";
								$t_id = $_SESSION['id'];
								$select = "SELECT * FROM `teacher_courses` WHERE section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}'";
								$sql = mysqli_query($conn, $select);
								while ($row = mysqli_fetch_assoc($sql)) { ?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
								<?php }
								?>
							</select>
						</div>
						<?php
						if (isset($_GET['id'])) {
						?>
							<div class="form-group">
								<label>Select Section</label>
								<select class="form-control" name="q_usection" id="q_usection">
									<?php include "db_connect.php";
									$t_c_id = $_SESSION['id'];
									$select = "SELECT * FROM `teacher_courses` WHERE id='{$_GET['id']}' AND (section_a= '{$t_c_id}' OR section_b= '{$t_c_id}' OR section_c= '{$t_c_id}' OR section_d= '{$t_c_id}')";
									$sql = mysqli_query($conn, $select);
									while ($row = mysqli_fetch_assoc($sql)) {
										if ($row['section_a'] == $t_c_id) {
											echo '<option value="a">Section A</option>';
										}
										if ($row['section_b'] == $t_c_id) {
											echo '<option value="b">Section B</option>';
										}
										if ($row['section_c'] == $t_c_id) {
											echo '<option value="c">Section C</option>';
										}
										if ($row['section_d'] == $t_c_id) {
											echo '<option value="d">Section D</option>';
										}
									}
									?>
								</select>
							</div>
						<?php
						} else {
						?>
							<div class="form-group d-none">
								<label>User Section</label>
								<select class="form-control" name="q_usection" id="q_usection">
									<option value="a">Section A</option>
									<option value="b">Section B</option>
									<option value="c">Section C</option>
									<option value="d">Section D</option>
								</select>
							</div>
						<?php
						}
						?>
						<div class="form-group">
							<label>Due Date</label>
							<input type="date" name="q_dueDate" class="form-control" id="q_dueDate" min="<?php echo date("Y-m-d"); ?>">
						</div>
						<div class="form-group">
							<label>Duration</label>
							<input type="number" name="q_duration" class="form-control" id="q_duration">
						</div>
						<div class="form-group">
							<?php
							if (isset($_GET['id'])) {
							?>
								<button name="submit" type="submit" formaction="manage_quiz.php?id=<?php echo $_GET['id'] ?>" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update details</button>
							<?php
							} else {
							?>
								<button name="submit" type="submit" formaction="manage_quiz.php" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update details</button>
							<?php
							}
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Edit Form Ends Here -->

	<script>
		// ToolTip
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
		// Delete Function
		deletes = document.getElementsByClassName('Delete');
		Array.from(deletes).forEach((element) => {
			element.addEventListener("click", (e) => {
				id = e.target.id.substr(0);
				if (confirm("Are you sure you want to delete this Quiz?")) {
					window.location = `manage_quiz.php?Delete=${id}`;
				} else {
					console.log("no");
				}
			})
		})
		// Edit Function
		edits = document.getElementsByClassName('Edit');
		Array.from(edits).forEach((element) => {
			element.addEventListener("click", (e) => {
				tr = e.target.parentNode.parentNode;
				title = tr.getElementsByTagName("td")[1].innerText;
				course = tr.getElementsByTagName("td")[3].innerText;
				usection = tr.getElementsByTagName("td")[4].innerText;
				duration = tr.getElementsByTagName("td")[7].innerText;
				due_date = tr.getElementsByTagName("td")[5].innerText;

				q_title.value = title;
				q_course.value = course;
				q_usection.value = usection;
				q_duration.value = duration;
				q_dueDate.value = due_date;
				snoEdit.value = e.target.id;
				$('#EditModal').modal('toggle');
			})
		})
	</script>

</body>

</html>