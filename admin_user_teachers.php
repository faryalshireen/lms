<?php
include "adminnav.php";
include "link.php";
include "db_connect.php";
?>

<?php

if (isset($_POST['block'])) {
    $tid = $_GET['block'];
    $sql1 = "UPDATE `users` SET `is_active` = '0' WHERE `users`.`id`='$tid'";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
Account Blocked!
  <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    } else {
        echo "not";
    }
}
if (isset($_POST['unblock'])) {
    $tid = $_GET['unblock'];
    $sql1 = "UPDATE `users` SET `is_active` = '1' WHERE `users`.`id`='$tid'";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
Account Unblocked!
  <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    } else {
        echo "not";
    }
}


if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $sql = "DELETE FROM `users` WHERE `id` = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
     User Deleted Successfully!
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
    $u_password = sha1($_POST['t_passwordedit']);
    $u_confirmPassword = sha1($_POST['t_cpasswordedit']);

    if ($u_password == $u_confirmPassword) {
        if (!empty($_POST['t_passwordedit'])) {
            $sql = "UPDATE `users` SET `name` = '$editname' , `department` = '$editdep', `username` ='$editusername' ,`email`= '$editemail', `password`= '$u_password' WHERE `users`.`id` = $editno";
        } else {
            $sql = "UPDATE `users` SET `name` = '$editname' , `department` = '$editdep', `username` ='$editusername' ,`email`= '$editemail' WHERE `users`.`id` = $editno";
        }
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
       Updated successfully!
       <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
        } else {
            echo "not updated";
        }
    } else if ($u_password != $u_confirmPassword) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   Password not match!
    <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    } else if (empty($u_password)) {
        $sql = "UPDATE `users` SET `name` = '$editname' , `department` = '$editdep', `username` ='$editusername' ,`email`= '$editemail' WHERE `users`.`id` = $editno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
         Updated successfully!
         <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>';
        } else {
            echo "not updated";
        }
    }
} else {
    if (isset($_POST['submit'])) {
        $teacher_name = $_POST['t_name'];
        $teacher_username = $_POST['t_username'];
        $teacher_email = $_POST['t_email'];
        $teacher_department = $_POST['t_department'];
        $teacher_password = $_POST['t_password'];
        $teacher_cpassword = $_POST['t_cpassword'];
        $teacher_role = 2;
        if ($teacher_password == $teacher_cpassword) {
            $sql = "INSERT INTO users (role_id, username, email, password, name, department) VALUES ('{$teacher_role}', '{$teacher_username}', '{$teacher_email}', MD5('{$teacher_password}'), '{$teacher_name}', '$teacher_department')";
            $insert = mysqli_query($conn, $sql);
            if ($insert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
         Added!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
            } else {
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
    <title>Manage Users</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

</head>
<style>
    .table tbody tr:hover td {
        background-color: #ffffa2;
        border-color: #ffff0f;
    }
</style>

<body>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> -->

    <!-- Modal Edit User Starts here-->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="box-shadow: none !important;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_user_teachers.php" method="POST">
                        <input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="t_nameedit" class="form-control" id="t_nameedit" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Username</label>
                            <input type="text" name="t_usernameedit" class="form-control" id="t_usernameedit">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Email Address</label>
                            <input type="email" name="t_emailedit" class="form-control" id="t_emailedit">
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
                        <button type="submit" class="btn btn-success float-right mb-2 btn-sm">Update Changes</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Edit User Ends here -->


    <div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="text-primary ml-2 pb-2">Manage Users</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary btn-sm float-right text-white" href="admin_add_users.php">Add New Users</a>
            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row pl-3 pr-3 mb-3">
            <div class="col-md-12 card p-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="all_students_tab" href="admin_user_students.php">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="all_teachers_tab" href="admin_user_teachers.php">Teachers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="all_admins_tab" href="admin_users.php">Admins</a>
                    </li>
                </ul>
                <div class="align-center mt-4">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">Sr.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Email</th>
                                <th scope="col">Username</th>
                                <th scope="col">Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $c = 1;
                        // $sql = "SELECT * FROM users WHERE role_id IN (2, 3)";
                        $sql = "SELECT * FROM users WHERE role_id=2";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // echo $row['id'];
                            // echo $row['courses_heading'];
                            $id = $row['id'];
                            $name = $row['name'];
                            $department = $row['department'];
                            $email = $row['email'];
                            $username = $row['username'];
                            $status = $row['is_active'];
                            $user_roleId = $row['role_id'];
                        ?>
                            <div class="container">
                                <tr>
                                    <td><?php echo $c++ ?></td>
                                    <td><?php echo $name ?></td>
                                    <td><?php echo $department ?></td>
                                    <td><?php echo $email ?></td>
                                    <td><?php echo $username ?></td>
                                    <td>
                                        <?php
                                        if (isset($user_roleId) && $user_roleId == 1) {
                                            echo 'Admin';
                                        } else if (isset($user_roleId) && $user_roleId == 2) {
                                            echo 'Teacher';
                                        } else {
                                            echo 'Student';
                                        }
                                        ?>
                                    </td>
                                    <td style="display: inline-flex;">
                                        <button class="Edit btn btn-info btn-sm" data-toggle="modal" data-target="#EditModal" id=<?php echo $row['id'] ?>>Edit</button>
                                        <button class="Delete btn btn-danger btn-sm ml-1 mr-1" name="delete" id=<?php echo $row['id'] ?>>Delete</button>
                                        <?php
                                        if ($status == 1) {
                                            echo '<form action="admin_user_teachers.php?block=' . $row['id'] . '" method="POST">
                                            <button class="btn btn-primary btn-sm" type="submit" name="block">Block</button>
                                            </form>';
                                        } else {
                                            echo '<form action="admin_user_teachers.php?unblock=' . $row['id'] . '" method="POST">
                                            <button class="btn btn-success btn-sm" type="submit" name="unblock">Unblock</button>
                                            </form>';
                                        ?>
                                    <?php
                                        }
                                        echo '</td></tr></div>';
                                    }
                                    ?>
                    </table>
                </div>
            </div>
        </div>

        <button onclick="window.print()" class="btn btn-warning btn-sm pr-3 pl-3">Print</button>
        <a href="export_to_excel.php?id=2" class="btn btn-warning btn-sm pl-3 pr-3">Export Excel</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $(' #myTable').DataTable();
        });
    </script>
    <script>
        // Edit User
        edits = document.getElementsByClassName('Edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                name = tr.getElementsByTagName("td")[1].innerText;
                department = tr.getElementsByTagName("td")[2].innerText;
                email = tr.getElementsByTagName("td")[3].innerText;
                username = tr.getElementsByTagName("td")[4].innerText;
                console.log(name, department, email, username);
                t_nameedit.value = name;
                t_departmentedit.value = department;
                t_emailedit.value = email;
                t_usernameedit.value = username;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#EditModal').modal('toggle');
            })
        })
        // Delete User
        deletes = document.getElementsByClassName('Delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                id = e.target.id.substr(0);
                if (confirm("Are you sure you want to delete this User?")) {
                    console.log("yes");
                    window.location = `admin_user_teachers.php?Delete=${id}`;
                } else {
                    console.log("no");
                }

            })
        })
    </script>


</body>

</html>