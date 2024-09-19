<?php
session_start();
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
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:black">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admindashboard.php">

                <div class="sidebar-brand-text mx-3">
                <h2><?php echo $_SESSION['username'] ?></h2>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="admindashboard.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Administrative work
            </div>

            <li class="nav-item">
                <a class="nav-link" href="add_courses.php">
                    <i class="fas fa-fw fa-book-open"></i>
                    <span>Manage Courses</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_announcement.php">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Manage Announcement</span></a>
            </li>



            <!-- <li class="nav-item">
            <a class="nav-link" href="insert_courses.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Insert Courses</span></a>
        </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link" href="admin_add_users.php">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Add Teachers</span></a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link" href="admin_user_students.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Manage Users</span></a>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="admin_grade_book.php?id=1"> -->
                <a class="nav-link" style="cursor: pointer;" data-toggle="modal" data-target="#changeResultSemester">
                    <i class="fas fa-fw fas fa-graduation-cap"></i>
                    <span>Manage Grades</span></a>
            </li>
            <!-- Modal Starts Here -->
            <div class="modal fade" id="changeResultSemester" tabindex="-1" role="dialog" aria-labelledby="changeResultSemesterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Admin Grade Book</h5>
                            <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="admin_grade_book.php" method="POST">
                                <div class="mb-2">
                                    <label>Select Semester</label>
                                    <select class="form-control" name="admin_semesterId" id="admin_semesterId" required>
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                        <option value="3">Semester 3</option>
                                        <option value="4">Semester 4</option>
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                        <option value="7">Semester 7</option>
                                        <option value="8">Semester 8</option>
                                    </select>
                                </div>
                                <button type="button" onclick="location.href='admin_grade_book.php?id='+document.getElementById('admin_semesterId').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Go to Listing</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End Here -->

            <li class="nav-item">
                <!-- <a class="nav-link" style="cursor: pointer;" data-toggle="modal" data-target="#changeGradesListing"> -->
                <a class="nav-link" href="admin_student_result.php">
                    <i class="fas fa-fw fas fa-user"></i>
                    <span>Failed Students</span></a>
            </li>
            <!-- Modal Std Grades Listing Starts Here -->
            <!-- <div class="modal fade" id="changeGradesListing" tabindex="-1" role="dialog" aria-labelledby="changeGradesListingTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changeGradesListingTitle">Student Grades Listing</h5>
                            <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="admin_student_result.php" method="POST">
                                <div class="mb-2">
                                    <label>Select Semester</label>
                                    <select class="form-control" name="std_grades_semesterId" id="std_grades_semesterId" required>
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                        <option value="3">Semester 3</option>
                                        <option value="4">Semester 4</option>
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                        <option value="7">Semester 7</option>
                                        <option value="8">Semester 8</option>
                                    </select>
                                </div>
                                <button type="button" onclick="location.href='admin_student_result.php?id='+document.getElementById('std_grades_semesterId').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Go to Listing</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Modal Std Grades Listing End Here -->

            <li class="nav-item">
                <a class="nav-link" href="admin_permissions.php">
                    <i class="fas fa-fw fas fa-lock"></i>
                    <span>Admin Permissions</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_courses_schema.php">
                    <i class="fas fa-fw fas fa-user-graduate"></i>
                    <span>Courses Schema</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="assign_teacher.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Assigned Courses</span></a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="admin_assign_courses.php">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>Assigned Courses</span></a>
            </li> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Technical Side
            </div>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Teacher Mails</span></a>
            </li> -->


            <!-- Nav Item - Charts -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-envelope-open"></i>
                    <span>Student Mails</span></a>
            </li> -->

            <!-- Nav Item - Tables -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-table"></i>
                    <span>IT Support</span></a>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

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



                        <h3 style="color:black; text-align:center;">National Education Learning Management System</h3>


                    </form>
                    <!-- Topbar -->

                    <!-- Nav Item - User Information -->
                    <ul class="navbar-nav" style="list-style:none;margin-top:3px;">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-secondary-800 large">Logged in as <?php echo $_SESSION['username'] ?></span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg">
                            </a>
                          
                             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
<!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>-->
  <a class="dropdown-item" href="logout.php">
    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400" href="logout.php"></i>
                                    logout

                                </a>
                            </div> 
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
</body>

</html>