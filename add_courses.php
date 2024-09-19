<?php
include "adminnav.php";
include "db_connect.php";
?>

<?php
// Delete Course
if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $sql = "DELETE FROM `teacher_courses` WHERE `id` = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   Deleted Successfully!
     <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>';
    }
}
// Edit and Add Course
if (isset($_POST['snoEdit'])) {
    $editno = $_POST['snoEdit'];
    $editcourse = $_POST['course'];
    $editsemester = $_POST['e_semester'];
    $editcredit = $_POST['e_credit_hour'];
    $sql = "UPDATE `teacher_courses` SET `courses_heading` = '$editcourse' , `semesters` = '$editsemester', `credit` ='$editcredit'  WHERE `teacher_courses`.`id` = $editno";

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
} else {
    if (isset($_POST['submit'])) {
        $semester = $_POST['e_semester'];
        $course_heading = $_POST['heading'];
        $credit_hour = $_POST['e_credit_hour'];
        $sql = "INSERT INTO `teacher_courses` (courses_heading, credit, semesters) VALUES ('$course_heading', '$credit_hour', '$semester')";
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

// Assign Course to Teacher
if (isset($_POST['assignTeacher'])) {
    $assignId = $_POST['assignId'];
    $teacherId = $_POST['teacherId'];
    $a_course_sectionId = $_POST['course_section'];
    // $sql = "UPDATE `teacher_courses` SET `teacher_id` = '$teacherId'  WHERE `teacher_courses`.`id` = $assignId";

    $c_select = "SELECT * FROM `teacher_courses` WHERE id='{$assignId}'";
    $c_query = mysqli_query($conn, $c_select);
    $c_row = mysqli_fetch_array($c_query);
    // echo mysqli_num_rows($c_query) . '-----';
    // echo $a_course_sectionId . '-----';
    // echo $c_row[$a_course_sectionId];

    if (!empty($c_row[$a_course_sectionId])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Course Already Assigned. Please un-assign First!
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    } else {
        $sql = "UPDATE `teacher_courses` SET `$a_course_sectionId` = '$teacherId'  WHERE `teacher_courses`.`id` = $assignId";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Teacher Assigned successfully!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Failed to Assigned course!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
    }
}

// Unassign Course to Teacher
if (isset($_POST['unAssignTeacher'])) {
    $c_id = $_POST['un_assignId'];
    $ass_section_id = $_POST['un_course_section'];
    $sql1 = "UPDATE `teacher_courses` SET `$ass_section_id` = NULL WHERE `teacher_courses`.`id`='$c_id'";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Teacher Unassigned Successfully!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        echo "not";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Courses</title>
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

        /* .btn {
            border: 2px solid rgb(188, 187, 187);
            color: rgb(43, 39, 145);
        } */

        /* .btn:hover {
            background-color: rgb(134, 198, 247);
            border: none;
        } */

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
    </style>
</head>

<body>
    <!-- Modal Edit Form Starts Here -->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Course</h5>
                    <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="Add_courses.php" method="POST">
                        <input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Course Name</label>
                            <input type="text" name="course" class="form-control" id="course" aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Select Semester</label>
                            <select class="form-control" name="e_semester" id="e_semester">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Credit Hours</label>
                            <input type="text" name="e_credit_hour" class="form-control" id="e_credit_hour" Required>
                        </div>
                        <button name="submit" type="submit" class="btn btn-success btn-sm float-right" role="button" aria-pressed="true">Update Details</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Edit Form Ends Here -->
    <!-- Modal Assign Course Starts Here -->
    <div class="modal fade" id="AssignModal" tabindex="-1" role="dialog" aria-labelledby="AssignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AssignModalLabel">Assign Course - Teacher</h5>
                    <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_courses.php" method="POST">
                        <input type="hidden" class="hidden" id="assignId" name="assignId">
                        <div class="form-group">
                            <label>Select Teacher</label>
                            <select class="form-control" name="teacherId">
                                <?php $select = "SELECT * FROM `users` WHERE role_id = '2'";
                                $sql = mysqli_query($conn, $select);
                                while ($row = mysqli_fetch_assoc($sql)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php }
                                ?>
                            </select>
                            <label>Course Section</label>
                            <select class="form-control" name="course_section">
                                <option value="section_a">Secion A</option>
                                <option value="section_b">Secion B</option>
                                <option value="section_c">Secion C</option>
                                <option value="section_d">Secion D</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button name="assignTeacher" type="submit" class="btn btn-success btn-sm float-right mt-4">Assign Teacher</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Assign Course Ends Here -->
    <!-- Modal Unassign Course Starts Here -->
    <div class="modal fade" id="UnAssignModal" tabindex="-1" role="dialog" aria-labelledby="UnAssignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UnAssignModalLabel">Un-Assign Teacher</h5>
                    <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_courses.php" method="POST">
                        <input type="hidden" class="hidden" id="un_assignId" name="un_assignId">
                        <div class="form-group">
                            <label>Select Section</label>
                            <select class="form-control" name="un_course_section">
                                <option value="section_a">Secion A</option>
                                <option value="section_b">Secion B</option>
                                <option value="section_c">Secion C</option>
                                <option value="section_d">Secion D</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button name="unAssignTeacher" type="submit" class="btn btn-success btn-sm float-right mt-4">Save Changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Unassign Course Ends Here -->


    <div class="container mb-2 col-lg-12 col-md-12 col-sm-12">
        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="text-primary pt-1 pb-2 pl-2">Manage Courses</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary btn-sm float-right mt-1 text-white" href="admin_assign_courses.php">View Assigned Teachers</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="table-responsive col-lg-12 col-md-12 col-sm-6 mb-5">
                <!-- <h4 class="text-primary pt-3 pb-2 pl-2">Manage Courses</h4> -->
                <div class="align-center text-center card pl-4 pr-4 pb-3 pt-3">
                    <table class="table" id="teacherAssignedTable">
                        <thead>
                            <tr>
                                <th scope="col">Sr.</th>
                                <th scope="col">Code</th>
                                <th scope="col">Course</th>
                                <th scope="col">Semester</th>
                                <th scope="col" style="display: none;">Display_none</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $c = 1;
                            $sql = "SELECT * FROM `teacher_courses` ORDER BY semesters";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                // echo $row['id'];
                                // echo $row['courses_heading'];
                                $heading = $row['courses_heading'];
                                $semester = $row['semesters'];
                                $credit_hour = $row['credit'];
                                //    $string = strip_tags($des);
                                //    if(strlen($string)>50){
                                //     $srtingcut=substr($string,0,100);
                                //     $endpoint=strrpos($srtingcut,' ');
                                //     $string=$endpoint?substr($srtingcut,0,$endpoint):substr($srtingcut,0);
                                //     $string.='...';
                                //    }
                            ?>

                                <!-- <div class="col-sm-4"> -->
                                <tr>
                                    <td><?php echo $c++; ?> </td>
                                    <td><?php echo $row['course_code']; ?></td>
                                    <td><?php echo $heading; ?></td>
                                    <td><?php echo $semester; ?></td>
                                    <td style="display: none !important;"><?php echo $credit_hour; ?></td>
                                    <td class="button-td mr-2">
                                        <button type="button" data-toggle="modal" data-target="#viewAssignedTeachers<?php echo $row['id'] ?>" class="btn btn-info btn-sm btn-inline text-light mr-1">View</button>
                                        <!-- Modal Starts Here -->
                                        <div class="modal fade" id="viewAssignedTeachers<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewAssignedTeachersTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Assigned Teacher - Course</h5>
                                                        <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped text-left">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Section A</th>
                                                                    <td>
                                                                        <?php
                                                                        $user_query = "SELECT * FROM `users` WHERE id= '{$row['section_a']}'";
                                                                        $user_sql = mysqli_query($conn, $user_query);
                                                                        $user_row = mysqli_fetch_array($user_sql);
                                                                        if (!empty($user_row['name'])) {
                                                                            echo $user_row['name'];
                                                                        } else {
                                                                            echo '<span class="badge badge-danger">Not Assigned</span>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Section B</th>
                                                                    <td>
                                                                        <?php
                                                                        $user_query = "SELECT * FROM `users` WHERE id= '{$row['section_b']}'";
                                                                        $user_sql = mysqli_query($conn, $user_query);
                                                                        $user_row = mysqli_fetch_array($user_sql);
                                                                        if (!empty($user_row['name'])) {
                                                                            echo $user_row['name'];
                                                                        } else {
                                                                            echo '<span class="badge badge-danger">Not Assigned</span>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Section C</th>
                                                                    <td>
                                                                        <?php
                                                                        $user_query = "SELECT * FROM `users` WHERE id= '{$row['section_c']}'";
                                                                        $user_sql = mysqli_query($conn, $user_query);
                                                                        $user_row = mysqli_fetch_array($user_sql);
                                                                        if (!empty($user_row['name'])) {
                                                                            echo $user_row['name'];
                                                                        } else {
                                                                            echo '<span class="badge badge-danger">Not Assigned</span>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Section D</th>
                                                                    <td>
                                                                        <?php
                                                                        $user_query = "SELECT * FROM `users` WHERE id= '{$row['section_d']}'";
                                                                        $user_sql = mysqli_query($conn, $user_query);
                                                                        $user_row = mysqli_fetch_array($user_sql);
                                                                        if (!empty($user_row['name'])) {
                                                                            echo $user_row['name'];
                                                                        } else {
                                                                            echo '<span class="badge badge-danger">Not Assigned</span>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal End Here -->
                                        <button class="UnAssign btn btn-mint btn-sm btn-inline text-light mr-1" id=<?php echo $row['id'] ?> name="unassign">Unassign</button>
                                        <button class="Assign btn btn-secondary btn-sm btn-inline text-light" id=<?php echo $row['id'] ?> name="assign">Assigned</button>
                                        <button class="Edit btn btn-primary btn-sm btn-inline text-light mr-1 ml-1" id=<?php echo $row['id'] ?> name="edit">Edit</button>
                                        <button class="Delete btn btn-danger btn-sm btn-inline text-light" id=<?php echo $row['id'] ?> name="delete">Delete</button>
                                    </td>
                                </tr>
                                <!-- </div> -->
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
            $('#teacherAssignedTable').DataTable();
        });
    </script>
    <script>
        // Assign Modal
        assignCourse = document.getElementsByClassName('Assign');
        Array.from(assignCourse).forEach((element) => {
            element.addEventListener("click", (e) => {
                assignId.value = e.target.id;
                console.log(e.target.id);
                $('#AssignModal').modal('toggle');
            })
        })
        // UnAssign Modal
        assignCourse = document.getElementsByClassName('UnAssign');
        Array.from(assignCourse).forEach((element) => {
            element.addEventListener("click", (e) => {
                un_assignId.value = e.target.id;
                console.log(e.target.id);
                $('#UnAssignModal').modal('toggle');
            })
        })
        // Edit Modal
        edits = document.getElementsByClassName('Edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("Edit");
                tr = e.target.parentNode.parentNode;
                courses = tr.getElementsByTagName("td")[2].innerText;
                semester = tr.getElementsByTagName("td")[3].innerText;
                credit_hour = tr.getElementsByTagName("td")[4].innerText;

                // console.log(courses, semester, credit_hour);
                course.value = courses;
                e_semester.value = semester;
                e_credit_hour.value = credit_hour;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#EditModal').modal('toggle');
            })
        })
        // Delete Modal
        deletes = document.getElementsByClassName('Delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("Delete");
                id = e.target.id.substr(0);
                if (confirm("Are you sure you want to delete this Course?")) {
                    console.log("yes");
                    window.location = `add_courses.php?Delete=${id}`;
                } else {
                    console.log("no");
                }

            })
        })
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>