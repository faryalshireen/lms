<?php //session_start();
include "studentnav.php";
include "link.php";
include "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Student Quiz</title>
  <link rel="stylesheet" href="style3.css">
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>


<body>
  <div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
    <div class="row mt-4">
      <div class="col-md-12">
        <h4 class="text-primary ml-3 pt-2">Student Quiz</h4>
      </div>
    </div>
  </div>
  <div class="container mt-2 mb-5 px-3 py-1 align-center">
    <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pt-3 pb-3">
      <div class="align-center">

        <table class="table text-center" id="quizStdTable">
          <thead>
            <tr>
              <th scope="col">Sr #</th>
              <th scope="col">Title</th>
              <th scope="col">Course</th>
              <!-- <th scope="col">Teacher</th> -->
              <th scope="col">Due Date</th>
              <th scope="col">Duration</th>
              <th scope="col">Total Marks</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $c = 1;
            // Get Current Date
            date_default_timezone_set('Asia/Karachi');
            $q_current_date = date('Y-m-d', strtotime('0 days'));
            $std_currentBatch = date('y');
            // Get Current Semester User Based
            $s_query = "SELECT * FROM `userdata` WHERE user_id= '{$_SESSION['id']}'";
            $s_sql = mysqli_query($conn, $s_query);
            $s_row = mysqli_fetch_array($s_sql);

            if (isset($_GET['id'])) {
              $q_query = "SELECT * FROM `create_quiz` WHERE course_id= '{$_GET['id']}' AND section= '{$_SESSION['user_section']}' AND student_batch='{$std_currentBatch}' AND due_date >= '{$q_current_date}'";
            } else {
              $q_query = "SELECT * FROM `create_quiz` WHERE semester='{$s_row['Semester']}' AND student_batch='{$std_currentBatch}' AND due_date >= '{$q_current_date}' AND section= '{$_SESSION['user_section']}'";
            }
            $q_sql = mysqli_query($conn, $q_query);
            while ($result = mysqli_fetch_array($q_sql)) {
            ?>
              <tr>
                <td><?php echo $c++ ?></td>
                <td><?php echo $result['quiz_title'] ?></td>
                <td>
                  <?php
                  $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$result['course_id']}'";
                  $c_sql = mysqli_query($conn, $c_query);
                  $c_row = mysqli_fetch_array($c_sql);
                  echo $c_row['course_code'];
                  ?>
                </td>
                <td><?php echo $result['due_date'] ?></td>
                <td><?php echo $result['duration'] ?> Mins.</td>
                <td>
                  <?php
                  // $m_query = "SELECT * FROM `student_total_quiz_marks` WHERE `quiz_id` = '{$result['id']}' AND `student_id` = '{$_SESSION['id']}' AND is_posted = 1";
                  // $m_sql = mysqli_query($conn, $m_query);
                  // $m_row = mysqli_fetch_array($m_sql);
                  $select0 = "SELECT * FROM questions WHERE quiz_id = '{$result['id']}'";
                  $result0 = mysqli_query($conn, $select0);
                  $row0 = mysqli_fetch_assoc($result0);
                  $row_totalMarks = mysqli_num_rows($result0);
                  // echo $row_totalMarks;
                  if (isset($row_totalMarks)) {
                    echo $row_totalMarks;
                  } else {
                    echo '<span class="text-danger font-weight-bold">Not Posted</span>';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $btn_select = "SELECT * FROM quiz_details WHERE quiz_id= '{$result['id']}' AND student_id='{$_SESSION['id']}'";
                  $btn_result = mysqli_query($conn, $btn_select);
                  if (mysqli_num_rows($btn_result) > 0) {
                  ?>
                    <button class="btn btn-danger btn-sm disabled" disabled>Already Attempted</button>
                  <?php
                  } else {
                  ?>
                    <a class="btn btn-info btn-sm" href="quiz_student/home.php?quizid=<?php echo $result['id'] ?>">Attempt Quiz</a>
                  <?php
                  }
                  ?>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <?php
        // if (isset($_GET['id'])) {
        //   $f_select = "SELECT * FROM `create_quiz` WHERE course_id= '{$_GET['id']}' AND student_batch='{$std_currentBatch}' AND section= '{$_SESSION['user_section']}' AND due_date >= '{$q_current_date}'";
        // } else {
        //   $f_select = "SELECT * FROM `create_quiz` WHERE due_date >= '{$q_current_date}' AND student_batch='{$std_currentBatch}' AND section= '{$_SESSION['user_section']}'";
        // }
        // $f_query = mysqli_query($conn, $f_select);
        // if (mysqli_num_rows($f_query) <= 0) {
        //   echo "<p class='text-center'>No Quiz Found!</p>";
        // }
        ?>
      </div>
    </div>
  </div>
  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#quizStdTable').DataTable();
    });
  </script>

  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>