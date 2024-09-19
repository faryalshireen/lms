<?php
include 'db3.php';
require 'studentnav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Student Result</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card pl-4 pr-4">
                        <h4 class="text-primary pb-2 pt-2">My Course Result</h4>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="assignment_result_tab" data-toggle="tab" href="#assignment_result" role="tab" aria-controls="assignment_result" aria-selected="true">Assignment Result</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="quizz_result_tab" data-toggle="tab" href="#quizz_result" role="tab" aria-controls="quizz_result" aria-selected="false">Quiz Result</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="gdb_result_tab" data-toggle="tab" href="#gdb_result" role="tab" aria-controls="gdb_result" aria-selected="false">GDB Result</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="assignment_result" role="tabpanel" aria-labelledby="assignment_result_tab">
                                        <br>
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Sr.</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Course</th>
                                                    <th scope="col">Total Marks</th>
                                                    <th scope="col">Assignment Status</th>
                                                    <th scope="col">Submitted Status</th>
                                                    <th scope="col">Result</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $c = 1;
                                                $a_user_stdBatch = date('y');
                                                // $sql_select = "SELECT * FROM `marks` WHERE user_id='{$_SESSION['id']}' AND student_batch='{$_SESSION['user_batch']}' AND section='{$_SESSION['user_section']}' AND Course='{$_GET['id']}' ";
                                                $sql_select = "SELECT * FROM `marks` WHERE user_id='{$_SESSION['id']}' AND student_batch='{$a_user_stdBatch}' AND section='{$_SESSION['user_section']}' AND Course='{$_GET['id']}' ";
                                                $query = mysqli_query($con, $sql_select);
                                                while ($result = mysqli_fetch_array($query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $c++ ?> </td>
                                                        <td>
                                                            <?php
                                                            $c_query = "SELECT * FROM `upload` WHERE id='{$result['assignment_id']}'";
                                                            $c_sql = mysqli_query($con, $c_query);
                                                            $c_row = mysqli_fetch_array($c_sql);
                                                            echo $c_row['title'];
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $c_query = "SELECT * FROM `teacher_courses` WHERE id='{$result['Course']}'";
                                                            $c_sql = mysqli_query($con, $c_query);
                                                            $c_row = mysqli_fetch_array($c_sql);
                                                            echo $c_row['course_code'];
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // $c_query = "SELECT * FROM `upload` WHERE id='{$result['assignment_id']}' AND section='{$_SESSION['user_section']}' AND student_batch='{$_SESSION['user_batch']}'";
                                                            $c_query = "SELECT * FROM `upload` WHERE id='{$result['assignment_id']}' AND section='{$_SESSION['user_section']}' AND student_batch='{$a_user_stdBatch}'";
                                                            $c_sql = mysqli_query($con, $c_query);
                                                            $c_row = mysqli_fetch_array($c_sql);
                                                            if (isset($c_row['total_marks'])) {
                                                                echo $c_row['total_marks'];
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $date_query = "SELECT * FROM `upload` WHERE id='{$result['assignment_id']}'";
                                                            $d_sql = mysqli_query($con, $date_query);
                                                            $d_row = mysqli_fetch_array($d_sql);
                                                            date_default_timezone_set('Asia/Karachi');
                                                            $s_current_date = date('Y-m-d H:i:s', time());
                                                            if (strtotime($d_row['deadline']) <= strtotime($s_current_date)) {
                                                                echo "<span class='text-danger font-weight-bold'>Closed</span>";
                                                            } else {
                                                                echo "<span class='text-success font-weight-bold'>Open</span>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // $assign_query = "SELECT * FROM `assignments` WHERE assignment_id='{$result['assignment_id']}' AND section='{$_SESSION['user_section']}' AND student_batch='{$_SESSION['user_batch']}' AND user_id='{$_SESSION['id']}'";
                                                            $assign_query = "SELECT * FROM `assignments` WHERE assignment_id='{$result['assignment_id']}' AND section='{$_SESSION['user_section']}' AND student_batch='{$a_user_stdBatch}' AND user_id='{$_SESSION['id']}'";
                                                            $ag_sql = mysqli_query($con, $assign_query);
                                                            if (mysqli_num_rows($ag_sql) <= 0) {
                                                                echo "<span class='text-danger font-weight-bold'>Not Submitted</span>";
                                                            } else {
                                                                echo "<span class='text-success font-weight-bold'>Submitted</span>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $result['marks'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        $f_select = "SELECT * FROM `marks` WHERE user_id='{$_SESSION['id']}' AND student_batch='{$a_user_stdBatch}' AND section='{$_SESSION['user_section']}' AND Course='{$_GET['id']}' ";
                                        $f_query = mysqli_query($con, $f_select);
                                        if (mysqli_num_rows($f_query) <= 0) {
                                            echo "<p class='text-center'>No Results Found!</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="tab-pane fade" id="quizz_result" role="tabpanel" aria-labelledby="quizz_result_tab">
                                        <br>
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Sr.</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Total Marks</th>
                                                    <th scope="col">Quiz Status</th>
                                                    <th scope="col">Submitted Status</th>
                                                    <th scope="col">Result</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $c = 1;
                                                $user_stdBatch = date('y');
                                                // $q_sql = "SELECT * FROM total_quiz_marks WHERE student_id= '{$_SESSION['id']}' AND student_batch='{$_SESSION['user_batch']}' AND course_id= '{$_GET['id']}' AND section='{$_SESSION['user_section']}'";
                                                $q_sql = "SELECT * FROM create_quiz WHERE student_batch='{$user_stdBatch}' AND course_id= '{$_GET['id']}' AND section='{$_SESSION['user_section']}'";
                                                $q_query = mysqli_query($con, $q_sql);
                                                while ($q_result = mysqli_fetch_array($q_query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $c++ ?> </td>
                                                        <td><?php echo $q_result['quiz_title'] ?></td>
                                                        <td>
                                                            <?php
                                                            $qu_query = "SELECT * FROM `total_quiz_marks` WHERE quiz_id= '{$q_result['id']}'";
                                                            $qu_sql = mysqli_query($con, $qu_query);
                                                            $qu_row = mysqli_fetch_array($qu_sql);
                                                            if (isset($qu_row['total_marks'])) {
                                                                echo $qu_row['total_marks'];
                                                            } else {
                                                                $query1 = "SELECT * FROM questions WHERE quiz_id = '{$q_result['id']}'";
                                                                $run1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
                                                                // $total1 = mysqli_fetch_assoc($run1);
                                                                $questionno = mysqli_num_rows($run1);
                                                                echo $questionno * 1;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // Get Current Date
                                                            date_default_timezone_set('Asia/Karachi');
                                                            $quiz_current_date = date('Y-m-d', strtotime('0 days'));
                                                            if (strtotime($q_result['due_date']) < strtotime($quiz_current_date)) {
                                                                echo "<span class='text-danger font-weight-bold'>Closed</span>";
                                                            } else {
                                                                echo "<span class='text-success font-weight-bold'>Open</span>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $res_select = "SELECT * FROM `quiz_details` WHERE student_id= '{$_SESSION['id']}' AND quiz_id= '{$q_result['id']}'";
                                                            $res_query = mysqli_query($con, $res_select);
                                                            if (mysqli_num_rows($res_query) >= 1) {
                                                                echo '<span class="text-success font-weight-bold">Attempted</span>';
                                                            } else {
                                                                echo '<span class="text-danger font-weight-bold">Not Attempted</span>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $tm_query = "SELECT * FROM `total_quiz_marks` WHERE quiz_id= '{$q_result['id']}' AND section='{$_SESSION['user_section']}' AND student_id= '{$_SESSION['id']}'";
                                                            $tm_sql = mysqli_query($con, $tm_query);
                                                            $tm_row = mysqli_fetch_array($tm_sql);
                                                            if (isset($tm_row['obtain_marks'])) {
                                                                echo $tm_row['obtain_marks'];
                                                            } else if (strtotime($q_result['due_date']) >= strtotime($quiz_current_date)) {
                                                                echo '<span class="text-danger font-weight-bold">Pending</span>';
                                                            } else {
                                                                echo 0;
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
                                        // $f_select = "SELECT * FROM total_quiz_marks WHERE student_id= '{$_SESSION['id']}' AND student_batch='{$_SESSION['user_batch']}' AND course_id= '{$_GET['id']}'";
                                        $f_select =  "SELECT * FROM create_quiz WHERE student_batch='{$user_stdBatch}' AND course_id= '{$_GET['id']}' AND section='{$_SESSION['user_section']}'";
                                        $f_query = mysqli_query($con, $f_select);
                                        if (mysqli_num_rows($f_query) <= 0) {
                                            echo "<p class='text-center'>No Results Found!</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="tab-pane fade" id="gdb_result" role="tabpanel" aria-labelledby="gdb_result_tab">
                                        <br>
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Sr.</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Total Marks</th>
                                                    <th scope="col">Submitted Status</th>
                                                    <th scope="col">Discussion Status</th>
                                                    <th scope="col">Result</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $c = 1;
                                                $d_user_stdBatch = date('y');
                                                // Current User Semester
                                                $s_query = "SELECT * FROM `userdata` WHERE user_id= '{$_SESSION['id']}'";
                                                $s_sql = mysqli_query($conn, $s_query);
                                                $s_row = mysqli_fetch_array($s_sql);
                                                $semesterId = $s_row['Semester'];
                                                // Get Current Date
                                                // date_default_timezone_set('Asia/Karachi');
                                                // $u_current_date = date('Y-m-d', strtotime('0 days'));

                                                // $sql_select = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$_SESSION['user_batch']}' AND semester= '{$semesterId}' AND section='{$_SESSION['user_section']}'";
                                                // $sql_select = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$d_user_stdBatch}' AND semester= '{$semesterId}' AND section='{$_SESSION['user_section']}'";
                                                $sql_select = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$d_user_stdBatch}' AND section='{$_SESSION['user_section']}'";
                                                $query = mysqli_query($con, $sql_select);
                                                while ($result = mysqli_fetch_array($query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $c++ ?> </td>
                                                        <td><?php echo $result['question'] ?></td>
                                                        <td><?php echo $result['total_marks'] ?></td>
                                                        <td>
                                                            <?php
                                                            $c_gdb_query = "SELECT * FROM `discussion_answers` WHERE course_id='{$_GET['id']}' AND student_batch='{$d_user_stdBatch}' AND student_id='{$_SESSION['id']}' AND section='{$_SESSION['user_section']}'";
                                                            $c_gdb_sql = mysqli_query($con, $c_gdb_query);
                                                            if (mysqli_num_rows($c_gdb_sql) >= 1) {
                                                                echo '<span class="text-success font-weight-bold">Attempted</span>';
                                                            } else {
                                                                echo '<span class="text-danger font-weight-bold">Not Attempted</span>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // Get Current Date
                                                            date_default_timezone_set('Asia/Karachi');
                                                            $d_current_date = date('Y-m-d', strtotime('0 days'));
                                                            if (strtotime($result['due_date']) < strtotime($d_current_date)) {
                                                                echo "<span class='text-danger font-weight-bold'>Closed</span>";
                                                            } else {
                                                                echo "<span class='text-success font-weight-bold'>Open</span>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // $result_query = "SELECT * FROM `discussion_answers` WHERE course_id='{$_GET['id']}' AND student_batch='{$_SESSION['user_batch']}' AND student_id='{$_SESSION['id']}' AND section='{$_SESSION['user_section']}'";
                                                            // $result_query = "SELECT * FROM `discussion_answers` WHERE course_id='{$_GET['id']}' AND student_batch='{$d_user_stdBatch}' AND student_id='{$_SESSION['id']}' AND section='{$_SESSION['user_section']}'";
                                                            $result_query = "SELECT * FROM `discussion_answers` WHERE course_id='{$_GET['id']}' AND question_id='{$result['id']}' AND student_batch='{$d_user_stdBatch}' AND student_id='{$_SESSION['id']}' AND section='{$_SESSION['user_section']}'";
                                                            $result_sql = mysqli_query($con, $result_query);
                                                            date_default_timezone_set('Asia/Karachi');
                                                            $dc_current_date = date('Y-m-d', strtotime('0 days'));
                                                            if (strtotime($result['due_date']) < strtotime($dc_current_date)) {
                                                                if (mysqli_num_rows($result_sql) <= 0) {
                                                                    echo 0;
                                                                } else {
                                                                    $result_row = mysqli_fetch_array($result_sql);
                                                                    if (isset($result_row['obtain_marks'])) {
                                                                        echo $result_row['obtain_marks'];
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                }
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
                                        // $f_select = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$d_user_stdBatch}' AND semester= '{$semesterId}' AND section='{$_SESSION['user_section']}'";
                                        $f_select = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$d_user_stdBatch}' AND section='{$_SESSION['user_section']}'";
                                        $f_query = mysqli_query($con, $f_select);
                                        if (mysqli_num_rows($f_query) <= 0) {
                                            echo "<p class='text-center'>No Results Found!</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
</body>

</html>