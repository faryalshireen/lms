<?php

include "db_connect.php";

if(isset($_POST['submit'])){
    echo $name;
    $name=$_POST['name'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $department=$_POST['department'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $role_id = $_POST['role_id'];
    if ($password == $cpassword) {
      $sql= "INSERT INTO users (role_id, username, email, password, name, department) VALUES ('{$role_id}', '{$username}', '{$email}', MD5('{$password}'), '{$name}', '$department');";
      $insert=mysqli_query($conn , $sql);
  if($insert){
      echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
       Your Account Has been Created!
      <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }else {
      echo "not";
  }
    }else{
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Password do not Match
      <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }


}

?>