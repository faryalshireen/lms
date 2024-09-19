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
    <title>Student Grade Book</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="text-primary ml-2">Student Grade Book</h4>
            </div>
            <div class="col-md-6">
                <?php
                // Check Published
                // $check_sql_query = "SELECT * FROM course_total_marks WHERE user_id= '{$_SESSION['id']}' AND is_published=1";
                // $check_sql = mysqli_query($conn, $check_sql_query);
                // if (mysqli_num_rows($check_sql) >= 1) {
                //     // Total Marks Sum
                //     $total_query = "SELECT SUM(total_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$_SESSION['id']}'";
                //     $total_sql = mysqli_query($con, $total_query);
                //     $total_row = mysqli_fetch_assoc($total_sql);
                //     // Total Obtained
                //     $t_obtained_query = "SELECT SUM(obtain_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$_SESSION['id']}'";
                //     $t_obtained_sql = mysqli_query($con, $t_obtained_query);
                //     $t_obtained_row = mysqli_fetch_assoc($t_obtained_sql);
                //     // Total Percentage
                //     $user_total_percentage = round(($t_obtained_row['value_sum'] / $total_row['value_sum']) * 100);
                //     if ($user_total_percentage >= 50) {
                //         echo '<h5 class="text-success text-right ml-2">Total Marks: ' . $total_row['value_sum'] . ' / ' . $t_obtained_row['value_sum'] . '<br><span class="badge badge-success mt-2">Passed - ' . $user_total_percentage . '%</span></h5>';
                //     } else {
                //         echo '<h5 class="text-danger text-right ml-2">Total Marks: ' . $total_row['value_sum'] . ' / ' . $t_obtained_row['value_sum'] . '<br><span class="badge badge-danger mt-2">Failed - ' . $user_total_percentage . '%</span></h5>';
                //     }
                // }
                ?>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3 pt-3 pb-3">
            <div class="align-center">
                <table class="table text-left" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr #</th>
                            <th scope="col">Course Name</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Batch</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Total Marks</th>
                            <th scope="col">Obtain Marks</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_query = "SELECT * FROM course_total_marks WHERE user_id= '{$_SESSION['id']}' AND section ='{$_SESSION['user_section']}' AND is_published=1 AND is_excluded=0";
                        $sql = mysqli_query($conn, $sql_query);
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($sql)) {
                        ?>
                            <tr>
                                <td><?php echo $count++ ?></th>
                                <td>
                                    <?php
                                    $course_query = "SELECT * FROM `teacher_courses` WHERE id= '{$row['course_id']}'";
                                    $course_sql = mysqli_query($con, $course_query);
                                    $course_row = mysqli_fetch_array($course_sql);
                                    if (isset($course_row['courses_heading'])) {
                                        echo $course_row['courses_heading'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $u_query = "SELECT * FROM `users` WHERE id= '{$row['teacher_id']}'";
                                    $u_sql = mysqli_query($con, $u_query);
                                    $u_row = mysqli_fetch_array($u_sql);
                                    if (isset($u_row['name'])) {
                                        echo $u_row['name'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>BS-<?php echo $row['student_batch'] ?></th>
                                <td><?php echo $row['semester'] ?></th>
                                <td><?php echo $row['total_marks'] ?></th>
                                <td><?php echo $row['obtain_marks'] ?></th>
                                <td>
                                    <?php
                                    $user_obtained_percentage = round(($row['obtain_marks'] / $row['total_marks']) * 100);
                                    if (isset($user_obtained_percentage) && $user_obtained_percentage >= 50) {
                                        echo '<span class="badge badge-success">Passed - ' . $user_obtained_percentage . '%</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Failed - ' . $user_obtained_percentage . '%</span>';
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script>
        // Datatable
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
</body>

</html>