<?php
include 'db3.php';
require 'teachernav.php';
?>

<?php
include 'db3.php';
if (isset($_POST['std_marks_status']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $std_id = $_POST["res_user_id"];
    $std_course_id = $_POST["res_course_id"];
    $std_teacher_id = $_SESSION['id'];
    $std_marks = $_POST["std_assig_marks"];
    $std_status = $_POST["std_marks_status"];
    $std_assig_id = $_POST["r_table_id"];
    if ($_POST["r_assignment_id"]) {
        $std_assignment_id = $_POST["r_assignment_id"];
    } else {
        $std_assignment_id = $_GET['id'];
    }

    // Time Calculate before submission
    date_default_timezone_set('Asia/Karachi');
    $p_current_date = date('Y-m-d H:i:s', time());

    $asign_query = "SELECT * FROM `upload` WHERE id= '{$std_assignment_id}'";
    $asign_sql = mysqli_query($con, $asign_query);
    $asign_row = mysqli_fetch_array($asign_sql);
    $a_deadline_check = $asign_row['deadline'];
    // Get Semester
    $user_query = "SELECT * FROM `teacher_courses` WHERE id= '{$_POST["res_course_id"]}'";
    $user_sql = mysqli_query($con, $user_query);
    $user_row = mysqli_fetch_array($user_sql);
    $a_get_semester = $user_row['semesters'];

    $t_std_userBatch = $_POST['r_table_userBatch'];
    $t_std_usersection = $_POST['r_table_userSection'];

    if ($_POST["std_assig_marks"] <= $_POST["r_marks"] && strtotime($a_deadline_check) < strtotime($p_current_date)) {
        $sql8 = "INSERT INTO `marks` (`teacher_id`, `user_id`, `marks`, `Course`, `Status`, `assignment_id`, `semester`, `student_batch`, `section`) VALUES ('$std_teacher_id', '$std_id', '$std_marks', '$std_course_id', '$std_status', '$std_assignment_id', '$a_get_semester', '$t_std_userBatch', '$t_std_usersection')";
        $sql_query = mysqli_query($con, $sql8);

        if ($sql_query && isset($_POST["r_table_id"])) {
            $sql_update = "UPDATE `assignments` SET `isChecked` = 1 WHERE id= '{$std_assig_id}'";
            mysqli_query($con, $sql_update);
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
         Marks Updated successfully!
         <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
         Marks Not update, please try later!
         <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>';
        }
    } else if (strtotime($a_deadline_check) > strtotime($p_current_date)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Teacher cannot check until deadline is over!
    <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Marks obtained are greater than total marks!
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
    <title>Check Assignments</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container mt-4">
        <h4 class="text-primary pt-3 pb-2 pl-2">Failed Student - Submitted Assignments</h4>
        <div class="row">
            <div class="col-md-12 mb-5 px-3 py-1 align-center">
                <div class="table-responsive card pt-3 pb-3">
                    <div class="text-center align-center">
                        <table class="table" id="failedStdAssignmentsTable">
                            <thead>
                                <tr>
                                    <th scope="col">Sr.</th>
                                    <th scope="col">User#</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Total Marks</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Obtained</th>
                                    <th scope="col">Fail/Pass</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require 'db3.php';
                                $c = 1;
                                $a_id = $_GET['id'];
                                // $select = "SELECT * FROM `assignments` WHERE teacher_id= '{$_SESSION['id']}' AND isChecked=0 AND assignment_id='{$a_id}'";
                                // SQL Query Get Semester
                                $semester_query = "SELECT * FROM `upload` WHERE id= '{$_GET['id']}'";
                                $semester_sql = mysqli_query($con, $semester_query);
                                $semester_row = mysqli_fetch_array($semester_sql);
                                // Get Section Against Assignment ID Starts Here
                                $t_get_query = "SELECT * FROM `upload` WHERE id= '{$_GET['id']}'";
                                $t_get_sql = mysqli_query($con, $t_get_query);
                                $t_get_row = mysqli_fetch_array($t_get_sql);
                                // Get Section Against Assignment ID Ends Here
                                // userdata.Semester='{$semester_row['Semester']}' AND
                                // SQL Query Main
                                // $select = "SELECT * FROM `userdata` LEFT JOIN `assignments` ON userdata.user_id=assignments.user_id AND assignments.assignment_id='{$_GET['id']}' 
                                // AND assignments.teacher_id= '{$_SESSION['id']}' WHERE userdata.section='{$t_get_row['section']}' 
                                // ORDER BY userdata.user_id";

                                $select = "SELECT * FROM `userdata` RIGHT JOIN `assignments` ON userdata.user_id=assignments.user_id AND assignments.assignment_id='{$_GET['id']}' 
                                AND assignments.teacher_id= '{$_SESSION['id']}' WHERE userdata.section='{$t_get_row['section']}' AND assignments.is_repeat=1 
                                ORDER BY userdata.user_id";


                                $query = mysqli_query($con, $select);
                                while ($user_result = mysqli_fetch_array($query)) {



                                    if (isset($user_result['student_batch'])) {
                                        $std_user_batchId = $user_result['student_batch'];
                                    } else {
                                        $std_user_batchId = $t_get_row['student_batch'];
                                    }



                                    if (isset($user_result['section'])) {
                                        $std_user_sectionId = $user_result['section'];
                                    } else {
                                        $std_user_sectionId = $t_get_row['section'];
                                    }



                                    if (isset($user_result['user_id'])) {
                                        $res_user_id = $user_result['user_id'];
                                    } else {
                                        // SQL Query to get USER ID Starts Here
                                        if (isset($user_result['Seat'])) {
                                            $userdata_query = "SELECT * FROM `userdata` WHERE Seat='{$user_result['Seat']}'";
                                            $userdata_sql = mysqli_query($con, $userdata_query);
                                            $userdata_row = mysqli_fetch_array($userdata_sql);
                                            $res_user_id = $userdata_row['user_id'];
                                        } else {
                                            $res_user_id = "-";
                                        }
                                        // SQL Query to get USER ID Ends Here
                                    }

                                    // SQL Query to disable row marks Starts Here
                                    $marks_query = "SELECT * FROM `marks` WHERE user_id='{$res_user_id}' AND assignment_id='{$_GET['id']}'";
                                    $marks_sql = mysqli_query($con, $marks_query);
                                    $marks_row = mysqli_fetch_array($marks_sql);
                                    if (isset($marks_row['marks'])) {
                                        $check_marks_assignment = 1;
                                    } else {
                                        $check_marks_assignment = 0;
                                    }
                                    // SQL Query to disable row marks Ends Here

                                    // SQL Query to Check marks Starts Here
                                    // $m_query = "SELECT * FROM `marks` WHERE user_id='{$res_user_id}'";
                                    // $m_sql = mysqli_query($con, $m_query);
                                    // $m_row = mysqli_fetch_array($m_sql);
                                    // // echo $m_row['user_id'];
                                    // if (isset($m_row['user_id'])) {
                                    //   $marks_user_id = $m_row['user_id'];
                                    // } else {
                                    //   $marks_user_id = null;
                                    // }
                                    // SQL Query to Check marks Ends Here



                                    $r_assignment_id = $user_result['assignment_id'];
                                    $r_table_id = $user_result['id'];
                                    // SQL Query from Assignment Table
                                    $a_query = "SELECT * FROM `upload` WHERE id='{$_GET['id']}'";
                                    $a_sql = mysqli_query($con, $a_query);
                                    $a_row = mysqli_fetch_array($a_sql);
                                    if (isset($a_row['course_id']) || isset($a_row['total_marks'])) {
                                        $res_course_id = $a_row['course_id'];
                                        $r_marks = $a_row['total_marks'];
                                    }
                                    // SQL Query from Assignment Table Ends Here
                                    // $u_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['user_id']}'";
                                    // $u_sql = mysqli_query($con, $u_query);
                                    // $u_row = mysqli_fetch_array($u_sql);
                                    // $r_user_id = $u_row['Seat'];
                                    // $dat = $result['date'];
                                ?>
                                    <tr>
                                        <td><?php echo $c++ ?> </td>
                                        <td><?php echo $user_result['Seat'] ?> </td>
                                        <td><?php include "db_connect.php";
                                            if ($user_result['assignment_id']) {
                                                $c_query = "SELECT * FROM `upload` WHERE id= '{$user_result['assignment_id']}'";
                                                $c_sql = mysqli_query($con, $c_query);
                                                $c_row = mysqli_fetch_array($c_sql);
                                                $t_query = "SELECT * FROM `teacher_courses` WHERE id= '{$c_row['course_id']}'";
                                                $t_sql = mysqli_query($con, $t_query);
                                                $t_row = mysqli_fetch_array($t_sql);
                                                echo $t_row['course_code'];
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($user_result['date']) {
                                                echo date_format(date_create($user_result['date']), "d-m-Y H:i");
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($user_result['assignment_id'] == $_GET['id'] && $user_result['isChecked'] == 0 && $check_marks_assignment == 0) {
                                            ?><span class="badge badge-info">Submitted</span>
                                            <?php
                                            } else if ($user_result['isChecked'] == 1 || $check_marks_assignment == 1) {
                                            ?><span class="badge badge-success">Checked</span>
                                            <?php
                                            } else {
                                            ?><span class="badge badge-danger">Pending</span>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($user_result['assignment_id']) {
                                                $upload_query = "SELECT * FROM `upload` WHERE id= '{$a_id}'";
                                                $upload_sql = mysqli_query($con, $upload_query);
                                                $upload_row = mysqli_fetch_array($upload_sql);
                                                echo $upload_row['total_marks'];
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($user_result['file'] && $user_result['isChecked'] == 0 && $check_marks_assignment == 0) {
                                            ?><a target="_blank" href="download.php?file=<?php echo $user_result['file'] ?>">Download </a>
                                            <?php
                                            } else if ($user_result['isChecked'] == 1 || $check_marks_assignment == 1) {
                                                echo 'N/A';
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <form action="submit_failed_assignments.php" method="POST" enctype="multipart/form-data">
                                            <td>
                                                <input type="hidden" class="hidden" id="res_user_id" name="res_user_id" value="<?php echo $res_user_id ?>">
                                                <input type="hidden" class="hidden" id="r_marks" name="r_marks" value=" <?php echo $r_marks ?>">
                                                <input type="hidden" class="hidden" id="res_course_id" name="res_course_id" value="<?php echo $res_course_id ?>">
                                                <input type="hidden" class="hidden" id="r_assignment_id" name="r_assignment_id" value="<?php echo $r_assignment_id ?>">
                                                <input type="hidden" class="hidden" id="r_table_id" name="r_table_id" value="<?php echo $r_table_id ?>">
                                                <input type="hidden" class="hidden" id="r_table_userBatch" name="r_table_userBatch" value="<?php echo $std_user_batchId ?>">
                                                <input type="hidden" class="hidden" id="r_table_userSection" name="r_table_userSection" value="<?php echo $std_user_sectionId ?>">
                                                <?php
                                                if ($user_result['isChecked'] == 1 || $check_marks_assignment == 1) {
                                                ?>
                                                    <input type="number" class="form-control text-center" placeholder="Marks" readonly required>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="number" class="form-control text-center" placeholder="Marks" name="std_assig_marks" required>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($user_result['isChecked'] == 1 || $check_marks_assignment == 1) {
                                                ?>
                                                    <button type="submit" class="btn btn-danger btn-sm" disabled style="padding: 5px 10px;">X</button>
                                                    <button type="submit" class="btn btn-success btn-sm" disabled style="padding: 5px 10px;">✓</button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button type="submit" formaction="submit_failed_assignments.php?id=<?php echo $_GET['id'] ?>" data-toggle="tooltip" title="Fail Student" class="btn btn-danger btn-sm" name="std_marks_status" value="Fail" style="padding: 5px 10px;"><i class="fas fa-times"></i></button>
                                                    <button type="submit" formaction="submit_failed_assignments.php?id=<?php echo $_GET['id'] ?>" data-toggle="tooltip" title="Pass Student" class="btn btn-success btn-sm" name="std_marks_status" value="Pass" style="padding: 5px 10px;"><i class="fas fa-check"></i></button>
                                                <?php
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
                        <?php
                        // $assig_id = $_GET['id'];
                        // // $f_select = "SELECT * FROM `assignments` WHERE teacher_id= '{$_SESSION['id']}' AND isChecked=0 AND assignment_id='{$assig_id}'";
                        // $f_select = "SELECT * FROM `userdata` LEFT JOIN `assignments` ON userdata.user_id=assignments.user_id AND assignments.assignment_id='{$_GET['id']}' WHERE userdata.Semester='{$semester_row['Semester']}' ORDER BY userdata.user_id";
                        // $f_query = mysqli_query($con, $f_select);
                        // if (mysqli_num_rows($f_query) <= 0) {
                        //     echo "<p class='text-center'>No Records Found!</p>";
                        // }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // tooltip
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Datatable
        $(document).ready(function() {
            $('#failedStdAssignmentsTable').DataTable();
        });
    </script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>