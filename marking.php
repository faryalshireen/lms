<?php
include 'db3.php';
include 'teachernav.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Check Assignments</title>
  <link rel="stylesheet" href="style3.css">
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body>

  <div class="container mb-5 align-center">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 pl-4 pr-4">
        <h4 class="text-primary pb-3 pt-3">Student Marks</h4>
        <div class="table-responsive">
          <div class="card">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Sr.</th>
                  <th scope="col">Seat No.</th>
                  <th scope="col">Full Name</th>
                  <th scope="col">Course</th>
                  <th scope="col">Obt. Marks</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $c = 1;
                require 'db3.php';
                $select = "SELECT * FROM `marks` WHERE teacher_id= '{$_SESSION['id']}' AND assignment_id='{$_GET['id']}'";
                $query = mysqli_query($con, $select);
                while ($result = mysqli_fetch_array($query)) {
                  $res = $result['Course'];
                  $task = $result['marks'];
                  $dat = $result['Status']
                ?>
                  <tr>
                    <td><?php echo $c++ ?> </td>
                    <td><?php
                        $u_query = "SELECT * FROM `userdata` WHERE user_id= '{$result['user_id']}'";
                        $u_sql = mysqli_query($con, $u_query);
                        $u_row = mysqli_fetch_array($u_sql);
                        echo $u_row['Seat'];
                        ?></td>
                    <td><?php
                        $user_query = "SELECT * FROM `users` WHERE id= '{$result['user_id']}'";
                        $user_sql = mysqli_query($con, $user_query);
                        $user_row = mysqli_fetch_array($user_sql);
                        echo $user_row['name'];
                        ?></td>
                    <td><?php include "db_connect.php";
                        $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$result['Course']}'";
                        $c_sql = mysqli_query($conn, $c_query);
                        $c_row = mysqli_fetch_array($c_sql);
                        $course_id = $c_row['course_code'];
                        echo $course_id;
                        ?>
                    </td>
                    <td><?php echo $task ?></td>
                    <td><?php echo $dat ?></td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
            <?php
            $f_select = "SELECT * FROM `marks` WHERE teacher_id= '{$_SESSION['id']}' AND assignment_id='{$_GET['id']}'";
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




  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>