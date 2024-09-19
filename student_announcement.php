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
    <title>Student Announcements</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <style>
        .announcement__main_card {
            display: inline-flex;
            margin-bottom: 10px;
            border: 1px solid #e5e5e5;
            background: #f8f9fc;
            padding: 15px 0px 15px 20px;
            box-shadow: rgb(0 0 0 / 10%) 0px 4px 12px;
        }

        .announcement__left_border {
            border-left: 3px solid #36a3f7;
            padding-left: 25px;
            margin-left: 20px;
            padding-top: 6px;
            padding-bottom: 6px;
        }
    </style>
</head>

<body>

    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 grid-margin stretch-card pl-5 pr-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-primary pb-4 pt-2">My Announcements</h4>
                                <?php
                                $c = 1;
                                require 'db3.php';
                                // $t_id = $_SESSION['id'];
                                date_default_timezone_set('Asia/Karachi');
                                $p_current_date = date('Y-m-d H:i:s', strtotime('-120 days'));
                                if (isset($_GET['id'])) {
                                    $c_id = $_GET['id'];
                                    $select = "SELECT * FROM `announcements` WHERE course_id= '{$c_id}' AND section= '{$_SESSION['user_section']}' AND role_id=2 AND assign_id=3 AND date >= '{$p_current_date}'";
                                } else {
                                    $select = "SELECT * FROM `announcements` WHERE role_id=1 AND assign_id=3 AND date >= '{$p_current_date}'";
                                }
                                $query = mysqli_query($con, $select);
                                while ($result = mysqli_fetch_array($query)) {
                                    $a_title = $result['title'];
                                    $a_date = $result['date'];
                                    $a_comments = $result['comments'];
                                ?>
                                    <form onsubmit="return false" method="POST">
                                        <div class="announcement__main_card" style="width: 100%;">
                                            <div class="m-auto" style="width: 10%;">
                                                <span><?php echo date("d-m-Y", strtotime($a_date)) ?></span>
                                            </div>
                                            <div class="announcement__left_border" style="width: 70%;">
                                                <span><?php echo $a_title ?></span><br>
                                            </div>
                                            <div class="text-center" style="width: 20%;">
                                                <button type="submit" onclick="formsubmit(<?php echo $result['id'] ?>)" class="btn btn-link btn-sm font-weight-bold" name="update_marked" data-toggle="collapse" data-target="#collapse<?php echo $result['id'] ?>">View Announcement</button>
                                            </div>
                                        </div>
                                        <div class="collapse" id="collapse<?php echo $result['id'] ?>">
                                            <div class="card card-body"><?php echo $a_comments ?></div>
                                        </div>
                                    </form>
                                    <br>
                                <?php
                                }
                                ?>
                                <?php
                                date_default_timezone_set('Asia/Karachi');
                                $pag_current_date = date('Y-m-d H:i:s', strtotime('-120 days'));
                                if (isset($_GET['id'])) {
                                    $c_id = $_GET['id'];
                                    $f_select = "SELECT * FROM `announcements` WHERE course_id= '{$c_id}' AND section= '{$_SESSION['user_section']}' AND role_id=2 AND assign_id=3 AND date >= '{$pag_current_date}'";
                                } else {
                                    $f_select = "SELECT * FROM `announcements` WHERE role_id=1 AND assign_id=3 AND date >= '{$pag_current_date}'";
                                }
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
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
        function formsubmit(announcementId) {
            var courseId = window.location.href.split('?id=')[1];
            var announcementId = announcementId;
            if (courseId == undefined || courseId == null) {
                courseId = 0;
            }
            var formdata = 's_course_id=' + courseId + '&s_announcement_id=' + announcementId;
            $.ajax({
                type: "POST",
                url: "check_announcement.php",
                data: formdata,
                cache: false
                // success: function(result) {
                //     console.log('html', result);
                // }
            });
            return false;
        }
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
</body>

</html>