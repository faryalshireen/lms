<?php
include 'db3.php';
require 'teachernav.php';
?>

<?php
if (isset($_POST['std_publish_marks']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $r_d_teacher_id = $_SESSION['id'];
    $r_d_course_id = $_GET['id'];
    $r_d_total_marks = $_POST['r_std_total_marks'];
    // $r_d_obtain_marks = $_POST['r_std_obtain_marks'] + $_POST['assign_marks'];
    if (isset($_POST['assign_marks']) && !empty($_POST['assign_marks'])) {
        $r_d_obtain_marks = $_POST['r_std_obtain_marks'] + $_POST['assign_marks'];
    } else {
        $r_d_obtain_marks = $_POST['r_std_obtain_marks'];
    }
    $r_d_semester = $_POST['r_std_semester'];
    $r_d_user_id = $_POST['r_std_userId'];
    $r_d_user_section = $_GET['sec'];
    // $r_d_user_batch = $_POST['r_std_userBatch'];
    $r_d_user_batch = date('y');
    $r_d_isPublished = 0;
    // Current Time
    date_default_timezone_set('Asia/Karachi');
    $r_d_current_date = date('Y-m-d', time());

    if ($r_d_obtain_marks <= $r_d_total_marks) {
        $sql_inserted = "INSERT INTO `course_total_marks` (`user_id`, `section`, `student_batch`, `teacher_id`, `course_id`, `total_marks`, `obtain_marks`, `semester`, `published_time`, `is_published`) VALUES ('$r_d_user_id', '$r_d_user_section', '$r_d_user_batch', '$r_d_teacher_id', '$r_d_course_id', '$r_d_total_marks', '$r_d_obtain_marks', '$r_d_semester', '$r_d_current_date', '$r_d_isPublished')";
        $sql_query = mysqli_query($con, $sql_inserted);
        if ($sql_query) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
         Result Published successfully!
         <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Result Failed to Published, please try later!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
        }
    } else if ($r_d_obtain_marks > $r_d_total_marks) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Your Assign Marks are greater than total!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Something Went Wrong with this request!
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Users By Course</title>
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
                <h4 class="text-primary ml-3 pt-2">Student Result - Submission</h4>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pt-3 pb-3">
            <div class="align-center text-center">
                <table class="table data-table" id="resultSubmissionTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Total Marks</th>
                            <th scope="col">Obtain Marks</th>
                            <th scope="col">Status</th>
                            <th scope="col">Assign Marks</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        // Check Admin Rights Starts Here
                        $p_query = "SELECT * FROM `admin_permissions` WHERE id=1";
                        $p_sql = mysqli_query($con, $p_query);
                        $p_row = mysqli_fetch_array($p_sql);
                        $admin_result_rights = $p_row['permission'];
                        // Admin Rights Ends Here
                        // Sql Query to get Semester Starts Here
                        $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$_GET['id']}'";
                        $c_sql = mysqli_query($con, $c_query);
                        $c_row = mysqli_fetch_array($c_sql);
                        // Sql Query to get Semester Ends Here
                        $user_stdBatch = date('y');
                        // $select = "SELECT * FROM `userdata` WHERE semester='{$c_row['semesters']}' AND section = '{$_GET['sec']}' AND student_batch='{$user_stdBatch}'";
                        // $select = "SELECT * FROM `userdata` WHERE section = '{$_GET['sec']}' AND student_batch='{$user_stdBatch}' AND semester='{$c_row['semesters']}'";
                        $select = "SELECT * FROM `userdata` WHERE section = '{$_GET['sec']}' AND semester='{$c_row['semesters']}'";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                            // Check Results Published
                            $d_c_select = "SELECT * FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND student_batch='{$user_stdBatch}' AND section = '{$_GET['sec']}' AND teacher_id='{$_SESSION['id']}' AND course_id='{$_GET['id']}'";
                            $d_c_query = mysqli_query($con, $d_c_select);
                            $d_c_row = mysqli_fetch_array($d_c_query);
                            // Result Published Ends Here
                        ?>
                            <tr>
                                <td><?php echo $c++ ?></td>
                                <td>
                                    <?php
                                    $user_query = "SELECT * FROM `users` WHERE id= '{$result['user_id']}'";
                                    $user_sql = mysqli_query($con, $user_query);
                                    $user_row = mysqli_fetch_array($user_sql);
                                    echo $user_row['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $total_get_quiz_sum = 0;
                                    // Get Total Assignment Result
                                    $t_assign_query = "SELECT SUM(total_marks) AS value_sum FROM `upload` WHERE course_id= '{$_GET['id']}' AND section='{$_GET['sec']}' AND student_batch='{$user_stdBatch}'";
                                    $t_assign_sql = mysqli_query($con, $t_assign_query);
                                    $t_assign_row = mysqli_fetch_assoc($t_assign_sql);
                                    $total_get_semester = $t_assign_row['value_sum'];
                                    // Get Total Quiz Result
                                    $t_assign_query = "SELECT * FROM `total_quiz_marks` WHERE course_id= '{$_GET['id']}' AND section='{$_GET['sec']}' AND student_batch='{$user_stdBatch}' GROUP BY quiz_id";
                                    $t_assign_sql = mysqli_query($con, $t_assign_query);
                                    // $t_assign_row = mysqli_fetch_assoc($t_assign_sql);
                                    // $total_get_quiz = $t_assign_row['value_sum'];
                                    while ($sql_qresult = mysqli_fetch_array($t_assign_sql)) {
                                        $total_get_quiz_sum += $sql_qresult['total_marks'];
                                    }
                                    if (!empty($total_get_quiz_sum)) {
                                        $total_get_quiz = $total_get_quiz_sum;
                                    } else {
                                        $query1 = "SELECT * FROM questions WHERE course_id = '{$_GET['id']}' AND student_batch='{$user_stdBatch}' AND section='{$_GET['sec']}'";
                                        $run1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
                                        // $total1 = mysqli_fetch_assoc($run1);
                                        $questionno = mysqli_num_rows($run1);
                                        $total_get_quiz = $questionno * 1;
                                    }
                                    // Get Total GDB Result
                                    $t_assign_query = "SELECT SUM(total_marks) AS value_sum FROM `discussion_question` WHERE course_id= '{$_GET['id']}' AND section='{$_GET['sec']}' AND student_batch='{$user_stdBatch}'";
                                    $t_assign_sql = mysqli_query($con, $t_assign_query);
                                    $t_assign_row = mysqli_fetch_assoc($t_assign_sql);
                                    $total_get_gdbs = $t_assign_row['value_sum'];
                                    // Total Calculated Sum Marks
                                    // echo $total_get_semester.'=========='.$total_get_quiz.'========='.$total_get_gdbs;
                                    $user_calculated_totalMarks = $total_get_semester + $total_get_quiz + $total_get_gdbs;
                                    if (mysqli_num_rows($d_c_query) >= 1) {
                                        echo $d_c_row['total_marks'];
                                    } else {
                                        if (!empty($user_calculated_totalMarks)) {
                                            echo $user_calculated_totalMarks;
                                        } else {
                                            echo 0;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // Get Obtained Assignment Result
                                    $assign_query = "SELECT SUM(marks) AS value_sum FROM `marks` WHERE user_id= '{$result['user_id']}' AND Course= '{$_GET['id']}'";
                                    $assign_sql = mysqli_query($con, $assign_query);
                                    $assign_row = mysqli_fetch_assoc($assign_sql);
                                    $a_get_semester = $assign_row['value_sum'];
                                    // Get Obtained Quiz Result
                                    $assign_query = "SELECT SUM(obtain_marks) AS value_sum FROM `total_quiz_marks` WHERE student_id= '{$result['user_id']}' AND course_id= '{$_GET['id']}'";
                                    $assign_sql = mysqli_query($con, $assign_query);
                                    $assign_row = mysqli_fetch_assoc($assign_sql);
                                    $a_get_quiz = $assign_row['value_sum'];
                                    // Get Obtained GDB Result
                                    $assign_query = "SELECT SUM(obtain_marks) AS value_sum FROM `discussion_answers` WHERE student_id= '{$result['user_id']}' AND course_id= '{$_GET['id']}'";
                                    $assign_sql = mysqli_query($con, $assign_query);
                                    $assign_row = mysqli_fetch_assoc($assign_sql);
                                    $a_get_gdb = $assign_row['value_sum'];
                                    //   Total Calculated Obtained Sum
                                    $user_total_obtainedMarks = $a_get_semester + $a_get_quiz + $a_get_gdb;
                                    if (mysqli_num_rows($d_c_query) >= 1) {
                                        echo $d_c_row['obtain_marks'];
                                    } else {
                                        if (!empty($user_total_obtainedMarks)) {
                                            echo $user_total_obtainedMarks;
                                        } else {
                                            echo 0;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($user_total_obtainedMarks) && !empty($user_total_obtainedMarks)) {
                                        $user_obtained_percentage = round(($user_total_obtainedMarks / $user_calculated_totalMarks) * 100);
                                        if (mysqli_num_rows($d_c_query) >= 1) {
                                            if (round(($d_c_row['obtain_marks'] / $d_c_row['total_marks']) * 100) >= 50) {
                                                echo '<span class="badge badge-success">Passed - ' . round(($d_c_row['obtain_marks'] / $d_c_row['total_marks']) * 100) . '%</span>';;
                                            } else {
                                                echo '<span class="badge badge-danger">Failed - ' . round(($d_c_row['obtain_marks'] / $d_c_row['total_marks']) * 100) . '%</span>';;
                                            }
                                        } else {
                                            if ($user_obtained_percentage >= 50) {
                                                echo '<span class="badge badge-success">Passed - ' . $user_obtained_percentage . '%</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Failed - ' . $user_obtained_percentage . '%</span>';
                                            }
                                        }
                                    } else {
                                        echo '<span class="badge badge-danger">Not Attempted</span>';
                                    }
                                    ?>
                                </td>
                                <form action="teacher_submit_result.php?id=<?php echo $_GET['id'] ?>&sec=<?php echo $_GET['sec'] ?>" method="POST">
                                    <td>
                                        <input type="hidden" class="hidden" id="r_std_total_marks" name="r_std_total_marks" value="<?php echo $user_calculated_totalMarks ?>">
                                        <input type="hidden" class="hidden" id="r_std_obtain_marks" name="r_std_obtain_marks" value="<?php echo $user_total_obtainedMarks ?>">
                                        <input type="hidden" class="hidden" id="r_std_semester" name="r_std_semester" value="<?php echo $c_row['semesters'] ?>">
                                        <input type="hidden" class="hidden" id="r_std_userId" name="r_std_userId" value="<?php echo $result['user_id'] ?>">
                                        <input type="hidden" class="hidden" id="r_std_userBatch" name="r_std_userBatch" value="<?php echo $result['student_batch'] ?>">
                                        <?php
                                        if (isset($admin_result_rights) && $admin_result_rights == 0) {
                                            echo '<input type="number" class="form-control form-control-sm disabled" disabled placeholder="Assign Additional Marks">';
                                        } else {
                                            if (mysqli_num_rows($d_c_query) >= 1) {
                                                echo '<input type="number" class="form-control form-control-sm disabled" disabled placeholder="Assign Additional Marks">';
                                            } else {
                                                echo '<input type="number" class="form-control form-control-sm" value="0" placeholder="Assign Additional Marks" name="assign_marks" id="assign_marks">';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php

                                        if (isset($admin_result_rights) && $admin_result_rights == 0) {
                                        ?>
                                            <!-- <button type="submit" class="btn btn-danger btn-sm" disabled style="padding: 5px 10px;">X</button> -->
                                            <button type="submit" class="btn btn-success btn-sm" disabled style="padding: 5px 10px;">Submit</button>
                                            <?php
                                        } else {
                                            if (mysqli_num_rows($d_c_query) >= 1) {
                                            ?>
                                                <!-- <button type="submit" class="btn btn-danger btn-sm" disabled style="padding: 5px 10px;">X</button> -->
                                                <button type="submit" class="btn btn-success btn-sm" disabled style="padding: 5px 10px;">Submit</button>
                                            <?php
                                            } else {
                                            ?>
                                                <!-- <button type="submit" data-toggle="tooltip" title="Fail Student" class="btn btn-danger btn-sm" name="std_publish_marks" value="Fail" style="padding: 5px 10px;"><i class="fas fa-times"></i></button> -->
                                                <button type="submit" class="btn btn-success btn-sm" name="std_publish_marks" style="padding: 5px 10px;">Submit</button>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </form>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        // Datatable
        $(document).ready(function() {
            $('#resultSubmissionTable').DataTable();
        });
        // tooltip
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>