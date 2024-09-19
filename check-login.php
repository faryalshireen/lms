<?php
session_start();
include "db_connect.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $username = test_input($_POST['username']);
  $password = test_input($_POST['password']);
  // $role_id = test_input($_POST['role_id']);
  if (empty($username)) {
    header("Location:login.php?error=Username or Email is Required");
  } else if (empty($password)) {
    header("Location:login.php?error=Password is Required");
  } else {
    // Old Hashing password with MD5
    // $password = md5($password);
    // Hasing the password with SHA1
    $password = sha1($password);
    // Username or email sql query to login
    $sql = "SELECT * FROM `users` WHERE username='$username' OR email ='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 1) {
      // the user name must be unique
      $row = mysqli_fetch_assoc($result);
      if ($row['password'] === $password) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['role_id'] = $row['role_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['message'] = '';
        $_SESSION['timestamp'] = time();
        // $_SESSION['IS_LOGIN']='yes';
        $role_id = $row['role_id'];
        $status = $row['is_active'];
        // Session Store User Section Starts Here
        $c_query = "SELECT * FROM `userdata` WHERE user_id= '{$row['id']}'";
        $c_sql = mysqli_query($conn, $c_query);
        $c_row = mysqli_fetch_array($c_sql);
        $_SESSION['user_section'] = $c_row['section'];
        $_SESSION['user_batch'] = $c_row['student_batch'];
        // Session Store User Section Ends Here
        if ($status == 1) {
          if ($role_id == 2) {
            header("location:teacher_dashboard.php");
          } else if ($role_id == 1) {
            header("location:admindashboard.php");
          } else if ($role_id = 3) {
            header("location:userdashboard.php");
          } else {
            header("location:login.php?error=not login");
          }
        } else {
          header("location:login.php?error=Your Account is blocked");
        }
        //  if($role_id='user'){
        //     header("location:userdashboard.php");
        //  }else{
        //     header("location:login.php?error=not login");

        //  }
      } else {
        header("Location:login.php?error=Incorrect User name or password");
      }
    } else {
      header("Location:login.php?error=Incorrect User name or password");
    }
  }
} else {
  header("Location:login.php");
}
