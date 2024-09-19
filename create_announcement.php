<?php
include 'db3.php';
require 'teachernav.php';
?>

<?php
if (isset($_POST['announcement_submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

    $courseId = $_POST["courseId"];
    $u_comments = $_POST["comments"];
    $u_title = $_POST["title"];
    $c_role_id = $_SESSION['role_id'];
    date_default_timezone_set('Asia/Karachi');
    $current_date = date('Y-m-d H:i:s', time());
    $teacherId = $_SESSION['id'];
    $std_sectionId = $_POST["u_section"];
    $assignId = 3;

    // Semester Query Starts Here
    $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$courseId}'";
    $c_sql = mysqli_query($con, $c_query);
    $c_row = mysqli_fetch_array($c_sql);
    $course_semester = $c_row['semesters'];
    // Semester Query Ends Here

    $inserted = "INSERT INTO `announcements` (`role_id`,`date`,`title`,`comments`,`user_id`,`course_id`, `semester`, `assign_id`, `section`) VALUES ('$c_role_id','$current_date','$u_title','$u_comments','$teacherId', '$courseId', '$course_semester', '$assignId', '$std_sectionId')";
    $query = mysqli_query($con, $inserted);
    if ($query) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Your Announcement has been published!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        ?>
        <script>
            setTimeout(() => {
                window.location = `announcement.php`;
            }, 1000);
        </script>
        <?php
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Your Announcement failed to published!
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

    <title>Create Announcement</title>

    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <div class="row">
            <form action="create_announcement.php" method="POST" enctype="multipart/form-data">
                <div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="text-primary mb-3 mt-3">Create Announcement</h4>
                    <div class="mt-2">
                        <label>Announcement Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Programming Concepts" required>
                    </div>
                    <div class="mt-2">
                        <label>Select Course</label>
                        <select class="form-control" name="courseId">
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
                        <label>Comments</label>
                        <textarea class="form-control" rows="5" id="comments" name="comments" placeholder="Details about Announcement" required></textarea>
                    </div>
                    <div class="float-right w-100 text-right">
                        <a href="announcement.php" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Announcement</a>
                        <button type="submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="announcement_submit" id="imp">Publish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Connecting Bootstrap -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>