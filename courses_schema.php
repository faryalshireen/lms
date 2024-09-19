<?php
include 'db3.php';
require 'teachernav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>My Courses Schema</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <style>
        .table-striped {
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
        }
    </style>
</head>

<body>
    <div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-primary pl-3 pt-4">My Courses Schema</h4>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center pl-4 pr-4">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
            <div class="align-center">
                <h4 class="pt-4 pb-2">Semester 1</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 1";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <h4>Semester 2</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 2";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <h4>Semester 3</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 3";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <h4>Semester 4</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 4";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <h4>Semester 5</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 5";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <h4>Semester 6</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 6";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <h4>Semester 7</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 7";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <h4>Semester 8</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Course</th>
                            <th scope="col">Title</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Credit Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $select = "SELECT * FROM `teacher_courses` WHERE semesters = 8";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  $result['course_code'] ?></td>
                                <td><?php echo  $result['courses_heading'] ?></td>
                                <td><?php echo  $result['semesters'] ?></td>
                                <td><?php echo  $result['credit'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                $f_select = "SELECT * FROM `teacher_courses`";
                $f_query = mysqli_query($con, $f_select);
                if (mysqli_num_rows($f_query) <= 0) {
                    echo "<p class='text-center'>No Records Found!</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
</body>

</html>