<?php
include 'db3.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>User Dashoard</title>
    <style>
        .card.text-center {
            height: 270px;
            margin-bottom: 18px;
        }

        .card-header {
            background-color: lightsteelblue !important;
            color: #ffff;
            font-size: 21px;
            font-weight: 700;
        }

        .card-footer.text-muted {
            background-color: lightsteelblue;
            color: white !important;
            font-weight: 700;

        }

        h5.card-title {
            font-size: 19.5px;
            font-style: inherit;
            font-weight: 700;
        }

        .item1 {
            /* animation-name: colors; */
            animation-duration: 15s;
        }

        @keyframes colors {
            0% {
                color: white;
            }

            25% {
                color: Grey;
            }

            50% {
                color: blue;
            }

            100% {
                color: pink;
            }
        }

        .a__notification_icon {
            position: absolute !important;
            top: -13px !important;
            background: #ff0000 !important;
            padding: 5px 8px !important;
            border-radius: 50% !important;
            z-index: 100 !important;
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include 'studentnav.php';
    ?>
    <!-- <script>
       $(document).ready(function(){
        setInterval(function(){
        $("#show").load("userdashboard.php");
        },0);
        });
    </script> -->
    <p id="show"></p>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $std_id = $_SESSION['id'];
                $p_select = "SELECT * FROM `userdata` WHERE user_id= '{$std_id}'";
                $p_query = mysqli_query($con, $p_select);
                $p_row = mysqli_fetch_array($p_query);
                if (!isset($p_row['Gender']) || !isset($p_row['First']) || !isset($p_row['Last']) || !isset($p_row['CNIC']) || !isset($p_row['DOB']) || !isset($p_row['Mobile']) || !isset($p_row['Province']) || !isset($p_row['Postal Code']) || !isset($p_row['Address']) || !isset($p_row['City']) || !isset($p_row['Seat']) || !isset($p_row['Semester'])) {
                    echo '<div class="alert alert-danger alert-dismissible col-md-12 fade show" role="alert">
                    Please Complete Your Profile Information! <a href="profile.php" class="pl-1">Update Profile</a>
                    <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                    $_SESSION['user_profile_status'] = 0;
                } else {
                    $_SESSION['user_profile_status'] = 1;
                }
                ?>
                <div class="row">
                    <?php
                    $s_id = $_SESSION['id'];
                    $select = "SELECT * FROM userdata WHERE user_id = $s_id";
                    $result = mysqli_query($con, $select);
                    $row = mysqli_fetch_array($result);
                    $semester = $row['Semester'];


                    // Get Failed Courses & Current Courses (Regular) Starts Here
                    $cu_query = "SELECT * FROM `userdata` WHERE user_id= '{$_SESSION['id']}'";
                    $cu_sql = mysqli_query($conn, $cu_query);
                    $cu_row = mysqli_fetch_array($cu_sql);
                    // echo $cu_row['Semester'];
                    $user_stdBatch = date('y') - 1;

                    // $f_query = "SELECT * FROM `course_total_marks` WHERE section='{$_SESSION['user_section']}' AND student_batch='{$_SESSION['user_batch']}' 
                    $f_query = "SELECT * FROM `course_total_marks` WHERE section='{$_SESSION['user_section']}' AND student_batch='{$user_stdBatch}' 
                    AND ((obtain_marks / total_marks * 100) < 50) AND user_id='{$_SESSION['id']}' AND is_published=1";
                    $f_sql = mysqli_query($conn, $f_query);
                    $u_pendingCourses_arr = array();

                    while ($f_result = mysqli_fetch_array($f_sql)) {
                        if (($f_result['semester'] + 2) == $cu_row['Semester']) {
                            $u_pendingCourses_arr[] = $f_result['course_id'];
                        } else if (($f_result['semester'] + 4) == $cu_row['Semester']) {
                            $u_pendingCourses_arr[] = $f_result['course_id'];
                        } else if (($f_result['semester'] + 6) == $cu_row['Semester']) {
                            $u_pendingCourses_arr[] = $f_result['course_id'];
                        }
                    }
                    $u_implode_jointQuery = implode(',', $u_pendingCourses_arr);
                    if (sizeof($u_pendingCourses_arr) >= 1) {
                        $select2 = "SELECT * FROM teacher_courses WHERE semesters = $semester OR id IN ({$u_implode_jointQuery}) ORDER BY semesters DESC";
                    } else {
                        $select2 = "SELECT * FROM teacher_courses WHERE semesters = $semester ORDER BY semesters DESC";
                    }
                    // Get Failed Courses & Current Courses (Regular) Ends Here


                    $result2 = mysqli_query($conn, $select2);
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $sid = $row2['id'];
                        $courses = $row2['courses_heading'];
                        $c_teacher_sectionId = "section_{$_SESSION['user_section']}";
                        if (isset($row2[$c_teacher_sectionId])) {
                            $t_query = "SELECT * FROM `users` WHERE id= '{$row2[$c_teacher_sectionId]}'";
                            $t_sql = mysqli_query($conn, $t_query);
                            $t_row = mysqli_fetch_array($t_sql);
                            $teacher_id = $t_row['name'];
                        } else {
                            $teacher_id = "N/A";
                        }
                        $credit = $row2['credit'];
                        $semester = $row2['semesters'];
                        // Announcement Notification Calculated
                        date_default_timezone_set('Asia/Karachi');
                        $u_current_date = date('Y-m-d H:i:s', strtotime('-120 days'));
                        $c_query = "SELECT * FROM `announcements` WHERE course_id= '{$row2['id']}' AND section= '{$_SESSION['user_section']}' AND role_id=2 AND assign_id=3 AND date >= '{$u_current_date}'";
                        $c_sql = mysqli_query($conn, $c_query);
                        $c_courseAnnouncements =  mysqli_num_rows($c_sql);
                        $status_query = "SELECT * FROM `announcement_status` WHERE course_id= '{$row2['id']}' AND section= '{$_SESSION['user_section']}' AND user_id= '{$_SESSION['id']}' AND role_id=3 AND is_read=2";
                        $status_sql = mysqli_query($conn, $status_query);
                        $read_courseAnnouncements =  $c_courseAnnouncements - mysqli_num_rows($status_sql);
                        if ($read_courseAnnouncements > 0) {
                            $total_courseAnnouncements = $read_courseAnnouncements;
                        } else {
                            $total_courseAnnouncements = '';
                        }
                        //   $t_id = $_SESSION['id'];
                        //   $select3="SELECT * FROM assigned_courses WHERE teacher_id='{$t_id}'";
                        //   $result3=mysqli_query($conn,$select3);
                        //   $row3=mysqli_fetch_assoc($result3);
                        //   $techerid=$row3['teacher_id'];
                        //   $select4="SELECT * FROM teachers WHERE id='{$techerid}'";
                        //   $result4=mysqli_query($conn,$select4);
                        //   whi;e
                    ?>
                        <div class="col-md-4">
                            <div class="card text-center" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                                <div class="card-header">SEMESTER:<?php echo $semester ?></div>
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size:18.5px"><?php echo $courses ?></h5>
                                    <?php
                                    if (isset($_SESSION['user_profile_status']) && $_SESSION['user_profile_status'] == 0) {
                                    ?>
                                        <p class="card-text"><?php echo $teacher_id ?></p>
                                        <a href="userdashboard.php" class="btn btn-secondary btn-sm text-white mr-1 disabled" data-toggle="tooltip" title="Assignments">
                                            <i class="fas fa-fw fa-tasks"></i>
                                        </a>
                                        <a href="userdashboard.php" class="btn btn-info btn-sm text-white mr-1 disabled" data-toggle="tooltip" title="Announcements">
                                            <i class="fas fa-fw fa-bullhorn"></i>
                                        </a>
                                        <a href="userdashboard.php" class="btn btn-warning btn-sm text-white mr-1 disabled" data-toggle="tooltip" title="Student Quiz">
                                            <i class="fas fa-fw fa-book"></i>
                                        </a>
                                        <a href="userdashboard.php" class="btn btn-primary btn-sm text-white mr-1 disabled" data-toggle="tooltip" title="Student GDBs">
                                            <i class="fas fa-fw fa-comments"></i>
                                        </a>
                                        <a href="userdashboard.php" class="btn btn-success btn-sm text-white disabled" data-toggle="tooltip" title="Results">
                                            <i class="fas fa-fw fa-location-arrow"></i>
                                        </a>
                                    <?php
                                    } else {
                                    ?>
                                        <p class="card-text"><?php echo $teacher_id ?></p>
                                        <?php
                                        if (isset($row2['semesters']) && $row['Semester'] == $semester) {
                                        ?>
                                            <a href="display.php?id=<?php echo $sid ?>" class="btn btn-secondary btn-sm text-white mr-1" data-toggle="tooltip" title="Assignments">
                                                <i class="fas fa-fw fa-tasks"></i>
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="display.php?id=<?php echo $sid ?>&repeat=1" class="btn btn-secondary btn-sm text-white mr-1" data-toggle="tooltip" title="Assignments">
                                                <i class="fas fa-fw fa-tasks"></i>
                                            </a>
                                        <?php
                                        }
                                        ?>

                                        <a href="student_announcement.php?id=<?php echo $sid ?>" class="btn btn-info btn-sm text-white mr-1" style="position:relative;" data-toggle="tooltip" title="Announcements">
                                            <i class="fas fa-fw fa-bullhorn"><span class="badge badge-danger a__notification_icon"><?php echo $total_courseAnnouncements ?></span></i>
                                        </a>
                                        <a href="quizes.php?id=<?php echo $sid ?>" class="btn btn-warning btn-sm text-white mr-1" data-toggle="tooltip" title="Student Quiz">
                                            <i class="fas fa-fw fa-book"></i>
                                        </a>

                                        <?php
                                        if (isset($row2['semesters']) && $row['Semester'] == $semester) {
                                        ?>
                                            <a href="student_discussion.php?id=<?php echo $sid ?>" class="btn btn-primary btn-sm text-white mr-1" data-toggle="tooltip" title="Student GDBs">
                                                <i class="fas fa-fw fa-comments"></i>
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="student_discussion.php?id=<?php echo $sid ?>&repeat=1" class="btn btn-primary btn-sm text-white mr-1" data-toggle="tooltip" title="Student GDBs">
                                                <i class="fas fa-fw fa-comments"></i>
                                            </a>
                                        <?php
                                        }
                                        ?>

                                        <a href="student_result.php?id=<?php echo $sid ?>" class="btn btn-success btn-sm text-white" data-toggle="tooltip" title="Results">
                                            <i class="fas fa-fw fa-location-arrow"></i>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="card-footer text-muted">CREDIT HOURS:<?php echo $credit ?></div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ToolTip
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

</body>

</html>