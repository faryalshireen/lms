<?php
include 'teachernav.php';
include "link.php";
include "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashoard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <script>
        // ToolTip
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <style>
        .card {
            height: 350px;
            margin: 10px 10px 0px 10px;
        }

        .number {
            width: 25px;
            height: 25px;
            border: 0.5px solid rgb(188, 187, 187);
            text-align: center;
            border-radius: 10px;
            font-size: 15px;
        }

        .btn {
            /* border: 2px solid rgb(188, 187, 187); */
            color: rgb(43, 39, 145);
        }

        /* .btn:hover {
        background-color: rgb(134, 198, 247);
        border: none;
    } */
        a {
            color: black;
        }

        a:hover {
            text-decoration: none;
        }

        h2,
        h3 {
            font-size: 22px;
        }

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
            animation-name: colors;
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
    </style>
</head>

<body>

    <?php
    if ($_SESSION['message']) {
        echo $_SESSION['message'];
    }

    ?>

    <!-- updated -->
    <div class="container">
        <div class="row">
            <?php
            $t_name = $_SESSION['name'];
            $t_id = $_SESSION['id'];

            // $sql="SELECT * FROM `assigned_courses` WHERE teacher_id= '{$t_id}'";
            // if($result = mysqli_query($conn, $sql))
            //   if(mysqli_num_rows($result) > 0)
            //     while($row = mysqli_fetch_array($result))
            //   $course_id = $row['course_id'];

            //   $select="SELECT * FROM `teacher_courses` WHERE id= '{$course_id}'";
            $select = "SELECT * FROM `teacher_courses` WHERE section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}'";
            $result2 = mysqli_query($conn, $select);
            while ($row = mysqli_fetch_assoc($result2)) {
                $course = $row['courses_heading'];
                $semester = $row['semesters'];
                $c_description = $row['courses_des'];
                $credit_hour = $row['credit'];
                //  $course_des=$row['courses_des'];
                $id = $row['id'];
                $_SESSION['semester'] = $semester;
            ?>
                <div class="col-md-4">
                    <div class="card text-center ml-0 mr-0" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                        <div class="card-header">SEMESTER:<?php echo $semester ?></div>
                        <div class="card-body">
                            <h5 class="card-title cursor_pointer_arrow" style="font-size:17px" data-bs-toggle="modal" data-bs-target="#userCoursesModal<?php echo $id ?>"><?php echo $course ?></h5>

                            <!-- Modal Users By Courses Starts Here -->
                            <div class="modal fade" id="userCoursesModal<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="userCoursesModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Select User Section - Courses</h5>
                                            <button type="button" class="close close__box_shadow_none" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="teacher_dashboard.php" method="POST">
                                                <div class="mb-2">
                                                    <label class="float-left">Select Section</label>
                                                    <select class="form-control" name="t_usection<?php echo $id ?>" id="t_usection<?php echo $id ?>" required>
                                                        <?php include "db_connect.php";
                                                        $c_t_id = $_SESSION['id'];
                                                        $u_select = "SELECT * FROM `teacher_courses` WHERE id='{$row['id']}' AND (section_a= '{$c_t_id}' OR section_b= '{$c_t_id}' OR section_c= '{$c_t_id}' OR section_d= '{$c_t_id}')";
                                                        $u_sql = mysqli_query($conn, $u_select);
                                                        while ($s_urow = mysqli_fetch_assoc($u_sql)) {
                                                            if ($s_urow['section_a'] == $c_t_id) {
                                                                echo '<option value="a">Section A</option>';
                                                            }
                                                            if ($s_urow['section_b'] == $c_t_id) {
                                                                echo '<option value="b">Section B</option>';
                                                            }
                                                            if ($s_urow['section_c'] == $c_t_id) {
                                                                echo '<option value="c">Section C</option>';
                                                            }
                                                            if ($s_urow['section_d'] == $c_t_id) {
                                                                echo '<option value="d">Section D</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <button type="button" onclick="location.href='course_users.php?id=<?php echo $row['id'] ?>&sec='+document.getElementById('t_usection<?php echo $id ?>').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Go to Users</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Users By Courses End Here -->

                            <p class="card-text"><?php echo substr($c_description, 0, 60) ?>..</p>
                            <a href="view_assignment.php?id=<?php echo $id ?>" class="btn btn-primary btn-sm text-white" data-toggle="tooltip" title="Assignments">
                                <i class="fas fa-fw fa-tasks"></i></a>
                            <a href="announcement.php?id=<?php echo $id ?>" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" title="Announcements">
                                <i class="fas fa-fw fa-bullhorn"></i>
                            </a>
                            <a href="manage_quiz.php?id=<?php echo $id ?>" class="btn btn-secondary btn-sm text-white" data-toggle="tooltip" title="Quiz">
                                <i class="fas fa-fw fa-book"></i>
                            </a>
                            <a href="manage_graded_board.php?id=<?php echo $id ?>" class="btn btn-info btn-sm text-white" data-toggle="tooltip" title="Graded Discussion Board">
                                <i class="fas fa-fw fa-comments"></i>
                            </a>
                            <span data-bs-toggle="modal" data-bs-target="#sectionResultSubmission<?php echo $id ?>">
                                <a class="btn btn-success btn-sm text-white" data-toggle="tooltip" title="Student Result Submission">
                                    <i class="fas fa-fw fa-location-arrow"></i>
                                </a>
                            </span>
                            <!-- Modal Result Section Starts Here -->
                            <div class="modal fade" id="sectionResultSubmission<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="sectionResultSubmissionTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Section Based Result Submission</h5>
                                            <button type="button" class="close close__box_shadow_none" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="teacher_dashboard.php" method="POST">
                                                <div class="mb-2">
                                                    <label class="float-left">Select Section</label>
                                                    <select class="form-control" name="t_section<?php echo $id ?>" id="t_section<?php echo $id ?>" required>
                                                        <?php include "db_connect.php";
                                                        $c_t_id = $_SESSION['id'];
                                                        $select = "SELECT * FROM `teacher_courses` WHERE id='{$row['id']}' AND (section_a= '{$c_t_id}' OR section_b= '{$c_t_id}' OR section_c= '{$c_t_id}' OR section_d= '{$c_t_id}')";
                                                        $sql = mysqli_query($conn, $select);
                                                        while ($s_row = mysqli_fetch_assoc($sql)) {
                                                            if ($s_row['section_a'] == $c_t_id) {
                                                                echo '<option value="a">Section A</option>';
                                                            }
                                                            if ($s_row['section_b'] == $c_t_id) {
                                                                echo '<option value="b">Section B</option>';
                                                            }
                                                            if ($s_row['section_c'] == $c_t_id) {
                                                                echo '<option value="c">Section C</option>';
                                                            }
                                                            if ($s_row['section_d'] == $c_t_id) {
                                                                echo '<option value="d">Section D</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <button type="button" onclick="location.href='teacher_submit_result.php?id=<?php echo $row['id'] ?>&sec='+document.getElementById('t_section<?php echo $id ?>').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Go to Listing</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Result Section End Here -->

                            <span data-bs-toggle="modal" data-bs-target="#sectionResultPendingSubmission<?php echo $id ?>">
                                <a class="btn btn-dark btn-sm text-white" data-toggle="tooltip" title="Student Repeat Result">
                                    <i class="fas fa-fw fa-repeat"></i>
                                </a>
                            </span>
                            <!-- Modal Pending Result Section Starts Here -->
                            <div class="modal fade" id="sectionResultPendingSubmission<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="sectionResultPendingSubmissionTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="sectionResultPendingSubmissionTitle">Section - Repeat Result Submission</h5>
                                            <button type="button" class="close close__box_shadow_none" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="teacher_dashboard.php" method="POST">
                                                <div class="mb-2">
                                                    <label class="float-left">Select Section</label>
                                                    <select class="form-control" name="t_repeat_section<?php echo $id ?>" id="t_repeat_section<?php echo $id ?>" required>
                                                        <?php include "db_connect.php";
                                                        $c_t_id = $_SESSION['id'];
                                                        $select = "SELECT * FROM `teacher_courses` WHERE id='{$row['id']}' AND (section_a= '{$c_t_id}' OR section_b= '{$c_t_id}' OR section_c= '{$c_t_id}' OR section_d= '{$c_t_id}')";
                                                        $sql = mysqli_query($conn, $select);
                                                        while ($s_row = mysqli_fetch_assoc($sql)) {
                                                            if ($s_row['section_a'] == $c_t_id) {
                                                                echo '<option value="a">Section A</option>';
                                                            }
                                                            if ($s_row['section_b'] == $c_t_id) {
                                                                echo '<option value="b">Section B</option>';
                                                            }
                                                            if ($s_row['section_c'] == $c_t_id) {
                                                                echo '<option value="c">Section C</option>';
                                                            }
                                                            if ($s_row['section_d'] == $c_t_id) {
                                                                echo '<option value="d">Section D</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <button type="button" onclick="location.href='teacher_pending_result.php?id=<?php echo $row['id'] ?>&sec='+document.getElementById('t_repeat_section<?php echo $id ?>').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Go to Listing</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Pending Result Section End Here -->

                        </div>
                        <div class="card-footer text-muted">CREDIT HOURS:<?php echo $credit_hour ?></div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <?php
        $f_select = "SELECT * FROM `teacher_courses` WHERE section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}'";
        $f_query = mysqli_query($conn, $f_select);
        if (mysqli_num_rows($f_query) <= 0) {
            echo "<p class='text-center'>No Courses Assigned!</p>";
        }
        ?>
    </div>

</body>

</html>