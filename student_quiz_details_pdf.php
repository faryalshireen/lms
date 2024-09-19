<?php
include "link.php";
include "db_connect.php";
include "db3.php";
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
    <div class="container mt-2 px-3 py-1 align-center">
        <div class="row">
            <h4 class="text-primary ml-2 pt-2">Submitted Quiz By Students</h4>

            <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3 pt-3 pb-3">
                <div class="align-center">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">Sr.</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Seat</th>
                                <th scope="col">Email</th>
                                <th scope="col">Semester</th>
                                <th scope="col">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $c = 1;
                            $semester = 1;
                            $sql = "SELECT * FROM quiz_details WHERE quiz_id = '{$_GET['quiz']}' group by student_id";
                            $run1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));
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
                                        $c_query = "SELECT * FROM `userdata` WHERE user_id= '{$row['student_id']}'";
                                        $c_sql = mysqli_query($conn, $c_query);
                                        $c_row = mysqli_fetch_array($c_sql);
                                        echo $c_row['Seat'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $c_query = "SELECT * FROM `users` WHERE id= '{$row['student_id']}'";
                                        $c_sql = mysqli_query($conn, $c_query);
                                        $c_row = mysqli_fetch_array($c_sql);
                                        echo $c_row['email'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $c_query = "SELECT * FROM `userdata` WHERE user_id= '{$row['student_id']}'";
                                        $c_sql = mysqli_query($conn, $c_query);
                                        $c_row = mysqli_fetch_array($c_sql);
                                        echo $c_row['Semester'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $c_query = "SELECT * FROM `userdata` WHERE user_id= '{$row['student_id']}'";
                                        $c_sql = mysqli_query($conn, $c_query);
                                        $c_row = mysqli_fetch_array($c_sql);
                                        echo $c_row['Address'];
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
    </div>
</body>

</html>