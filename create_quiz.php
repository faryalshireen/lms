<?php
include "link.php";
include "db_connect.php";
include "teachernav.php";
?>

<?php
if (isset($_POST['quiz_submit'])) {
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    // $semester = $_POST['semester'];
    // $semester = 1;
    // Semester Query Starts Here
    $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$_GET['id']}'";
    $c_sql = mysqli_query($conn, $c_query);
    $c_row = mysqli_fetch_array($c_sql);
    $semester = $c_row['semesters'];
    // Semester Query Ends Here
    $course = $_POST['course_id'];
    $c_teacherId = $_SESSION['id'];
    $q_dueDate = $_POST['dueDate'];
    $user_section = $_POST["u_section"];
    $tuser_stdBatch = date('y');

    $insert = "INSERT INTO create_quiz (quiz_title, course_id, duration, semester, teacher_id, due_date, section, student_batch) VALUES('$title' , '$course', '$duration', '$semester', '$c_teacherId', '$q_dueDate', '$user_section', '$tuser_stdBatch')";
    $q_result = mysqli_query($conn, $insert);
    if ($q_result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Quizz Created Successfully!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
?>
        <script>
            setTimeout(() => {
                window.location = `manage_quiz.php`;
            }, 1500);
        </script>
<?php
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Quizz Failed to Create!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <form action="create_quiz.php?id=<?php echo $_GET['id'] ?>" method="POST">
                <div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="text-primary mb-3 mt-3">Create New Quiz</h4>
                    <div class="mt-2">
                        <label>Quiz Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mt-2">
                        <label>Select Course</label>
                        <select class="form-control" name="course_id">
                            <?php include "db_connect.php";
                            $t_id = $_SESSION['id'];
                            $select = "SELECT * FROM `teacher_courses` WHERE id='{$_GET['id']}' AND (section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}')";
                            $sql = mysqli_query($conn, $select);
                            while ($row = mysqli_fetch_assoc($sql)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label>Select Section</label>
                        <select class="form-control" name="u_section" required>
                            <?php include "db_connect.php";
                            $t_id = $_SESSION['id'];
                            $select = "SELECT * FROM `teacher_courses` WHERE id='{$_GET['id']}' AND (section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}')";
                            $sql = mysqli_query($conn, $select);
                            while ($row = mysqli_fetch_assoc($sql)) {
                                if ($row['section_a'] == $t_id) {
                                    echo '<option value="a">Section A</option>';
                                }
                                if ($row['section_b'] == $t_id) {
                                    echo '<option value="b">Section B</option>';
                                }
                                if ($row['section_c'] == $t_id) {
                                    echo '<option value="c">Section C</option>';
                                }
                                if ($row['section_d'] == $t_id) {
                                    echo '<option value="d">Section D</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label>Due Date</label>
                        <input type="date" class="form-control" id="dueDate" name="dueDate" min="<?php echo date("Y-m-d"); ?>" required>
                    </div>
                    <div class="mt-2">
                        <label>Quiz Duration</label>
                        <input type="number" class="form-control" id="duration" name="duration" placeholder="5 minutes" required>
                        <small>Duration will be calculated in minutes</small>
                    </div>
                    <div class="float-right w-100 text-right">
                        <a href="manage_quiz.php" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Listing</a>
                        <button type="submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="quiz_submit" id="imp">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>