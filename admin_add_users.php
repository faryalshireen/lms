<?php
include "link.php";
include "db_connect.php";
include "adminnav.php";
?>
<?php
if (isset($_POST['submit'])) {
  $teacher_name = $_POST['t_name'];
  $teacher_username = $_POST['t_username'];
  $teacher_email = $_POST['t_email'];
  $teacher_department = $_POST['t_department'];
  $teacher_password = sha1($_POST['t_password']);
  $teacher_cpassword = sha1($_POST['t_cpassword']);
  $teacher_role = $_POST['rold_assign_id'];
  $user_active_status = 1;
  // Check Email Existed
  $email_existed = "SELECT * FROM `users` WHERE email='{$teacher_email}'";
  $q_existed = mysqli_query($conn, $email_existed);
  // Check Password Format
  $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

  if (preg_match($password_regex, $_POST['t_password']) != 1) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Password Must contain atleast 8 characters in legth, uppercase, lowercase, digit and special character!
   <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
 </div>';
  } else if (mysqli_num_rows($q_existed) >= 1) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    User Email Already Existed!
   <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
 </div>';
  } else if ($teacher_password == $teacher_cpassword) {
    // $sql = "INSERT INTO users (role_id, username, email, password, name, department) VALUES ('{$teacher_role}', '{$teacher_username}', '{$teacher_email}', MD5('{$teacher_password}'), '{$teacher_name}', '$teacher_department');";
    // $insert = mysqli_query($conn, $sql);
    $inserted = "INSERT INTO `users` (`role_id`,`username`,`email`,`password`,`name`,`department`,`is_active`) VALUES ('$teacher_role','$teacher_username','$teacher_email', '$teacher_password','$teacher_name', '$teacher_department', '$user_active_status')";
    $query = mysqli_query($conn, $inserted);
    $userdata__generatedId = mysqli_insert_id($conn);
    $a_user_sectionID = $_POST['user_sectionId'];
    $a_user_batchID = date('y');
    if ($query) {
      if (isset($_POST['rold_assign_id']) && $_POST['rold_assign_id'] == 3) {
        $sql_update = "INSERT INTO `userdata` (`Student_number`, `First`, `Last`, `CNIC`, `DOB`, `Mobile`, `Gender`, `Domicile`, `Province`, `Postal Code`, `Address`, 
      `City`, `Seat`, `Semester`, `user_id`, `section`, `student_batch`) VALUES ('$userdata__generatedId', 'null', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '$userdata__generatedId', '$a_user_sectionID', '$a_user_batchID')";
        $query_userdata = mysqli_query($conn, $sql_update);
      }
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
       User Created Successfully!
      <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
?>
      <script>
        setTimeout(() => {
          window.location = `admin_user_students.php`;
        }, 1000);
      </script>
<?php
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       User Failed to Create!
      <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
  } else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Password do not Match
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
  <title>Add Users</title>
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<!-- <style>
  .form-group {
    width: 50%;
    display: block;
    margin-left: auto;
    margin-right: auto;
    color: rgb(43, 39, 145);
    font-size: 20px;
    font-weight: bold;

  }

  input[type=text],
  input[type=email] {
    border: none;
    border-bottom: 1px solid rgb(43, 39, 145);
    background-color: #f8f9fc;
    border-radius: 0px;
  }

  .btn {
    border: 2px solid rgb(188, 187, 187);
    color: rgb(43, 39, 145);
    background-color: rgb(134, 198, 247);
    font-weight: bold;
  }

  .btn:hover {
    background-color: rgb(134, 198, 247);
    border: none;
  }
</style> -->

<body>

  <div class="container">
    <div class="row">
      <form action="admin_add_users.php" method="POST" class="mt-2">
        <div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
          <h4 class="text-primary mb-3 mt-3">Create New User</h4>
          <div class="mt-2">
            <label>Name</label>
            <input type="text" name="t_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
          </div>
          <div class="mt-2">
            <label>Username</label>
            <input type="text" name="t_username" class="form-control" id="exampleInputPassword1" Required>
          </div>
          <div class="mt-2">
            <label>Email Address</label>
            <input type="email" name="t_email" class="form-control" id="exampleInputPassword1" Required>
          </div>
          <div class="mt-2">
            <label>User Type</label>
            <select class="form-control" name="rold_assign_id">
              <option value="1">Admin</option>
              <option value="2">Teacher</option>
              <option value="3">Student</option>
            </select>
          </div>
          <div class="mt-2">
            <label>User Section</label>
            <select class="form-control" name="user_sectionId">
              <option value="a">Section A</option>
              <option value="b">Section B</option>
              <option value="c">Section C</option>
              <option value="d">Section D</option>
            </select>
          </div>
          <small>Please note that this section is for Students only.</small>
          <div class="mt-2">
            <label>Department</label>
            <input type="text" name="t_department" class="form-control" id="exampleInputPassword1" Required>
          </div>
          <div class="mt-2">
            <label>Password</label>
            <input type="password" name="t_password" class="form-control" id="exampleInputPassword1" Required>
          </div>
          <div class="mt-2">
            <label>Confirm Password</label>
            <input type="password" name="t_cpassword" class="form-control" id="exampleInputPassword1" Required>
          </div>
          <div class="float-right w-100 text-right">
            <a href="admin_user_students.php" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Users</a>
            <button name="submit" class="btn btn-success btn-sm" role="button" aria-pressed="true">Add New User</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</body>

</html>