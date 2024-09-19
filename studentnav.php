<?php
session_start();
include "db_connect.php";
?>

<?php
$ch_std_id = $_SESSION['id'];
$ch_p_select = "SELECT * FROM `userdata` WHERE user_id= '{$ch_std_id}'";
$ch_p_query = mysqli_query($conn, $ch_p_select);
$ch_p_row = mysqli_fetch_array($ch_p_query);
if (!isset($ch_p_row['Gender']) || !isset($ch_p_row['First']) || !isset($ch_p_row['Last']) || !isset($ch_p_row['CNIC']) || !isset($ch_p_row['DOB']) || !isset($ch_p_row['Mobile']) || !isset($ch_p_row['Province']) || !isset($ch_p_row['Postal Code']) || !isset($ch_p_row['Address']) || !isset($ch_p_row['City']) || !isset($ch_p_row['Seat']) || !isset($ch_p_row['Semester'])) {
    $_SESSION['user_profile_status'] = 0;
} else {
    $_SESSION['user_profile_status'] = 1;
}
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

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/common.css">
    <!-- Custom Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <style>
        .a__studentnav_notification_icon {
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
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:black">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="userdashboard.php">

                <div class="sidebar-brand-text mx-3">
                <h2><?php echo $_SESSION['username'] ?></h2>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="userdashboard.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Pages Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="classes.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Classes</span></a>
            </li> -->
            <li class="nav-item">
                <?php
                if (isset($_SESSION['user_profile_status']) && $_SESSION['user_profile_status'] == 0) {
                    echo '<a class="nav-link disabled" href="userdashboard.php">';
                } else {
                    echo '<a class="nav-link" href="display.php">';
                }
                ?>
                <i class="fas fa-fw fa-tasks"></i>
                <span>Assignments</span></a>
            </li>
            <?php
            include "db_connect.php";
            // Announcement Notification Calculated
            date_default_timezone_set('Asia/Karachi');
            $u_current_date = date('Y-m-d H:i:s', strtotime('-120 days'));
            $c_query = "SELECT * FROM `announcements` WHERE role_id=1 AND assign_id=3 AND date >= '{$u_current_date}'";
            $c_sql = mysqli_query($conn, $c_query);
            $c_courseAnnouncements =  mysqli_num_rows($c_sql);
            $status_query = "SELECT * FROM `announcement_status` WHERE user_id='{$_SESSION['id']}' AND role_id=3 AND is_read=1 AND course_id = 0";
            $status_sql = mysqli_query($conn, $status_query);
            $read_courseAnnouncements =  $c_courseAnnouncements - mysqli_num_rows($status_sql);
            if ($read_courseAnnouncements > 0) {
                $total_courseAnnouncements = $read_courseAnnouncements;
                $total_courseAnnouncements = '<span class="badge badge-danger a__studentnav_notification_icon">' . $total_courseAnnouncements . '</span>';
            } else {
                $total_courseAnnouncements = '<span></span>';
            }
            // echo $total_courseAnnouncements;
            ?>
            <li class="nav-item">
                <a class="nav-link" href="student_announcement.php">
                    <i class="fas fa-fw fa-bullhorn" style="position:relative;">
                        <?php echo $total_courseAnnouncements ?>
                    </i>
                    <span>Announcements</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="study_schema.php">
                    <i class="fas fa-fw fas fa-user-graduate"></i>
                    <span>My Study Schema</span></a>
            </li>

            <li class="nav-item">
                <?php
                if (isset($_SESSION['user_profile_status']) && $_SESSION['user_profile_status'] == 0) {
                    echo '<a class="nav-link disabled" href="userdashboard.php">';
                } else {
                    echo '<a class="nav-link" href="quizes.php">';
                }
                ?>
                <i class="fas fa-fw fa-book-open"></i>
                <span>Students Quiz</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="student_gradebook.php">
                    <i class="fas fa-fw fa-graduation-cap"></i>
                    <span>Grade Book</span></a>
            </li>




            <!-- <li class="nav-item">

                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-book-reader"></i>
                    <span>Student Service</span>
                </a> -->
            <!-- <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar"> -->
            <!-- <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Classwork : </h6>
                    <a class="collapse-item" href="classes.php">Classess</a>
                    <a class="collapse-item" href="#">Marking</a>
                    <a class="collapse-item" href="#">Student Marks</a>
                </div> -->
            <!-- </div> -->
            <!-- </li> -->
            <li class="nav-item">
                <?php
                if (isset($_SESSION['user_profile_status']) && $_SESSION['user_profile_status'] == 0) {
                    echo '<a class="nav-link disabled" href="userdashboard.php">';
                } else {
                    echo '<a class="nav-link" href="student_discussion.php">';
                }
                ?>
                <i class="fas fa-fw fa-comment"></i>
                <span>Discussion Board</span></a>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
            </div>
        </li> -->

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Nav Item - Pages Collapse Menu -->
            <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
               
            </div>
        </li> -->

            <!-- Nav Item - Charts -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="userdashboard.php">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Mails</span></a>
            </li> -->

            <!-- Nav Item - Tables -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="userdashboard.php">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span>Contact Us</span></a>
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
                    <ul style="list-style:none;margin-top:1em;">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username'] ?></span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>

                                <?php

                                ?>

                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    logout

                                </a>
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
</body>

</html>