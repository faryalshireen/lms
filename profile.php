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
  <title>My Profile</title>
</head>

<body>
  <style>
    td {
      border: 1px solid white;
      border-radius: 7px;
    }
  </style>

  <div class="container">
    <div class="row">
      <div class="col-md-5 offset-md-1">
        <h4 class="text-primary mt-2">PERSONAL INFORMATION</h4>
      </div>
      <div class="col-md-5">
        <a class="btn btn-primary btn-sm float-right text-white mt-2" href="update_profile.php">Edit User Profile</a>
      </div>
    </div>
  </div>

  <div class="container mt-2 mb-5 px-3 pl-4 pr-4 align-center">
    <div class="row">
      <div class="table-responsive col-md-10 offset-md-1 card mb-3" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
        <div class="align-center">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Values</th>
              </tr>
            </thead>
            <tbody>
              <?php

              include 'db3.php';
              $user_id = $_SESSION['id'];
              $select = "SELECT * FROM userdata where user_id = '$user_id' ";
              $query = mysqli_query($con, $select);
              while ($result = mysqli_fetch_array($query)) {
              ?>
                <tr>
                  <td>Student Number</td>
                  <td><?php echo $result['Student_number'] ?></td>
                </tr>

                <tr>
                  <td>Full Name</td>
                  <td><?php echo $result['First'] . ' ' . $result['Last'] ?></td>
                </tr>

                <tr>
                  <td>Seat #</td>
                  <td><?php echo $result['Seat'] ?></td>
                </tr>
                <tr>
                  <td>Section #</td>
                  <td><?php echo $result['section'] ?></td>
                </tr>

                <td>CNIC</td>
                <td><?php echo $result['CNIC'] ?></td>
                </tr>

                <tr>
                  <td>Mobile Number</td>
                  <td><?php echo $result['Mobile'] ?></td>
                </tr>

                <tr>
                  <td>Date of Birth</td>
                  <td><?php echo $result['DOB'] ?></td>
                </tr>

                <tr>
                  <td>Semester</td>
                  <td><?php echo $result['Semester'] ?></td>
                </tr>

                <tr>
                  <td>Gender</td>
                  <td><?php echo $result['Gender'] ?></td>
                </tr>

                <tr>
                  <td>Domicile</td>
                  <td><?php echo $result['Domicile'] ?></td>
                </tr>

                <tr>
                  <td>Province</td>
                  <td><?php echo $result['Province'] ?></td>
                </tr>

                <tr>
                  <td>Postal Code</td>
                  <td><?php echo $result['Postal Code'] ?></td>
                </tr>

                <tr>
                  <td>Residential Address</td>
                  <td><?php echo $result['Address'] ?></td>
                </tr>

                <tr>
                  <td>City</td>
                  <td><?php echo $result['City'] ?></td>
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