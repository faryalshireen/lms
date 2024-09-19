<?php
include "link.php";
include "db_connect.php";

?>
<?php
if(isset($_POST['submit'])){
    $teacher_name=$_POST['t_name'];
    $teacher_username=$_POST['t_username'];
    $teacher_email=$_POST['t_email'];
    $teacher_department=$_POST['t_department'];
    $teacher_password=$_POST['t_password'];
    $teacher_cpassword=$_POST['t_cpassword'];
    $teacher_role = $_POST['role_id'];
    if(!preg_match("/^[a-zA-Z\s]+$/",$teacher_username)){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Use only letters for username
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    // if(strlen($teacher_password>8 )){
    //   echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //   Enter Upto 8 digits only for password
    //   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //     <span aria-hidden="true">&times;</span>
    //   </button>
    // </div>';
    // }
    // if(!preg_match("/^\w*(?=\w*\d)(?=\w*[A-Z])(?=\w*[^0-9A-Za-z])(?=\w*[a-z])\w*$/",$teacher_password)|| strlen($teacher_password>13)){
    //   echo "not";
    // }
    if ($teacher_password == $teacher_cpassword) {
      $sql= "INSERT INTO users (role_id, username, email, password, name, department) VALUES ('{$teacher_role}', '{$teacher_username}', '{$teacher_email}', MD5('{$teacher_password}'), '{$teacher_name}', '$teacher_department');";
      $insert=mysqli_query($conn,$sql);
  if($insert){
      echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
       Account Has Been Created!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }else {
      echo "not";
  }
    }else{
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Password do not Match
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
    <title>Document</title>
</head>
<style>
       
  .form-group{
    /* width:50%; */
    display:block;
    /* margin-left:auto;
    margin-right:auto; */
    color:rgb(43, 39, 145);
    font-size:20px;
    font-weight:bold;
    
  } 
  input[type=text], input[type=email]{
    border:none;
    border-bottom:1px solid rgb(43, 39, 145);
    background-color:white;
    border-radius:0px;
  }
  .btn{
border: 2px solid rgb(188, 187, 187); 
  color:rgb(43, 39, 145);
  background-color:rgb(134, 198, 247);
  font-weight:bold;
}
.btn:hover{
  background-color:rgb(134, 198, 247);
  border: none;
}
.container{
    border:1px solid black;
    width:500px;
    border-radius:20px;

}
 h3 {
    font-size: 2rem;
    position: relative;
    text-align:center;
    color:#053700
    
}
    
</style>

<body>
<form   action="signup.php" method="POST" class="mt-5">
<h3>Signup</h3> 
    <div class="container  justify-content-center align-items-center" style="min-height:10s0vh;">
   
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" name="t_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
  </div>
 
  <div class="form-group">
    <label for="exampleInputPassword1">Username</label>
    <input type="letter" name="t_username" class="form-control" id="exampleInputPassword1" Required>
  </div>  
  <div class="form-group">
    <label for="exampleInputPassword1">Email Address</label>
    <input type="email" name="t_email" class="form-control" id="exampleInputPassword1" Required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Department</label>
    <input type="text" name="t_department" class="form-control" id="exampleInputPassword1" Required>
  </div>
  <div class="form-group mb-3">
    <label for="exampleFormControlSelect1">Select User Type</label>
    <select class="form-control" name="role_id" id="exampleFormControlSelect1">
    <?php $select = "SELECT * FROM `role`";
  $sql=mysqli_query($conn , $select);
  while($row= mysqli_fetch_assoc($sql)){?>
    <option value="<?php echo $row['role_id']; ?>"><?php echo $row['name']; ?></option> 
 <?php }
  ?> 
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="t_password" class="form-control" id="exampleInputPassword1" Required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirm Password</label>
    <input type="password" name="t_cpassword" class="form-control" id="exampleInputPassword1" Required>
  </div>
  <div class="form-group">
    <div class="row">
     <div class="col-lg-6 ">
     <button name="submit" class="btn  active  " role="button" aria-pressed="true" style="color:rgb(43, 39, 145); background-color:rgb(134, 198, 247);  ">Add User</button></div>
     <div class="col-lg-6">
    <a href="all_users.php" class="btn  active  " role="button" aria-pressed="true" style="color:rgb(43, 39, 145); background-color:rgb(134, 198, 247);  ">See All users</a></div>

  </div>
  
</div>

  </div>
</form>    

</body>
</html>