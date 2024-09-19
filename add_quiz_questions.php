<?php include "db_connect.php";
include "link.php";
include "teachernav.php";

if (isset($_POST['question_submit'])) {
    $question = htmlentities(mysqli_real_escape_string($conn, $_POST['question']));
    $choice1 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice1']));
    $choice2 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice2']));
    $choice3 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice3']));
    $choice4 = htmlentities(mysqli_real_escape_string($conn, $_POST['choice4']));
    $correct_answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $quiz = mysqli_real_escape_string($conn, $_POST['quiz_id']);
    $courseid = $_POST['course_id'];
    $u_teacherSectionId = $_GET['sec'];

    $checkqsn = "SELECT * FROM questions";
    $runcheck = mysqli_query($conn, $checkqsn) or die(mysqli_error($conn));
    $qno = mysqli_num_rows($runcheck) + 1;
    $user_stdBatch = date('y');

    $query = "INSERT INTO questions(qno, question , ans1, ans2, ans3, ans4, correct_answer, quiz_id, course_id, student_batch, section) VALUES ('$qno' , '$question' , '$choice1' , '$choice2' , '$choice3' , '$choice4' , '$correct_answer' , '$quiz' , '$courseid', '$user_stdBatch', '$u_teacherSectionId')";
    $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Question Successfully Added In Quiz!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> ';
    } else {
        "<script>alert('error, try again!'); </script> ";
    }
}
?>

<?php
$query = "SELECT * FROM `questions`";
$questions = mysqli_query($conn, $query);
$total = mysqli_num_rows($questions);
$nextqno = $total + 1;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz Questions</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->

</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <form action="add_quiz_questions.php?qu_id=<?php echo $_GET['qu_id'] ?>&qid=<?php echo $_GET['qid'] ?>&sec=<?php echo $_GET['sec'] ?>" method="POST">
                <div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="text-primary mb-3 mt-3">Add Questions to Quiz</h4>
                    <input type="hidden" name="quiz_id" value="<?php echo $_GET['qu_id']; ?>" />
                    <input type="hidden" name="course_id" value="<?php echo $_GET['qid']; ?>" />
                    <div class="mt-2">
                        <label>Question #</label>
                        <input type="number" class="form-control" id="question_number" name="question_number" required>
                    </div>
                    <div class="mt-2">
                        <label>Question</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>
                    <div class="mt-2">
                        <label>Option #1</label>
                        <input type="text" class="form-control" id="choice1" name="choice1" required>
                    </div>
                    <div class="mt-2">
                        <label>Option #2</label>
                        <input type="text" class="form-control" id="choice2" name="choice2" required>
                    </div>
                    <div class="mt-2">
                        <label>Option #3</label>
                        <input type="text" class="form-control" id="choice3" name="choice3" required>
                    </div>
                    <div class="mt-2">
                        <label>Option #4</label>
                        <input type="text" class="form-control" id="choice4" name="choice4" required>
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
                    <div class="float-right w-100 text-right">
                        <a href="view_quizz_questions.php?qid=<?php echo $_GET['qu_id'] ?>&sec=<?php echo $_GET['sec'] ?>" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Quiz</a>
                        <button type="submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="question_submit">Add Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>