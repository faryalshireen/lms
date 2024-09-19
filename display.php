<?php
$isSaveDisabled = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Submit Assignment</title>
</head>

<body>

  <?php require 'studentnav.php'; ?>

  <?php
  include 'db3.php';
  if (isset($_POST['assignment_submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $c_select = "SELECT * FROM `assignments` WHERE user_id= '{$_SESSION['id']}' AND assignment_id='{$_POST['std_assignmentId']}' AND section='{$_SESSION['user_section']}'";
    $c_query = mysqli_query($con, $c_select);
    date_default_timezone_set('Asia/Karachi');
    $current_date = date('Y-m-d H:i:s', time());
    if (mysqli_num_rows($c_query) > 0) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Assignment Already Submitted!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    } else if (strtotime($_POST['c_assignment_deadline']) <= strtotime($current_date)) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Assignment failed to submit, Timeout!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    } else {
      // $isSaveDisabled = true;
      $filename = $_FILES['upload_file']['name'];
      $filepath = $_FILES['upload_file']['tmp_name'];
      $fileerror = $_FILES['upload_file']['error'];
      $filesize = $_FILES['upload_file']['size'];

      // $a_subject = $_POST["std_subject"];
      // $a_task = $_POST['std_task_details'];
      // $total_marks = $_POST['std_total_marks'];
      $c_user_id = $_SESSION['id'];
      $a_teacher_id = $_POST['std_teacherId'];
      $a_assignment_id = $_POST['std_assignmentId'];
      $a_u_sectionId = $_SESSION['user_section'];
      // $a_course_id = $_POST["std_course_id"];
      date_default_timezone_set('Asia/Karachi');
      $a_date = date('Y-m-d H:i:s', time());

      if (isset($_GET['repeat'])) {
        $st_c_isRepeat = 1;
      } else {
        $st_c_isRepeat = 0;
      }

      $user_stdBatch = date('y');
      $desfile = $filename;
      move_uploaded_file($filepath, $desfile);
      $sql = "INSERT INTO `assignments` (`user_id`, `section`, `student_batch`, `assignment_id`, `teacher_id`,`date`, `isChecked`,file, `is_repeat`) VALUES ('$c_user_id', '$a_u_sectionId', '$user_stdBatch', '$a_assignment_id', '$a_teacher_id','$a_date', 0, '$desfile', '$st_c_isRepeat')";
      $query2 = mysqli_query($con, $sql);
      if ($query2) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Assignment Submitted Successfully!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
  ?>
        <!-- <script>
          setTimeout(() => {
            window.location = `userdashboard.php`;
          }, 2000);
        </script> -->
  <?php
      } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Not submitted!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      }
    }
  }
  ?>

  <div class="container col-lg-12 col-md-12 col-sm-12">
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-primary pl-2 pt-2">My Assignments</h4>
      </div>
    </div>
  </div>

  <div class="container mb-3">
    <div class="row">
      <?php include 'db3.php';
      $s_query = "SELECT * FROM `userdata` WHERE user_id= '{$_SESSION['id']}'";
      $s_sql = mysqli_query($con, $s_query);
      $s_row = mysqli_fetch_array($s_sql);
      $semesterId = $s_row['Semester'];

      date_default_timezone_set('Asia/Karachi');
      $p_current_date = date('Y-m-d H:i:s', time());


      if (isset($_GET['id'])) {
        $c_id = $_GET['id'];
        // $select = "SELECT * FROM `upload` WHERE Semester='{$semesterId}' AND course_id='{$c_id}' AND section= '{$_SESSION['user_section']}' AND deadline >= '{$p_current_date}'";
        $select = "SELECT * FROM `upload` WHERE course_id='{$c_id}' AND section= '{$_SESSION['user_section']}' AND deadline >= '{$p_current_date}'";
      } else {
        $select = "SELECT * FROM `upload` WHERE Semester='{$semesterId}' AND section= '{$_SESSION['user_section']}' AND deadline >= '{$p_current_date}'";
      }
      $query = mysqli_query($con, $select);
      while ($result = mysqli_fetch_array($query)) {
        $abc = $result['title'];
        // $std_course_id = $result['course_id'];
        $std_total_marks = $result['total_marks'];
        // $std_subject = $result['title'];
        $std_task_details = $result['description'];
        $std_assignmentId = $result['id'];
        $std_teacherId = $result['teacher_id'];
        $dl = $result['deadline'];
        $c_assignment_deadline = $result['deadline'];
        $fil = $result['file'];
        date_default_timezone_set('Asia/Karachi');
        $date1 = date('d-m-y h:i:s');
        if ($dl > $date1) {
          $isSaveDisabled = false;
        } else {
          $isSaveDisabled = true;
        }
      ?>
        <div class="col-md-6">
          <div class="card mt-2 mb-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
            <form action="display.php" method="POST" enctype="multipart/form-data">
              <h5 class="card-header bg-primary font-weight-bold text-white">
                <?php include "db_connect.php";
                $sem_query = "SELECT * FROM `teacher_courses` WHERE id= '{$result['course_id']}'";
                $sem_sql = mysqli_query($conn, $sem_query);
                $sem_row = mysqli_fetch_array($sem_sql);
                $sem_no = $sem_row['courses_heading'];
                echo $sem_no;
                ?>
              </h5>
              <div class="card-body">
                <input type="hidden" class="hidden" id="std_assignmentId" name="std_assignmentId" value=" <?php echo $std_assignmentId ?>">
                <input type="hidden" class="hidden" id="std_teacherId" name="std_teacherId" value=" <?php echo $std_teacherId ?>">
                <input type="hidden" class="hidden" id="c_assignment_deadline" name="c_assignment_deadline" value=" <?php echo $c_assignment_deadline ?>">
                <h5 class="card-title" style="color:black;"> <?php echo "Topic : " . $abc ?></h5>
                <p class="card-text mb-1" style="color:black;"> <?php echo "Instructions : " . $std_task_details ?></p>
                <p class="card-text mb-1" style="color:black;"> <?php echo "Deadline : " . $dl ?></p>
                <p class="card-text mb-3" style="color:black;"> <?php echo "Total Marks : " . $std_total_marks ?></p>
                <a target="_blank" href="download.php?file=<?php echo $fil ?>">Download Assignment</br></a>

                <input type="file" name="upload_file" class="mt-2" accept=".doc,.docx,.pdf,.zip,.jepg,.png,.jpg,.giff,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
                <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                  <?php
                  if (isset($_GET['id']) && !isset($_GET['repeat'])) {
                  ?>
                    <button type="submit" formaction="display.php?id=<?php echo $_GET['id'] ?>" class="btn btn-primary mt-3" name="assignment_submit">Submit</button>
                  <?php
                  } else if (isset($_GET['repeat'])) {
                  ?>
                    <button type="submit" formaction="display.php?id=<?php echo $_GET['id'] ?>&repeat=1" class="btn btn-primary btn-sm mt-3 font-weight-bold" name="assignment_submit">Submit Assignment</button>
                  <?php
                  } else {
                  ?>
                    <button type="submit" formaction="display.php" class="btn btn-primary btn-sm mt-3 font-weight-bold" name="assignment_submit">Submit Assignment</button>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      <?php
      }
      $t_id = $_SESSION['id'];
      if (isset($_GET['id'])) {
        $c_id = $_GET['id'];
        // $f_select = "SELECT * FROM `upload` WHERE Semester='{$semesterId}' AND section= '{$_SESSION['user_section']}' AND course_id='{$c_id}' AND deadline >= '{$p_current_date}'";
        $f_select = "SELECT * FROM `upload` WHERE section= '{$_SESSION['user_section']}' AND course_id='{$c_id}' AND deadline >= '{$p_current_date}'";
      } else {
        $f_select = "SELECT * FROM `upload` WHERE Semester='{$semesterId}' AND section= '{$_SESSION['user_section']}' AND deadline >= '{$p_current_date}'";
      }
      $f_query = mysqli_query($con, $f_select);
      if (mysqli_num_rows($f_query) <= 0) {
        echo '<div class="alert alert-danger alert-dismissible col-md-12 fade show" role="alert">
          No Assignments Found!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
      }
      ?>
    </div>
  </div>


  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

</body>

</html>