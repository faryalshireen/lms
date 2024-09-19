<?php
include 'db3.php';
require 'adminnav.php';
$check_result_status = 0;
?>

<!-- Publish All Results -->
<?php
if (isset($_POST['declare_result_submission']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    // Check Result Available
    $admin_user_stdBatch = date('y');
    $check_select = "SELECT * FROM `course_total_marks` WHERE semester= '{$_GET['id']}' AND student_batch='{$admin_user_stdBatch}' AND is_published=0 AND is_excluded = 0";
    $check_query = mysqli_query($con, $check_select);
    if (mysqli_num_rows($check_query) <= 0) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Result Not Found!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    } else {
        $publish_sql = "UPDATE `course_total_marks` SET `is_published` = 1 WHERE `course_total_marks`.`semester` = '{$_GET['id']}' AND student_batch='{$admin_user_stdBatch}' AND is_excluded = 0 AND is_published=0";
        $p_result = mysqli_query($con, $publish_sql);

        if ($publish_sql) {
            $list_currentSemester = $_GET['id'] + 1;
            $promote_sql = "UPDATE `userdata` SET `Semester` = $list_currentSemester WHERE `userdata`.`Semester` = '{$_GET['id']}'";
            mysqli_query($con, $promote_sql);

            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Students Result Published Successfully!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Student Result Failed to published!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
    }
}
?>

<!-- Exclude Students -->
<?php
if (isset($_POST['std_exclude']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $exclude_userId = $_POST['u_exclude_studendId'];
    $exclude_sql = "UPDATE `course_total_marks` SET `is_excluded` = 1 WHERE `course_total_marks`.`user_id` = '{$exclude_userId}'";
    $e_result = mysqli_query($con, $exclude_sql);
    if ($e_result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Student Excluded Successfully!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Student Failed to exclude, please try again later!
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
    <title>Admin Grade Book</title>
    <!-- <link rel="stylesheet" href="style3.css"> -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container mt-3 col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-primary pl-2 pt-2">Manage Student Grades - Semester <?php echo $_GET['id'] ?></h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-danger btn-sm float-right text-white mt-2 ml-1" href="admin_excluded_students.php">Excluded Students</a>
            </div>
        </div>
    </div>
    <div class="container mb-5 px-3 py-1 align-center">

        <div class="mb-2">
            <?php
            // Users Listing
            // $select_c_sql = "SELECT * FROM `userdata` LEFT JOIN `course_total_marks` ON userdata.user_id=course_total_marks.user_id WHERE userdata.Semester='{$_GET['id']}' ORDER BY userdata.user_id";
            // $f_query = mysqli_query($con, $select_c_sql);
            // echo mysqli_num_rows($f_query);

            // Courses Listing
            // $s_query = "SELECT * FROM `teacher_courses` WHERE semesters= '{$_GET['id']}'";
            // $s_sql = mysqli_query($con, $s_query);
            // while ($result = mysqli_fetch_array($s_sql)) {
            //     echo '<span class="badge badge-info p-1 mr-1 mb-1">' . $result['courses_heading'] . '</span>';
            // }
            ?>
        </div>
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pt-3 pb-3">
            <div class="align-center">
                <table class="table" id="adminGradedTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Total Marks</th>
                            <th scope="col">Obtain Marks</th>
                            <th scope="col" style="width: 25%;">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        if (isset($_GET['id'])) {
                            $semester_id = $_GET['id'];
                        } else {
                            $semester_id = 1;
                        }
                        $user_stdBatch = date('y');
                        // Main SQL Query
                        // $select_sql = "SELECT * FROM `course_total_marks` WHERE semester= '{$semester_id}' AND is_excluded=0 AND is_published=0";
                        // $select_sql = "SELECT * FROM `userdata` LEFT JOIN `course_total_marks` ON userdata.user_id=course_total_marks.user_id WHERE userdata.Semester='{$semester_id}' ORDER BY userdata.user_id";
                        // $select_sql = "SELECT * FROM `userdata` LEFT JOIN `course_total_marks` ON userdata.user_id=course_total_marks.user_id WHERE userdata.Semester='{$semester_id}' AND userdata.student_batch='{$user_stdBatch}' GROUP BY userdata.user_id";
                        // $select_sql = "SELECT * FROM `userdata` LEFT JOIN `course_total_marks` ON userdata.user_id=course_total_marks.user_id WHERE userdata.Semester='{$semester_id}' GROUP BY userdata.user_id";
                        $select_sql = "SELECT * FROM `userdata` LEFT JOIN `course_total_marks` ON userdata.user_id=course_total_marks.user_id AND userdata.Semester=course_total_marks.semester WHERE userdata.Semester='{$semester_id}' GROUP BY userdata.user_id";
                        $query = mysqli_query($con, $select_sql);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo $result['First'] . ' ' . $result['Last'] ?></td>
                                <td>
                                    <?php
                                    $total_query = "SELECT SUM(total_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND semester='{$semester_id}'";
                                    $total_sql = mysqli_query($con, $total_query);
                                    $total_row = mysqli_fetch_assoc($total_sql);
                                    if (isset($total_row['value_sum'])) {
                                        echo $total_row['value_sum'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $t_obtained_query = "SELECT SUM(obtain_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND semester='{$semester_id}'";
                                    $t_obtained_sql = mysqli_query($con, $t_obtained_query);
                                    $t_obtained_row = mysqli_fetch_assoc($t_obtained_sql);
                                    if (isset($t_obtained_row['value_sum'])) {
                                        echo $t_obtained_row['value_sum'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $status_query = "SELECT * FROM `course_total_marks` RIGHT JOIN `teacher_courses` ON course_total_marks.course_id=teacher_courses.id AND course_total_marks.user_id = '{$result['Student_number']}' WHERE teacher_courses.semesters='{$_GET['id']}' ORDER BY teacher_courses.id";
                                    $status_sql = mysqli_query($con, $status_query);
                                    while ($status_result = mysqli_fetch_array($status_sql)) {

                                        if ($status_result['course_id'] == $status_result['id']) {
                                            echo '<span class="badge badge-success cursor_pointer_arrow mr-1" data-toggle="tooltip" title="' . $status_result['courses_heading'] . '">' . $status_result['course_code'] . '</span>';
                                        } else {
                                            if (isset($result['is_excluded']) && $result['is_excluded'] == 0) {
                                                $check_result_status++;
                                            }
                                            // $check_result_status++;
                                            echo '<span class="badge badge-danger cursor_pointer_arrow mr-1" data-toggle="tooltip" title="' . $status_result['courses_heading'] . '">' . $status_result['course_code'] . '</span>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td style="display: inline-flex;">
                                    <button type="button" data-toggle="modal" data-target="#viewTotalSummaryModal<?php echo $c ?>" class="btn btn-primary btn-sm btn-inline text-light mr-1">View</button>
                                    <!-- Modal Starts Here -->
                                    <div class="modal fade" id="viewTotalSummaryModal<?php echo $c ?>" tabindex="-1" role="dialog" aria-labelledby="viewTotalSummaryModalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewTotalSummaryModalTitle">Student Marks Summary</h5>
                                                    <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <td>
                                                                <?php
                                                                if (isset($result['user_id'])) {
                                                                    $c_query = "SELECT * FROM `users` WHERE id= '{$result['user_id']}'";
                                                                } else {
                                                                    $c_query = "SELECT * FROM `users` WHERE id= '{$result['Student_number']}'";
                                                                }
                                                                $c_sql = mysqli_query($con, $c_query);
                                                                $c_row = mysqli_fetch_array($c_sql);
                                                                if (isset($c_row['name'])) {
                                                                    echo $c_row['name'];
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Seat #</th>
                                                            <td>
                                                                <?php
                                                                if (isset($result['user_id'])) {
                                                                    $userdata_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['user_id']}'";
                                                                } else {
                                                                    $userdata_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['Student_number']}'";
                                                                }
                                                                $userdata_sql = mysqli_query($con, $userdata_query);
                                                                $userdata_row = mysqli_fetch_array($userdata_sql);
                                                                if (isset($userdata_row['Seat'])) {
                                                                    echo $userdata_row['Seat'];
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Section</th>
                                                            <td>
                                                                <?php
                                                                if (isset($result['user_id'])) {
                                                                    $usersec_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['user_id']}'";
                                                                } else {
                                                                    $usersec_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['Student_number']}'";
                                                                }
                                                                $usersec_sql = mysqli_query($con, $usersec_query);
                                                                $usersec_row = mysqli_fetch_array($usersec_sql);
                                                                if (isset($usersec_row['section'])) {
                                                                    echo $usersec_row['section'];
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Semester</th>
                                                            <td>
                                                                <?php
                                                                if (isset($result['user_id'])) {
                                                                    $s_userdata_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['user_id']}'";
                                                                } else {
                                                                    $s_userdata_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['Student_number']}'";
                                                                }
                                                                $s_userdata_sql = mysqli_query($con, $s_userdata_query);
                                                                $s_userdata_row = mysqli_fetch_array($s_userdata_sql);
                                                                if (isset($s_userdata_row['Semester'])) {
                                                                    echo $s_userdata_row['Semester'];
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total Marks</th>
                                                            <td>
                                                                <?php
                                                                // Total Marks
                                                                $m_total_query = "SELECT SUM(total_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND semester='{$semester_id}'";
                                                                $m_total_sql = mysqli_query($con, $m_total_query);
                                                                $m_total_row = mysqli_fetch_assoc($m_total_sql);
                                                                // Obtained Marks
                                                                $m_t_obtained_query = "SELECT SUM(obtain_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND semester='{$semester_id}'";
                                                                $m_t_obtained_sql = mysqli_query($con, $m_t_obtained_query);
                                                                $m_t_obtained_row = mysqli_fetch_assoc($m_t_obtained_sql);
                                                                // Total Marks Calculation
                                                                if (isset($m_total_row['value_sum']) && isset($m_t_obtained_row['value_sum'])) {
                                                                    echo  $m_t_obtained_row['value_sum'] . ' / ' . $m_total_row['value_sum'];
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Percentage</th>
                                                            <td>
                                                                <?php
                                                                if (isset($m_t_obtained_row['value_sum']) && isset($m_total_row['value_sum'])) {
                                                                    echo round(($m_t_obtained_row['value_sum'] / $m_total_row['value_sum']) * 100) . '%';
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $course_sr = 1;
                                                        $crs_query = "SELECT * FROM `teacher_courses` WHERE semesters= '{$_GET['id']}'";
                                                        $crs_sql = mysqli_query($con, $crs_query);
                                                        while ($c_result = mysqli_fetch_array($crs_sql)) {
                                                            // Check Results Published
                                                            // $d_c_select = "SELECT * FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND section = '{$result['section']}' AND teacher_id='{$result['teacher_id']}' AND course_id='{$c_result['id']}'";
                                                            $d_c_select = "SELECT * FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND section = '{$result['section']}' AND course_id='{$c_result['id']}'";
                                                            $d_c_query = mysqli_query($con, $d_c_select);
                                                            $d_c_row = mysqli_fetch_array($d_c_query);
                                                            // Result Published Ends Here
                                                        ?>
                                                            <tr>
                                                                <th><span><?php echo $course_sr++ . '. ' . $c_result['courses_heading'] ?></span></th>
                                                                <td>
                                                                    <?php
                                                                    if (mysqli_num_rows($d_c_query) >= 1) {
                                                                        echo $d_c_row['obtain_marks'];
                                                                    } else {
                                                                        echo '<span class="badge badge-danger">Result Pending</span>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal End Here -->
                                    <form action="admin_grade_book.php?id=<?php echo $_GET['id'] ?>" method="post">
                                        <?php
                                        if (isset($result['id']) && $result['is_excluded'] == 0 && $result['is_published'] == 0 && $result['semester'] == $_GET['id']) {
                                        ?>
                                            <input type="hidden" name="u_exclude_studendId" id="u_exclude_studendId" value="<?php echo $result['user_id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="std_exclude">Exclude</button>
                                        <?php
                                        } else if ($result['is_excluded'] == 1 && $result['semester'] == $_GET['id']) {
                                        ?>
                                            <button type="submit" class="btn btn-danger btn-sm btn-inline text-light" disabled>Excluded</button>
                                        <?php
                                        } else if ($result['is_excluded'] == 0 && $result['is_published'] == 1 && $result['semester'] == $_GET['id']) {
                                        ?>
                                            <button type="submit" class="btn btn-danger btn-sm btn-inline text-light" disabled>Published</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button type="submit" class="btn btn-danger btn-sm btn-inline text-light" disabled>Result Awaiting</button>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        if (isset($_GET['id'])) {
            echo ' <form action="admin_grade_book.php?id=' . $_GET['id'] . '" method="POST" class="mt-2">';
        } else {
            echo ' <form action="admin_grade_book.php" method="POST" class="mt-2">';
        }
        ?>
        <?php
        // Check Published
        $res_select = "SELECT * FROM `course_total_marks` WHERE semester= '{$_GET['id']}' AND student_batch='{$user_stdBatch}' AND is_published=1 AND is_excluded=0";
        $res_query = mysqli_query($con, $res_select);
        if (mysqli_num_rows($res_query) <= 0 && $check_result_status <= 0) {
            echo ' <button type="submit" name="declare_result_submission" class="btn btn-success btn-sm float-left text-white mt-2 pl-3 pr-3">Publish All Students Result</button>';
        } else if ($check_result_status >= 1) {
            echo '<button class="btn btn-success btn-sm float-left text-white mt-2 disabled pl-3 pr-3" disabled>Students Result Awaiting</button>';
        } else {
            echo '<button class="btn btn-success btn-sm float-left text-white mt-2 disabled pl-3 pr-3" disabled>Already Published Result</button>';
        }
        ?>
        </form>
    </div>

    <script>
        // Datatable
        $(document).ready(function() {
            $(' #adminGradedTable').DataTable();
        });
        // tooltip
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>