<?php
include 'studentnav.php';
include "link.php";
include "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Student Discussion Board</title>
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
                <h4 class="text-primary ml-3 pt-2">Student Discussion Board</h4>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pb-3 pt-3">
            <div class="align-center">
                <table class="table" id="discussionStdTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr #</th>
                            <th scope="col">Discussion Topic</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Total Marks</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        // Current User Semester
                        $s_query = "SELECT * FROM `userdata` WHERE user_id= '{$_SESSION['id']}'";
                        $s_sql = mysqli_query($conn, $s_query);
                        $s_row = mysqli_fetch_array($s_sql);
                        $semesterId = $s_row['Semester'];
                        // Get Current Date
                        date_default_timezone_set('Asia/Karachi');
                        $d_current_date = date('Y-m-d', strtotime('0 days'));
                        $std_currentBatch = date('y');

                        if (isset($_GET['id'])) {
                            // $query = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$std_currentBatch}' AND section= '{$_SESSION['user_section']}' AND semester= '{$semesterId}' AND due_date >= '{$d_current_date}'";
                            $query = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$std_currentBatch}' AND section= '{$_SESSION['user_section']}' AND due_date >= '{$d_current_date}'";
                        } else {
                            $query = "SELECT * FROM discussion_question WHERE semester= '{$semesterId}' AND student_batch='{$std_currentBatch}' AND section= '{$_SESSION['user_section']}' AND due_date >= '{$d_current_date}'";
                        }
                        $sql = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $question = $row['question'];
                            $due_date = $row['due_date'];

                            $last = date($due_date);
                            $current_date = date("d-m-Y");
                            $id = $row['id'];
                            $is_attempt = $row['is_attempt'];
                        ?>
                            <tr>
                                <td><?php echo $c++ ?></td>
                                <td><?php echo $question ?></td>
                                <td><?php echo $last ?></td>
                                <td><?php echo $row['total_marks'] ?></td>
                                <td>
                                    <?php
                                    $c_select = "SELECT * FROM `discussion_answers` WHERE student_id= '{$_SESSION['id']}' AND question_id='{$row['id']}'";
                                    $c_query = mysqli_query($conn, $c_select);
                                    if (mysqli_num_rows($c_query) > 0) {
                                    ?><span class="badge badge-success">Turn In</span>
                                    <?php
                                    } else {
                                    ?><span class="badge badge-primary">New</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $attempt_select = "SELECT * FROM `discussion_answers` WHERE student_id= '{$_SESSION['id']}' AND question_id='{$row['id']}'";
                                    $a_query = mysqli_query($conn, $attempt_select);
                                    if (mysqli_num_rows($a_query) > 0) {
                                    ?><a class="btn btn-danger btn-sm text-light disabled">Already Attempted</a>
                                    <?php
                                    } else if (isset($_GET['repeat'])) {
                                    ?>
                                        <a href="grade_board_student.php?id=<?php echo $row['id'] ?>&cid=<?php echo $row['course_id'] ?>&repeat=1" class="btn btn-primary btn-sm">Attempt</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="grade_board_student.php?id=<?php echo $row['id'] ?>&cid=<?php echo $row['course_id'] ?>" class="btn btn-primary btn-sm">Attempt</a>
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
                <?php
                // Current User Semester
                // $fs_query = "SELECT * FROM `userdata` WHERE user_id= '{$_SESSION['id']}'";
                // $fs_sql = mysqli_query($conn, $fs_query);
                // $fs_row = mysqli_fetch_array($fs_sql);
                // $fs_row['Semester'];
                // // Get Current Date
                // date_default_timezone_set('Asia/Karachi');
                // $df_current_date = date('Y-m-d', strtotime('0 days'));
                // if (isset($_GET['id'])) {
                //     $f_select = "SELECT * FROM discussion_question WHERE course_id = '{$_GET['id']}' AND student_batch='{$std_currentBatch}' AND section= '{$_SESSION['user_section']}' AND semester= '{$fs_row['Semester']}' AND due_date >= '{$d_current_date}'";
                // } else {
                //     $f_select = "SELECT * FROM discussion_question WHERE semester= '{$fs_row['Semester']}' AND student_batch='{$std_currentBatch}' AND section= '{$_SESSION['user_section']}' AND due_date >= '{$d_current_date}'";
                // }
                // $f_query = mysqli_query($conn, $f_select);
                // if (mysqli_num_rows($f_query) <= 0) {
                //     echo "<p class='text-center'>No Records Found!</p>";
                // }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        // Datatable
        $(document).ready(function() {
            $('#discussionStdTable').DataTable();
        });
    </script>
    <!-- Profile Popup Enable by adding this Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>