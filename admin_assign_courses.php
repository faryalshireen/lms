<?php
include "db_connect.php";
include "link.php";
include "adminnav.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

  <title>Assigned Courses</title>
</head>

<body>
  <div class="container">
    <div class="row pl-2 pr-2 mb-3">
      <h4 class="text-primary pt-2 ml-2 pb-2">Assigned Teacher Courses</h4>
      <div class="col-md-12 card p-3">
        <div class="align-center">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                <th scope="col">Sr.</th>
                <th scope="col">Course</th>
                <th scope="col">Semester</th>
                <th scope="col">Section A</th>
                <th scope="col">Section B</th>
                <th scope="col">Section C</th>
                <th scope="col">Section D</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $c = 1;
              $select = "SELECT * FROM `teacher_courses` ORDER by semesters";
              $sql = mysqli_query($conn, $select);
              while ($row = mysqli_fetch_assoc($sql)) {
                // $course_id = $row['id'];
                // $semester_id= $row['semester_id'];
                // $teacher_id = $row['teacher_id'];
                // $select = "SELECT * FROM `teacher_courses` WHERE id= '{$course_id}'";
                // $result = mysqli_query($conn, $select);
                // $row = mysqli_fetch_assoc($result);
                // $course = $row['courses_heading'];
                // $s_ = "SELECT * FROM `users` WHERE id = '{$teacher_id}'";
                // $result2 = mysqli_query($conn, $select2);
                // $row = mysqli_fetch_assoc($result2);
                // $teacher = $row['name'];
                $t_query = "SELECT * FROM `users` WHERE id= '{$row['teacher_id']}'";
                $t_sql = mysqli_query($conn, $t_query);
                $t_row = mysqli_fetch_array($t_sql);
              ?>
                <tr>
                  <td><?php echo $c++ ?></td>
                  <td><?php echo $row['courses_heading'] ?></td>
                  <td><?php echo $row['semesters'] ?></td>
                  <td>
                    <?php
                    $c_query = "SELECT * FROM `users` WHERE id= '{$row['section_a']}'";
                    $c_sql = mysqli_query($conn, $c_query);
                    $c_row = mysqli_fetch_array($c_sql);
                    if (isset($c_row['name'])) {
                      echo '<span class="text-success font-weight-bold">' . $c_row['name'] . '</span>';
                    } else {
                      echo '<span class="text-danger font-weight-bold">Pending</span>';
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    $c_query = "SELECT * FROM `users` WHERE id= '{$row['section_b']}'";
                    $c_sql = mysqli_query($conn, $c_query);
                    $c_row = mysqli_fetch_array($c_sql);
                    if (isset($c_row['name'])) {
                      echo '<span class="text-success font-weight-bold">' . $c_row['name'] . '</span>';
                    } else {
                      echo '<span class="text-danger font-weight-bold">Pending</span>';
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    $c_query = "SELECT * FROM `users` WHERE id= '{$row['section_c']}'";
                    $c_sql = mysqli_query($conn, $c_query);
                    $c_row = mysqli_fetch_array($c_sql);
                    if (isset($c_row['name'])) {
                      echo '<span class="text-success font-weight-bold">' . $c_row['name'] . '</span>';
                    } else {
                      echo '<span class="text-danger font-weight-bold">Pending</span>';
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    $c_query = "SELECT * FROM `users` WHERE id= '{$row['section_d']}'";
                    $c_sql = mysqli_query($conn, $c_query);
                    $c_row = mysqli_fetch_array($c_sql);
                    if (isset($c_row['name'])) {
                      echo '<span class="text-success font-weight-bold">' . $c_row['name'] . '</span>';
                    } else {
                      echo '<span class="text-danger font-weight-bold">Pending</span>';
                    }
                    ?>
                  </td>
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

  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
</body>

</html>