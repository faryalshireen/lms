<?php
include "link.php";
include "db_connect.php";
include "db3.php";
include 'teachernav.php';
?>

<?php
if (isset($_POST['marks_submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    // Check Quiz Available
    $check_select = "SELECT * FROM `total_quiz_marks` WHERE quiz_id= '{$_GET['quiz']}'";
    $check_query = mysqli_query($con, $check_select);
    if (mysqli_num_rows($check_query) <= 0) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Quiz not submitted by students!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    } else {
        $publish_sql = "UPDATE `total_quiz_marks` SET `is_posted` = 1 WHERE `total_quiz_marks`.`quiz_id` = '{$_GET['quiz']}'";
        $p_result = mysqli_query($conn, $publish_sql);

        if ($publish_sql) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Students Result Published Successfully!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Student Result Failed to published!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        }
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
    <title>Students By Course</title>
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
                <h4 class="text-primary ml-2 pt-2">Submitted Quiz By Students</h4>
            </div>
            <div class="col-md-6">
                <div class="float-right w-100 text-right">
                    <form action="student_quiz_results_view.php?quiz=<?php echo $_GET['quiz'] ?>" method="POST">
                        <input type="hidden" name="quiz_id" value="<?php echo $_GET['quiz'] ?>" />
                        <?php
                        // Check Published
                        $res_select = "SELECT * FROM `total_quiz_marks` WHERE quiz_id= '{$_GET['quiz']}' AND is_posted=1";
                        $res_query = mysqli_query($con, $res_select);
                        if (mysqli_num_rows($res_query) <= 0) {
                            echo '<button type="submit" name="marks_submit" class="btn btn-success btn-sm text-white mt-2 mb-2 pl-4 pr-4 pb-1 pt-1">Publish Marks</button>';
                        } else {
                            echo '<button disabled class="btn btn-success btn-sm text-white mt-2 mb-2 pl-4 pr-4 pb-1 pt-1 disabled">Already Published</button>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-2 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3 pt-3 pb-3">
            <div class="align-center">
                <table class="table text-center" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Seat</th>
                            <th scope="col">Total Marks</th>
                            <th scope="col">Obtained Marks</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        // $semester = $_GET['semester'];
                        $semester = 1;
                        $sql = "SELECT * FROM quiz_details WHERE quiz_id = '{$_GET['quiz']}' group by student_id";
                        $run1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                        // $row1 = mysqli_fetch_array($run1);

                        // $sid = $row1['student_id'];
                        // $quizid = $row1['quiz_id'];
                        // echo $sid;
                        // $query = "SELECT * FROM userdata WHERE Semester = '$semester' AND user_id = '$sid'";
                        // $run = mysqli_query($con, $query) or die(mysqli_error($con));

                        while ($row = mysqli_fetch_array($run1)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?></td>
                                <td>
                                    <?php
                                    $c_query = "SELECT * FROM `users` WHERE id= '{$row['student_id']}'";
                                    $c_sql = mysqli_query($conn, $c_query);
                                    $c_row = mysqli_fetch_array($c_sql);
                                    echo $c_row['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $userdata_query = "SELECT * FROM `userdata` WHERE user_id= '{$row['student_id']}'";
                                    $userdata_sql = mysqli_query($conn, $userdata_query);
                                    $userdata_row = mysqli_fetch_array($userdata_sql);
                                    echo $userdata_row['Seat'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $total_sql = "SELECT * FROM questions WHERE quiz_id = '{$row['quiz_id']}'";
                                    $total_result = mysqli_query($conn, $total_sql) or die(mysqli_error($conn));
                                    // $total1 = mysqli_fetch_assoc($total_result);
                                    $total_row = mysqli_num_rows($total_result);
                                    echo $total_row * 1;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $t_sql = "SELECT SUM(marks) AS value_sum FROM quiz_details WHERE quiz_id = '{$row['quiz_id']}' AND student_id='{$row['student_id']}'";
                                    $t_result = mysqli_query($conn, $t_sql);
                                    $t_row = mysqli_fetch_assoc($t_result);
                                    echo $t_row['value_sum'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // $udata_query = "SELECT * FROM `userdata` WHERE user_id= '{$row['student_id']}'";
                                    // $udata_sql = mysqli_query($conn, $udata_query);
                                    // $udata_row = mysqli_fetch_array($udata_sql);
                                    echo '<a href="student_marks_and_answers.php?quiz_id=' . $_GET['quiz'] . '&sid=' . $row['student_id'] . '" class="btn btn-info btn-sm">Student Result</a>';
                                    ?>
                                </td>
                                <?php
                                // Get Course ID
                                $course_select = "SELECT * FROM `create_quiz` WHERE id= '{$_GET['quiz']}'";
                                $course_query = mysqli_query($con, $course_select);
                                $course_row = mysqli_fetch_array($course_query);

                                $c_select = "SELECT * FROM `total_quiz_marks` WHERE student_id= '{$c_row['id']}' AND quiz_id= '{$_GET['quiz']}' AND section='{$userdata_row['section']}'";
                                $ck_query = mysqli_query($con, $c_select);
                                if (mysqli_num_rows($ck_query) <= 0) {
                                    $q_student_id = $c_row['id'];
                                    $q_quiz_id = $_GET['quiz'];
                                    $q_course_id = $course_row['course_id'];
                                    $q_stduser_batch = $course_row['student_batch'];
                                    $q_obtain_marks = $t_row['value_sum'];
                                    $q_usection = $userdata_row['section'];
                                    $q_total_marks = $total_row * 1;
                                    $q_is_posted = 0;

                                    $inserted = "INSERT INTO `total_quiz_marks` (`student_id`,`quiz_id`,`course_id`,`obtain_marks`,`total_marks`,`is_posted`,`section`,`student_batch`) VALUES ('$q_student_id','$q_quiz_id','$q_course_id','$q_obtain_marks','$q_total_marks','$q_is_posted','$q_usection','$q_stduser_batch')";
                                    $query = mysqli_query($con, $inserted);
                                }
                                ?>
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="download_pdf.php?quiz=<?php echo $_GET['quiz'] ?>" class="btn btn-primary btn-sm ml-3 mt-0 mb-3 pl-4 pr-4 pb-1 pt-1">Download PDF</button>

        <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>

</body>

</html>