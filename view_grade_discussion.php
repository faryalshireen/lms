<?php
include 'teachernav.php';
include "link.php";
include "db_connect.php";
include "db3.php";

// On Submit Marks
if (isset($_POST['submit'])) {
  $ans_id = $_POST['aid'];
  $marks = $_POST['marks'];


  if ($marks > $_POST['d_total_marks']) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Assigned marks are greater than total marks!
      <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  } else if ($marks <= $_POST['d_total_marks']) {
    $sql = "UPDATE `discussion_answers` SET `obtain_marks` = $marks WHERE `discussion_answers`.`id` = $ans_id";
    $exe = mysqli_query($conn, $sql);
    if ($exe) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Success, Marks Graded Successfully!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Oppss, Marks Failed to update!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Student Discussion Board</title>
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
        <h4 class="text-primary ml-3 mt-1">Graded Discussion Board - Details</h4>
      </div>
    </div>
  </div>
  <div class="container mt-2 mb-5 px-3 py-1 align-center">
    <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3 pt-3 pb-3">
      <div class="align-center">
        <table class="table data-table" id="myTable">
          <thead>
            <tr>
              <th scope="col">Sr #</th>
              <th scope="col">Name</th>
              <th scope="col">Question</th>
              <th scope="col">Date</th>
              <th scope="col">Answers</th>
              <th scope="col">Assign Marks</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // $query = "SELECT * FROM discussion_question WHERE course_id ='{$_GET['id']}' AND teacher_id= '{$_SESSION['id']}'";
            $c = 1;
            $qid = $_GET['id'];
            $select = "SELECT * FROM discussion_answers WHERE question_id= '{$qid}' ";
            $result = mysqli_query($conn, $select);
            while ($row = mysqli_fetch_assoc($result)) {
              $student_answers = $row['answer'];
              $st_id = $row['student_id'];
              $submit_time = $row['time'];
              $qid = $row['question_id'];
              $cid = $row['course_id'];
              $aid = $row['id'];
              $obtain_marks = $row['obtain_marks'];

              $select1 = "SELECT * FROM userdata WHERE user_id= '{$st_id}'";
              $result1 = mysqli_query($con, $select1);
              $row1 = mysqli_fetch_assoc($result1);
              $firstname = $row1['First'];
              $lastname = $row1['Last'];

              $select2 = "SELECT * FROM discussion_question WHERE id= $qid";
              $result2 = mysqli_query($conn, $select2);
              $row2 = mysqli_fetch_assoc($result2);
              $question = $row2['question'];
            ?>
              <tr>
                <td><?php echo $c++ ?></td>
                <td><?php echo $firstname . $lastname ?></td>
                <td><?php echo $question ?></td>
                <td><?php echo date('Y-m-d', strtotime($submit_time)) ?></td>
                <td>
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#gradeBoardAnswers<?php echo $row['id'] ?>">View Answer</button>
                  <!-- Modal -->
                  <div class="modal fade" id="gradeBoardAnswers<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="gradeBoardAnswersTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Discussion Submitted Answer</h5>
                          <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <?php echo $student_answers ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <form action="view_grade_discussion.php?id=<?php echo $qid ?>" method="post" class="form-inline">
                    <input type="hidden" name="aid" value="<?php echo $aid ?>">
                    <input type="hidden" name="d_total_marks" value="<?php echo $row2['total_marks'] ?>">
                    <?php
                    $c_select = "SELECT * FROM `discussion_answers` WHERE student_id= '{$row['student_id']}' AND question_id='{$row['question_id']}'";
                    $c_query = mysqli_query($con, $c_select);
                    $c_row = mysqli_fetch_array($c_query);
                    if (mysqli_num_rows($c_query) >= 1 && !empty($c_row['obtain_marks'])) {
                    ?>
                      <div class="input-group input-group-sm mb-1">
                        <input type="text" class="form-control" disabled aria-describedby="aasign_std_marks" name="marks" value="<?php echo $obtain_marks ?>">
                        <div class="input-group-prepend">
                          <button type="submit" id="aasign_std_marks" disabled name="submit" class="btn btn-success btn-sm form-control-sm input-group-text close__box_shadow_none">Assign</button>
                        </div>
                      </div>
                    <?php
                    } else {
                    ?>
                      <div class="input-group input-group-sm mb-1">
                        <input type="text" class="form-control" placeholder="Enter Marks" aria-describedby="aasign_std_marks" name="marks" value="<?php echo $obtain_marks ?>">
                        <div class="input-group-prepend">
                          <button type="submit" id="aasign_std_marks" name="submit" class="btn btn-success btn-sm form-control-sm input-group-text close__box_shadow_none">Assign</button>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                  </form>
                  <small>Total Marks:<?php echo $row2['total_marks'] ?></small>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script>
    // Datatable
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>

</body>

</html>