<?php
include 'db_connect.php';
// include 'db3.php';
require 'teachernav.php';
?>

<?php
if (isset($_GET['qno'])) {
	$qno = mysqli_real_escape_string($conn, $_GET['qno']);
	if (is_numeric($qno)) {
		$query = "SELECT * FROM questions WHERE qid = '$qno' ";
		$run = mysqli_query($conn, $query) or die(mysqli_error($conn));
		if (mysqli_num_rows($run) > 0) {
			while ($row = mysqli_fetch_array($run)) {
				$qno = $row['qno'];
				$question = $row['question'];
				$ans1 = $row['ans1'];
				$ans2 = $row['ans2'];
				$ans3 = $row['ans3'];
				$ans4 = $row['ans4'];
				$correct_answer = $row['correct_answer'];
				$quiz_id = $row['quiz_id'];
			}
		} else {
			echo "<script> alert('error');
			window.location.href = 'allquestions.php'; </script>";
		}
	} else {
		header("location: allquestions.php");
	}
}
?>
<?php
if (isset($_POST['submit'])) {
	$question = htmlentities(mysqli_real_escape_string($conn, $_POST['question']));
	$choice1 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice1']));
	$choice2 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice2']));
	$choice3 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice3']));
	$choice4 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice4']));
	$correct_answer = mysqli_real_escape_string($conn, $_POST['answer']);
	$t_change_quizId = $_POST['changequiz'];

	$query = "UPDATE questions SET question = '$question' , ans1 = '$choice1' , ans2= '$choice2' , ans3 = '$choice3' , ans4 = '$choice4' , correct_answer = '$correct_answer', quiz_id = '$t_change_quizId' WHERE qno = '$qno' ";
	$run = mysqli_query($conn, $query) or die(mysqli_error($conn));
	if (mysqli_affected_rows($conn) > 0) {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		Question Updated Successfully!
	   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		 <span aria-hidden="true">&times;</span>
	   </button>
	 </div> ';
	} else {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Question Failed to update!
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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<title>Edit Quiz Questions</title>
	<link rel="stylesheet" href="assets/css/all.min.css">
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
</head>

<body>
	<div class="container">
		<div class="row">
			<form action="editquestion.php?qno=<?php echo $_GET['qno'] ?>" method="POST" enctype="multipart/form-data">
				<div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
					<h4 class="text-primary mb-3 mt-3">Edit Questions - Quiz</h4>
					<div class="mt-2">
						<label>Question</label>
						<input type="text" class="form-control" id="question" name="question" value="<?php echo $question; ?>">
					</div>
					<div class="mt-2">
						<label>Choice # 1</label>
						<input type="text" class="form-control" id="choice1" name="choice1" value="<?php echo $ans1; ?>">
					</div>
					<div class="mt-2">
						<label>Choice # 2</label>
						<input type="text" class="form-control" id="choice2" name="choice2" value="<?php echo $ans2; ?>">
					</div>
					<div class="mt-2">
						<label>Choice # 3</label>
						<input type="text" class="form-control" id="choice3" name="choice3" value="<?php echo $ans3; ?>">
					</div>
					<div class="mt-2">
						<label>Choice # 4</label>
						<input type="text" class="form-control" id="choice4" name="choice4" value="<?php echo $ans4; ?>">
					</div>
					<div class="mt-2">
						<label>Correct Answer</label>
						<select name="answer" class="form-control">
							<option value="a">Choice #1 </option>
							<option value="b">Choice #2</option>
							<option value="c">Choice #3</option>
							<option value="d">Choice #4</option>
						</select>
					</div>
					<div class="mt-2">
						<label>Change Quiz</label>
						<input type="text" class="form-control" id="changequiz" name="changequiz" value="<?php echo $quiz_id; ?>">
					</div>
					<div class="float-right w-100 text-right">
						<a href="view_quizz_questions.php?qid=<?php echo $quiz_id ?>&sec=<?php echo $_GET['sec'] ?>" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Questions</a>
						<button type="submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="submit">Update Details</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</body>

</html>