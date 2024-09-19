<?php
include "adminnav.php";
include "db_connect.php";


?>

<style>
  .number {

    width: 25px;
    height: 25px;
    border: 0.5px solid rgb(188, 187, 187);
    text-align: center;
    border-radius: 10px;
    font-size: 15px;
    ;

  }

  .btn {
    /* border: 2px solid rgb(188, 187, 187); */
    color: rgb(43, 39, 145);
  }

  .btn:hover {
    background-color: rgb(134, 198, 247);
    border: none;
  }

  .head {
    /* height:auto; */
    border: 0px;
    border-top: 1px solid black;
    position: relative;
    bottom: 24px;
    background-color: rgb(198, 203, 245);
  }

  .headings {
    margin-top: 40px;
    margin-left: 40px;
  }

  input[type=checkbox],
  input[type=radio] {
    box-sizing: border-box;
    padding: 0;
    width: 20px;
    height: 20px;
    position: relative;
    left: 243px;
    top: 2px;
  }

  td.button-td {
    display: flex;
  }

  h5 button {
    font-size: 23px !important;
    color: #000 !important;
  }

  button,
  .btn {
    box-shadow: none !important;
  }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Courses</title>
</head>

<body>

  <div class="container">

    <div id="accordion">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Courses of Semester 1
            </button>
          </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 1";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
                  ?>



              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Courses of Semester 2
            </button>
          </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 2";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
                  ?>



              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Courses of Semester 3
            </button>
          </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 3";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
                  ?>



              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header" id="headingFour">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
              Courses of Semester 4
            </button>
          </h5>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 4";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
                  ?>



              </tbody>
            </table>
          </div>
        </div>
      </div>


      <div class="card">
        <div class="card-header" id="headingFive">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
              Courses of Semester 5
            </button>
          </h5>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 5";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
                  ?>



              </tbody>
            </table>
          </div>
        </div>
      </div>


      <div class="card">
        <div class="card-header" id="headingSix">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
              Courses of Semester 6
            </button>
          </h5>
        </div>
        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 6";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
                  ?>



              </tbody>
            </table>
          </div>
        </div>
      </div>



      <div class="card">
        <div class="card-header" id="headingSeven">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
              Courses of Semester 7
            </button>
          </h5>
        </div>
        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 7";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
                  ?>



              </tbody>
            </table>
          </div>
        </div>
      </div>



      <div class="card">
        <div class="card-header" id="headingEight">
          <h5 class="mb-0 text-center">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
              Courses of Semester 8
            </button>
          </h5>
        </div>
        <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Course</th>
                  <th scope="col">Credit Hour</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM teacher_courses WHERE semesters = 8";
                $insert = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($insert)) {
                  $code = $row['course_code'];
                  $course = $row['courses_heading'];
                  $hour = $row['credit']
                ?>
                  <tr>

                    <td><?php echo $code; ?></td>
                    <td><?php echo $course; ?></td>
                    <td><?php echo $hour; ?></td>
                  </tr>
                  <tr>

                  <?php }
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


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

</body>

</html>