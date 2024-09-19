<?php
include 'db3.php';
require 'adminnav.php';
$check_result_status = 0;
?>

<!-- Exclude Students -->
<?php
if (isset($_POST['std_include']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $exclude_userId = $_POST['u_include_studendId'];
    $exclude_sql = "UPDATE `course_total_marks` SET `is_excluded` = 0, `is_published` = 1 WHERE `course_total_marks`.`user_id` = '{$exclude_userId}'";
    $e_result = mysqli_query($con, $exclude_sql);
    if ($e_result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Student Promote and Published Successfully!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Student Failed to Promote, please try again later!
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
    <title>Users By Course</title>
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
            <div class="col-md-12">
                <h4 class="text-primary ml-3 pt-2">Excluded Students</h4>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3 pt-3 pb-3">
            <div class="align-center">
                <table class="table" id="adminExcludedTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Total Marks</th>
                            <th scope="col">Obtain Marks</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        $select_sql = "SELECT * FROM `course_total_marks` WHERE is_excluded=1 GROUP BY user_id";
                        $query = mysqli_query($con, $select_sql);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?></td>
                                <td>
                                    <?php
                                    $user_query = "SELECT * FROM `users` WHERE id= '{$result['user_id']}'";
                                    $user_sql = mysqli_query($con, $user_query);
                                    $user_row = mysqli_fetch_array($user_sql);
                                    echo $user_row['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $total_query = "SELECT SUM(total_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$result['user_id']}'";
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
                                    $t_obtained_query = "SELECT SUM(obtain_marks) AS value_sum FROM `course_total_marks` WHERE user_id= '{$result['user_id']}'";
                                    $t_obtained_sql = mysqli_query($con, $t_obtained_query);
                                    $t_obtained_row = mysqli_fetch_assoc($t_obtained_sql);
                                    if (isset($t_obtained_row['value_sum'])) {
                                        echo $t_obtained_row['value_sum'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $result['semester'] ?></td>
                                <td>
                                    <?php
                                    $status_query = "SELECT * FROM `course_total_marks` RIGHT JOIN `teacher_courses` ON course_total_marks.course_id=teacher_courses.id AND course_total_marks.user_id = '{$result['user_id']}' WHERE teacher_courses.semesters='{$result['semester']}' ORDER BY teacher_courses.id";
                                    $status_sql = mysqli_query($con, $status_query);
                                    while ($status_result = mysqli_fetch_array($status_sql)) {

                                        if ($status_result['course_id'] == $status_result['id']) {
                                            echo '<span class="badge badge-success cursor_pointer_arrow mr-1" data-toggle="tooltip" title="' . $status_result['courses_heading'] . '">' . $status_result['course_code'] . '</span>';
                                        } else {
                                            $check_result_status++;
                                            echo '<span class="badge badge-danger cursor_pointer_arrow mr-1" data-toggle="tooltip" title="' . $status_result['courses_heading'] . '">' . $status_result['course_code'] . '</span>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($check_result_status) && $check_result_status <= 0) {
                                    ?>
                                        <form action="admin_excluded_students.php" method="post">
                                            <input type="hidden" name="u_include_studendId" id="u_include_studendId" value="<?php echo $result['user_id'] ?>">
                                            <button type="submit" class="btn btn-success btn-sm btn-inline text-light pl-3 pr-3" id=<?php echo $result['id'] ?> name="std_include">Promote & Publish</button>
                                        </form>
                                    <?php
                                    } else {
                                    ?>
                                        <input type="hidden" name="u_include_studendId" id="u_include_studendId" value="<?php echo $result['user_id'] ?>">
                                        <button type="submit" class="btn btn-success btn-sm btn-inline text-light pl-3 pr-3 disabled" disabled id=<?php echo $result['id'] ?>>Result Awaiting</button>
                                    <?php
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
            $(' #adminExcludedTable').DataTable();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>