<?php
include 'db3.php';
require 'adminnav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Student Grades Book</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container mt-3 col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-primary ml-2 mt-2">Student Failed Result</h4>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pt-3 pb-3">
            <div class="align-center">
                <table class="table text-left" id="adminPermissionsTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Section</th>
                            <th scope="col" style="width: 50%;">Failed Course</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        $user_stdBatch = date('y');
                        // $sql_select = "SELECT * FROM `course_total_marks` WHERE student_batch='{$user_stdBatch}' AND ((obtain_marks / total_marks * 100) < 50) AND is_published=1 ORDER BY user_id";
                        $sql_select = "SELECT * FROM `course_total_marks` WHERE is_published=1 GROUP BY user_id";
                        $s_query = mysqli_query($con, $sql_select);
                        while ($result = mysqli_fetch_array($s_query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?></td>
                                <td>
                                    <?php
                                    $u_query = "SELECT * FROM `users` WHERE id= '{$result['user_id']}'";
                                    $u_sql = mysqli_query($con, $u_query);
                                    $u_row = mysqli_fetch_array($u_sql);
                                    echo $u_row['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $u_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['user_id']}'";
                                    $u_sql = mysqli_query($con, $u_query);
                                    $u_row = mysqli_fetch_array($u_sql);
                                    echo $u_row['Semester'];
                                    ?>
                                </td>
                                <td><?php echo $result['section'] ?></td>
                                <td>
                                    <?php
                                    $c_query = "SELECT * FROM `course_total_marks` WHERE user_id= '{$result['user_id']}' AND is_published=1";
                                    $c_sql = mysqli_query($con, $c_query);
                                    // $c_row = mysqli_fetch_array($c_sql);
                                    while ($f_result = mysqli_fetch_array($c_sql)) {
                                        $f_cn_query = "SELECT * FROM `teacher_courses` WHERE id= '{$f_result['course_id']}'";
                                        $f_cn_sql = mysqli_query($con, $f_cn_query);
                                        $f_cn_row = mysqli_fetch_array($f_cn_sql);
                                        // echo $f_cn_row['courses_heading'];
                                        if (($f_result['obtain_marks'] / $f_result['total_marks'] * 100) < 50) {
                                            echo '<span class="badge badge-danger mr-1 cursor_pointer_arrow" data-toggle="tooltip" title="' . $f_cn_row['courses_heading'] . '">BS' . $f_result['student_batch'] . '-' . $f_cn_row['course_code'] . '</span>';
                                        }
                                        if (($f_result['obtain_marks'] / $f_result['total_marks'] * 100) >= 50) {
                                            echo '<span class="badge badge-success mr-1 cursor_pointer_arrow" data-toggle="tooltip" title="' . $f_cn_row['courses_heading'] . '">BS' . $f_result['student_batch'] . '-' . $f_cn_row['course_code'] . '</span>';
                                        }
                                    }
                                    ?>
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


    <script>
        // Datatable
        $(document).ready(function() {
            $(' #adminPermissionsTable').DataTable();
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