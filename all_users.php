<?php
//include "studentnav.php";
include "link.php";
include "db_connect.php";
?>

<?php

if(isset($_POST['block'])){
  $tid = $_GET['block'];
  $sql1="UPDATE `users` SET `is_active` = '0' WHERE `users`.`id`='$tid'" ;
  $result1=mysqli_query($conn,$sql1);
  if($result1){
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
Account Blocked!
  <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
 
  }else{
    echo "not";
  }

} 
if(isset($_POST['unblock'])){
  $tid = $_GET['unblock'];
  $sql1="UPDATE `users` SET `is_active` = '1' WHERE `users`.`id`='$tid'" ;
  $result1=mysqli_query($conn,$sql1);
  if($result1){
echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
Account Unblocked!
  <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }else{
    echo "not";
  }

} 


if (isset($_GET['Delete'])) {
  $id = $_GET['Delete'];
  $sql = "DELETE FROM `users` WHERE `id` = '{$id}'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
     Deleted Successfully!
       <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
  }
}
if (isset($_POST['snoEdit'])) {
  $editno = $_POST['snoEdit'];
  $editname = $_POST['t_nameedit'];
  $editdep = $_POST['t_departmentedit'];
  $editemail = $_POST['t_emailedit'];
  $editusername = $_POST['t_usernameedit'];
  $sql = "UPDATE `users` SET `name` = '$editname' , `department` = '$editdep', `username` ='$editusername' ,`email`= '$editemail' WHERE `users`.`id` = $editno";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
       Updated successfully!
       <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
  } else {
    echo "not updated";
   }
} else {
    if (isset($_POST['submit'])) {
      $teacher_name=$_POST['t_name'];
      $teacher_username=$_POST['t_username'];
      $teacher_email=$_POST['t_email'];
      $teacher_department=$_POST['t_department'];
      $teacher_password=$_POST['t_password'];
      $teacher_cpassword=$_POST['t_cpassword'];
      $teacher_role = 2;
      if ($teacher_password == $teacher_cpassword) {
        $sql= "INSERT INTO users (role_id, username, email, password, name, department) VALUES ('{$teacher_role}', '{$teacher_username}', '{$teacher_email}', MD5('{$teacher_password}'), '{$teacher_name}', '$teacher_department')";
        $insert=mysqli_query($conn , $sql);
    if($insert){
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
         Added!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }else {
        echo "not";
    }
   }
}
}
?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
crossorigin="anonymous"></script>
</head>

<body>

  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> -->

  <!-- Modal -->
  <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="all_users.php" method="POST">
          <input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" name="t_nameedit" class="form-control" id="t_nameedit" aria-describedby="emailHelp" >
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Username</label>
              <input type="text" name="t_usernameedit" class="form-control" id="t_usernameedit" >
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Email Address</label>
              <input type="email" name="t_emailedit" class="form-control" id="t_emailedit" >
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Department</label>
              <input type="text" name="t_departmentedit" class="form-control" id="t_departmentedit">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="t_passwordedit" class="form-control" id="t_passwordedit">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Confirm Password</label>
              <input type="password" name="t_cpasswordedit" class="form-control" id="t_cpasswordedit">
            </div>
            <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit"  class="btn btn-primary">Save changes</button>
        </div>    
</form>
</div>
        
      </div>
    </div>
  </div>
  <div class="container">
    <table class="table" id="myTable">
      <thead>
        <tr>
          
          <th scope="col"> Names</th>
          <th scope="col"> Emails</th>
          <th scope="col">Username</th>
          

        </tr>
      </thead>
      <?php
      $role_id = 2;
      $sql = "SELECT * FROM users ";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        // echo $row['id'];
        // echo $row['courses_heading'];

        $id = $row['id'];
        $name = $row['name'];

        $email = $row['email'];
        $username=$row['username'];
        $status = $row['is_active'];
        echo '<div class="container">   
  <tr>
    
    <td>' . $name . '</td>
    
    <td>' . $email . '</td>
    <td>' . $username . '</td>
 
    <td><button class="Edit btn bg-white" data-toggle="modal" data-target="#EditModal" id=' . $row['id'] . '>Edit</button>
    <button class="Delete btn bg-white"  id=' . $row['id'] . ' name="delete">Delete</button></td>
    <td>
  </tr>
</div>
';
  
      }

          

      ?>
    </table>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
 
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('Edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Edit");
        tr = e.target.parentNode.parentNode;
        name = tr.getElementsByTagName("td")[0].innerText;
        department = tr.getElementsByTagName("td")[1].innerText;
        email = tr.getElementsByTagName("td")[2].innerText;
        username = tr.getElementsByTagName("td")[3].innerText;
        console.log(name, department,email,username);
        t_nameedit.value = name;
        t_departmentedit.value = department;
        t_emailedit.value = email;
        t_usernameedit.value = username;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#EditModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('Delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Delete");
        id = e.target.id.substr(0);
        if (confirm("Are you sure you want to delete this??")) {
          console.log("yes");
          window.location = `all_users.php?Delete=${id}`;
        } else {
          console.log("no");
        }

      })
    })
  </script>


</body>

</html>