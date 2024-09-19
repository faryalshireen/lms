<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['id'])) {
    header("location:login.php?error=Please login user account!");
}
?>
<?php
// Session timeout
if (time() - $_SESSION['timestamp'] > 300 && isset($_SESSION['id'])) {
    echo "<script>alert('15 Minutes over!');</script>";
    unset($_SESSION['username'], $_SESSION['id'], $_SESSION['name'], $_SESSION['role_id'], $_SESSION['email']);
    session_start();
    session_unset();
    session_destroy();
    header("location:login.php?error=Session timeout!");
    exit;
} else {
    $_SESSION['timestamp'] = time();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Custom fonts for this template-->
    <link href="assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/common.css">
    <!-- Custom Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <style>
        .a__teachernav_notification_icon {
            position: absolute !important;
            top: -15px !important;
            left: 11px !important;
            background: #ff0000 !important;
            padding: 4px 7px 3px 6px !important;
            border-radius: 50% !important;
            z-index: 100 !important;
            font-size: 9px !important;
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:black">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="teacher_dashboard.php">

                <div class="sidebar-brand-text mx-3">
                    <h2><?php echo $_SESSION['username'] ?></h2>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="teacher_dashboard.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Class Work
            </div>
            <!-- <li class="nav-item">
                <a class="nav-link" href="upload_assignments.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Create Assignment</span></a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" data-toggle="modal" data-target="#addCourseBasedAssignments">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Assignments</span></a>
            </li>

            <!-- Modal Add Course in Assignments Listing Starts Here -->
            <div class="modal fade" id="addCourseBasedAssignments" tabindex="-1" role="dialog" aria-labelledby="addCourseBasedAssignmentsTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCourseBasedAssignmentsTitle">Course Based Assignments</h5>
                            <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="view_assignment.php" method="POST">
                                <div class="mb-2">
                                    <label>Select Course</label>
                                    <select class="form-control" name="t_course_assignments_selection" id="t_course_assignments_selection">
                                        <?php
                                        $t_id = $_SESSION['id'];
                                        $select = "SELECT * FROM `teacher_courses` WHERE section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}'";
                                        $sql = mysqli_query($conn, $select);
                                        while ($row = mysqli_fetch_assoc($sql)) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <button type="button" onclick="location.href='view_assignment.php?id='+document.getElementById('t_course_assignments_selection').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Go to Assignments</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Add Course in Assignments Listing End Here -->

            <?php
            include "db_connect.php";
            // Announcement Notification Calculated
            date_default_timezone_set('Asia/Karachi');
            $u_current_date = date('Y-m-d H:i:s', strtotime('-120 days'));
            $c_query = "SELECT * FROM `announcements` WHERE role_id=1 AND assign_id=2 AND date >= '{$u_current_date}'";
            $c_sql = mysqli_query($conn, $c_query);
            $c_courseAnnouncements =  mysqli_num_rows($c_sql);
            $status_query = "SELECT * FROM `announcement_status` WHERE user_id='{$_SESSION['id']}' AND role_id=2 AND is_read=1 AND course_id = 0";
            $status_sql = mysqli_query($conn, $status_query);
            $read_courseAnnouncements =  $c_courseAnnouncements - mysqli_num_rows($status_sql);
            if ($read_courseAnnouncements > 0) {
                $total_courseAnnouncements = $read_courseAnnouncements;
                $total_courseAnnouncements = '<span class="badge badge-danger a__teachernav_notification_icon">' . $total_courseAnnouncements . '</span>';
            } else {
                $total_courseAnnouncements = '<span></span>';
            }
            // echo $total_courseAnnouncements;
            ?>
            <li class="nav-item">
                <a class="nav-link" href="teacher_announcement.php">
                    <i class="fas fa-fw fa-bullhorn" style="position:relative;">
                        <?php echo $total_courseAnnouncements ?>
                    </i>
                    <span>Announcements</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_quiz.php">
                    <i class="fas fa-fw fas fa-list-alt"></i>
                    <span>Manage Quizzes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_graded_board.php">
                    <i class="fas fa-fw fas fa-list-alt"></i>
                    <span>Manage GDB's</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="courses_schema.php">
                    <i class="fas fa-fw fas fa-user-graduate"></i>
                    <span>Courses Schema</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="quiz_results.php">
                    <i class="fas fa-fw fa-list-alt"></i>
                    <span>Quiz Results</span></a>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link" href="submit_assignments.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Student Assignments</span></a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="http://localhost/final_project_lms/quiz_marking.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Quiz Marking</span></a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="marking.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Student Marks</span></a>
            </li> -->


            <!-- Nav Item - Charts -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="teacher_dashboard.php">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Student Mails</span></a>
            </li> -->

            <!-- Nav Item - Tables -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="teacher_dashboard.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>IT Support</span></a>
            </li> -->

            <!-- Divider -->
            <!-- <hr class="sidebar-divider d-none d-md-block"> -->

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">



                        <h4 style="color:black;">National Education Learning Management System</h4>


                    </form>

                    <!-- Topbar -->

                    <!-- Nav Item - User Information -->
                    <ul class="navbar-nav" style="list-style:none;margin-top:3px;">

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Logged in as
                                    <?php echo $_SESSION['username'] ?></span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg">

                            </a>


                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->




                <!-- Bootstrap core JavaScript-->
                <script src="assets/vendor/jquery/jquery.min.js"></script>
                <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="assets/js/sb-admin-2.min.js"></script>

                <!-- Page level plugins -->
                <script src="assets/vendor/chart.js/Chart.min.js"></script>

                <!-- Page level custom scripts -->
                <script src="assets/js/demo/chart-area-demo.js"></script>
                <script src="assets/js/demo/chart-pie-demo.js"></script>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>