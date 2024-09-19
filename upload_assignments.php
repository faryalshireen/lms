<?php
include 'db3.php';
require 'teachernav.php';
?>

<?php
if (isset($_POST['assignment_submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

    $filename = $_FILES['upload_file']['name'];
    $filepath = $_FILES['upload_file']['tmp_name'];
    $fileerror = $_FILES['upload_file']['error'];
    $filesize = $_FILES['upload_file']['size'];

    $courseId = $_POST["courseId"];
    $teacherId = $_SESSION['id'];
    // Semester Query Starts Here
    $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$courseId}'";
    $c_sql = mysqli_query($con, $c_query);
    $c_row = mysqli_fetch_array($c_sql);
    $semester = $c_row['semesters'];
    // Semester Query Ends Here
    $desc = $_POST["desc"];
    $course = $_POST["course"];
    $deadline = $_POST["deadline"];
    $total_marks = $_POST["marks"];
    $user_section = $_POST["u_section"];
    $user_stdBatch = date('y');
    $desfile = $filename;
    move_uploaded_file($filepath, $desfile);
    $inserted = "INSERT INTO `upload` (`course_id`,`teacher_id`,`Semester`,`title`,`total_marks`,`description`,`Deadline`,`section`,`student_batch`,file) VALUES ('$courseId','$teacherId','$semester','$course','$total_marks', '$desc','$deadline','$user_section', '$user_stdBatch','$desfile')";
    $query = mysqli_query($con, $inserted);
    if ($query) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Your Assignment Has been created!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
?>
        <script>
            setTimeout(() => {
                window.location = `view_assignment.php?` + window.location.href.split('?')[1];
            }, 1000);
        </script>
<?php
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Your Assignment Failed to created!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
} else {
    //echo "no click";
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Create Assignment</title>

    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <div class="row">
            <form action="upload_assignments.php?id=<?php echo $_GET['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="text-primary mb-3 mt-3">Create Assignment</h4>
                    <div class="mt-2">
                        <label>Assignment Title</label>
                        <input type="text" class="form-control" id="course" name="course" placeholder="Programming Concepts" required>
                    </div>
                    <div class="mt-2">
                        <label>Select Course</label>
                        <select class="form-control" name="courseId" required>
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
                        <label>Total Marks</label>
                        <input type="number" class="form-control" id="marks" name="marks" required>
                    </div>
                    <div class="mt-2">
                        <label>Description</label>
                        <input type="text" class="form-control" id="desc" name="desc" placeholder="Description" required>
                    </div>

                    <div class="mt-2">
                        <label>Deadline</label>
                        <input type="Datetime-local" class="form-control" id="deadline" name="deadline" required>
                    </div>

                    <div class="d-grid gap-4 d-md-flex justify-content-md-start">
                        <input type="file" name="upload_file" class="mt-3" accept=".doc,.docx,.pdf,.zip,.jepg,.png,.jpg,.giff,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
                    </div>
                    <div class="float-right w-100 text-right">
                        <a href="view_assignment.php?id=<?php echo $_GET['id'] ?>" class="btn btn-secondary btn-sm mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Assignments</a>
                        <button type="submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="assignment_submit" id="imp">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var today = new Date().toISOString().slice(0, 16);
        document.getElementsByName("deadline")[0].min = today;
    </script>

    <!-- Connecting Bootstrap -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <!-- Ending Bootstrap -->

</body>

</html>