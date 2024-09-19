<?php
include "link.php";
include "db_connect.php";
include "db3.php";
include 'teachernav.php';
?>

<?
if (isset($_POST['submit'])) {
    $totalmarks = $_POST['total_marks'];
    $sql = "INSERT INTO student_marks (`total_marks`) VALUES('$totalmarks')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "post";
    } else {
        echo "not";
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
    <title>Student Quiz Result</title>
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
                <h4 class="text-primary ml-3 pt-2">Student Quiz Result</h4>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3">
            <div class="align-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Question</th>
                            <th scope="col">Correct Answer</th>
                            <th scope="col">Student Answer</th>
                            <th scope="col">Student Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        $qid = $_GET['quiz_id'];
                        $user_id = $_GET['sid'];
                        $select0 = "SELECT SUM(marks) AS value_sum FROM quiz_details WHERE quiz_id = '{$qid}' AND student_id='{$user_id}'";
                        $result0 = mysqli_query($conn, $select0);
                        $row0 = mysqli_fetch_assoc($result0);
                        $mark = $row0['value_sum'];
                        $select = "SELECT * FROM quiz_details WHERE quiz_id = '{$qid}' AND student_id='{$user_id}'";
                        $result = mysqli_query($conn, $select);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // echo $row['id'];
                            $student_answer = $row['student_answer'];
                            $marks = $row['marks'];
                            $question_id = $row['question_id'];
                            $select1 = "SELECT * FROM questions WHERE quiz_id = '{$qid}' AND qid = '{$question_id}'";
                            $result1 = mysqli_query($conn, $select1);
                            $q_result = mysqli_fetch_assoc($result1);
                        ?>
                            <tr>
                                <td><?php echo $c++ ?></td>
                                <td>
                                    <?php
                                    if (isset($q_result['question'])) {
                                        echo $q_result['question'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($q_result['correct_answer'])) {
                                        echo $q_result['correct_answer'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $student_answer ?></td>
                                <td><?php echo $marks ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <th colspan="4" name="total_marks"> Total Marks: </th>
                            <td name="total_marks"><?php echo $mark ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#myTable').DataTable();
        // });
    </script>
</body>

</html>