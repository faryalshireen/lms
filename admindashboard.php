<?php
include 'adminnav.php';
include "db_connect.php";
// $dataPoints = array(
//     array("label"=> "Food + Drinks", "y"=> 590),
//     array("label"=> "Activities and Entertainments", "y"=> 261),
//     array("label"=> "Health and Fitness", "y"=> 158),
//     array("label"=> "Shopping & Misc", "y"=> 72),
//     array("label"=> "Transportation", "y"=> 191),
//     array("label"=> "Rent", "y"=> 573),
//     array("label"=> "Travel Insurance", "y"=> 126)
// );
   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Admin Dashoard</title>
    <!-- Library -->
    <!-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.css"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> -->
    <style>
        .bg_custom_primary {
            background-color: #00b5b8 !important;
        }

        .text_custom_primary {
            color: #00b5b8 !important;
        }
    </style>
</head>

<body>
    <div class="grey-bg container mt-0 pt-0 col-12">
        <section id="minimal-statistics">
            <h4 class="text-info pt-2 pb-3 col-12">Admin Dashboard</h4>
            <div class="row col-md-12" >
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-user text_custom_primary font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `users` WHERE role_id=3";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_students = mysqli_num_rows($user_sql);
                                            echo $admin_total_students;
                                            ?>
                                        </h3>
                                        <span>Students</span>
                                    </div>
                                </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_students ?>%" aria-valuenow="<?php echo $admin_total_students ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-user text_custom_primary font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `users` WHERE role_id=3";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_students = mysqli_num_rows($user_sql);
                                            echo $admin_total_students;
                                            ?>
                                        </h3>
                                        <span>Teacher</span>
                                    </div>
                                </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_teachers ?>%" aria-valuenow="<?php echo $admin_total_students ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-book-open text_custom_primary font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `upload`";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_assignments = mysqli_num_rows($user_sql);
                                            echo $admin_total_assignments;
                                            ?>
                                        </h3>
                                        <span>Assignments</span>
                                    </div>
                                </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_assignments ?>%" aria-valuenow="<?php echo $admin_total_assignments ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-speech text_custom_primary font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `create_quiz`";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_quizzes = mysqli_num_rows($user_sql);
                                            echo $admin_total_quizzes;
                                            ?>
                                        </h3>
                                        <span>Quizz</span>
                                    </div>
                                </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_quizzes ?>%" aria-valuenow="<?php echo $admin_total_quizzes ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-bubbles text_custom_primary font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `discussion_question`";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_discussions = mysqli_num_rows($user_sql);
                                            echo $admin_total_discussions;
                                            ?>
                                        </h3>
                                        <span>Discussion Board</span>
                                    </div>
                                </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_discussions ?>%" aria-valuenow="<?php echo $admin_total_discussions ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-bubbles text_custom_primary font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `announcements`";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_announcements = mysqli_num_rows($user_sql);
                                            echo $admin_total_announcements;
                                            ?>
                                        </h3>
                                        <span>Announcements</span>
                                    </div>
                                </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_announcements ?>%" aria-valuenow="<?php echo $admin_total_announcements ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            
                 <!-- <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-pie-chart text-warning font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>423</h3>
                                        <span>GDBs</span>
                                    </div>
                                </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  -->
            </div>
            
      <!---------------card end-------------------->
            <div class="row">
              <div class="col-md-8">
                <div class="card card-round">
                  <div class="card-header">
                  <div class="container mt-5 col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-primary">Manage Announcements</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary btn-sm float-right text-white" href="admin_create_announcement.php">Create Announcement</a>
            </div>
        </div>
    </div>
    <div class="container mt-3 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3">
            <div class="align-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Assigned</th>
                            <!-- <th scope="col">Semester</th> -->
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $t_id = $_SESSION['id'];
                        $select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}'";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                            // $semester = $result['semester'];
                            $task = $result['course_id'];
                            $title = $result['title'];
                            $date = $result['date'];
                            $comments = $result['comments'];
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo substr($title, 0, 20) ?>..</td>
                                <td><?php
                                    if ($result['assign_id'] == 2) {
                                        echo 'Teacher';
                                    } else {
                                        echo 'Student';
                                    }
                                    ?></td>
                                <td style="display: none;"><?php echo $result['assign_id'] ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php echo substr($result['comments'], 0, 40) ?>..</td>
                                <td style="display: none;"><?php echo $comments ?></td>
                                <td style="display: none;"><?php echo $title ?></td>
                                <td>
                                    <button class="Edit btn btn-info btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="edit">Edit</button>
                                    <button class="Delete btn btn-danger btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="delete">Delete</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                $t_id = $_SESSION['id'];
                $f_select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}'";
                $f_query = mysqli_query($con, $f_select);
                if (mysqli_num_rows($f_query) <= 0) {
                    echo "<p class='text-center'>No Records Found!</p>";
                }
                ?>
            </div>
        </div>
              </div>
                  </div>
                 
                </div>
              </div>
              <div class="col-md-3">
                <div class="card card-primary card-round">
                  <div class="card-header">
                    <div class="card-head-row">
                      <div class="card-title">Student passed Result</div>
                     
                    </div>
                    <div class="card-category">2023 - 2024</div>
                  </div>
                  <div class="card-body pb-0 text-center">
                  <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `users` WHERE role_id=3";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_students = mysqli_num_rows($user_sql);
                                            echo $admin_total_students;
                                            ?>
                                        </h3>
                    <div class="mb-4 mt-2">
                        
                    <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_students ?>%" aria-valuenow="<?php echo $admin_total_students ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br/>
                                <div class="pull-in">
                                <div class="card-title">Student Failed Result</div>
                                <h3>
                                            <?php
                                            $user_query = "SELECT * FROM `users` WHERE role_id=3";
                                            $user_sql = mysqli_query($conn, $user_query);
                                            $admin_total_students = mysqli_num_rows($user_sql);
                                            echo $admin_total_students;
                                            ?>
                                        </h3>
                      <div class="card-tools">
                          
                      </div>
                                <div class="progress mt-3 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg_custom_primary" role="progressbar" style="width: <?php echo $admin_total_students ?>%" aria-valuenow="<?php echo $admin_total_students ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                    </div> 
                    </div>
                    
                  </div>
                </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <script>
 window.onload = function () {
  
 var chart = new CanvasJS.Chart("chartContainer", {
     animationEnabled: true,
     exportEnabled: true,
     title:{
         text: "Average Expense Per Day  in Thai Baht"
     },
     subtitles: [{
         text: "Currency Used: Thai Baht (฿)"
     }],
     data: [{
         type: "pie",
         showInLegend: "true",
         legendText: "{label}",
         indexLabelFontSize: 16,
         indexLabel: "{label} - #percent%",
         yValueFormatString: "฿#,##0",
         dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
     }]
 });
 chart.render();
  
 }
 </script>
 
 <div id="chartContainer" style="height: 370px; width: 100%;"></div>
 <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <!---new teacher---->
    <div class="row">
             
              <div class="col-md-12">
                <div class="card card-round">
                  <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                      <div class="card-title">Administration Permissions</div>
                      <div class="card-tools">
                        
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <!-- Projects table -->
                      <div class="container mt-3 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pt-3 pb-3">
            <div class="align-center">
                <table class="table" id="adminPermissionsTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr #</th>
                            <th scope="col">Title</th>
                            <th scope="col">Assigned to</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = "SELECT * FROM `admin_permissions`";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $result['id'] ?></td>
                                <td><?php echo $result['title'] ?></td>
                                <td><?php echo $result['role'] ?></td>
                                <td>
                                    <?php
                                    if (isset($result['permission']) && $result['permission'] == 1) {
                                        echo '<span class="badge badge-success">Approved</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Pending</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <form action="admin_permissions.php" method="post">
                                        <input type="hidden" name="r_admin_id" id="r_admin_id" value="<?php echo $result['id'] ?>">
                                        <?php
                                        if (isset($result['permission']) && $result['permission'] == 1) {
                                        ?>
                                            <button class="btn btn-danger btn-sm btn-inline text-light" name="admin_permissionBtn" value="0">Deny Permission</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button class="btn btn-success btn-sm btn-inline text-light" name="admin_permissionBtn" value="1">Approve Permission</button>
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
    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!----end teacher---->
        <footer class="footer">
          <div class="container-fluid d-flex  bg-dark justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
               
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Help </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Licenses </a>
                </li>
              </ul>
            </nav>
            <div class="copyright">
              2024, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="http://www.Aptech.com">APtech</a>
            </div>
            <div>
              Distributed by
              <a target="_blank" href="https://Aptech.com/">AptechTeam</a>.
            </div>
          </div>
        </footer>
      </div>
        </section>
    </div>
</body>

</html>