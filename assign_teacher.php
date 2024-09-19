<?php
include "link.php";
include "db_connect.php";
include "adminnav.php";
?>

<?php
if (isset($_POST['submit'])) {

  $teacher = $_POST['teacher'];

  $course = $_POST['course'];

  $sql1 = "SELECT * FROM assigned_courses";
  $insert1 = mysqli_query($conn, $sql1);

  $row = mysqli_fetch_assoc($insert1);

  $cid = $row['course_id'];

  $tid = $row['teacher_id'];


  if ($teacher == $tid  && $course == $cid) {
    $sql2 = "SELECT * FROM users WHERE id = '{$tid}'";
    $insert2 = mysqli_query($conn, $sql2);

    $row1 = mysqli_fetch_array($insert2);

    $name = $row1['name'];

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Course is already Assigned! ' . $name . ' 
    <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  } else {


    $sql = "INSERT INTO `assigned_courses` (course_id ,  teacher_id) VALUES ('$course',  '$teacher')";
    $insert = mysqli_query($conn, $sql);
    if ($insert) {
      echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
       Course is  Assigned!  
       <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
    } else {

      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Course is already Assigned!
      <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
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
  .form-group {
    width: 70%;
    display: block;
    margin-left: auto;
    margin-right: auto;
    color: rgb(43, 39, 145);
    font-size: 20px;
    font-weight: bold;

  }

  input[type=text] {
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
</style>

<body>


  <form action="assign_teacher.php" method="POST">
    <div class="form-group">
      <label for="exampleFormControlSelect1">Select Course</label>
      <select class="form-control" name="course" id="exampleFormControlSelect1">
        <?php $select = "SELECT * FROM `teacher_courses`";
        $sql = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_assoc($sql)) { ?>
          <option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
        <?php }
        ?>
      </select>
    </div>

    <!-- <div class="form-group">
    <label for="exampleFormControlSelect1">Select Semester</label>
    <select class="form-control" name="semester" id="exampleFormControlSelect1">
     <?php //$select = "SELECT * FROM `semesters`";
      //$sql=mysqli_query($conn , $select);
      // while($row= mysqli_fetch_assoc($sql)){
      ?>
    <option value="<?php //echo $row['id']; 
                    ?>"><?php //echo $row['semesters']; 
                        ?></option> 
 <?php //} 
  ?> 
    </select>
  </div> -->

    <div class="form-group">
      <label for="exampleFormControlSelect1">Select Teacher</label>
      <select class="form-control" name="teacher" id="exampleFormControlSelect1">
        <?php $select = "SELECT * FROM `users` WHERE role_id = '2'";
        $sql = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_assoc($sql)) { ?>
          <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php }
        ?>
      </select>
    </div>

    <div class="form-group">

      <div class="row">
        <div class="col-lg-4 mt-5">
          <button name="submit" class="btn  active  " role="button" aria-pressed="true" style="color:rgb(43, 39, 145); background-color:rgb(134, 198, 247);  ">Assign Course</button>
        </div>

      </div>
    </div>



  </form>

</body>

</html>