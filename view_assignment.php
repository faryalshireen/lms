<?php
include 'db3.php';
require 'teachernav.php';
?>

<?php
// Add Previous Assignments
if (isset($_POST['add_previousAssignments']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $p_assign_id = $_POST['add_previous_assignments'];
    $user_stdBatch = date('y');
    $p_assign_sql = "INSERT INTO `upload` (`course_id`, `teacher_id`, `Semester`, `title`, `total_marks`, `description`, `deadline`, `file`, `section`, `student_batch`) SELECT `course_id`, '{$_SESSION['id']}', `Semester`, `title`, `total_marks`, `description`, `deadline`, `file`, `section`, '{$user_stdBatch}' FROM `upload` WHERE id = '$p_assign_id'";
    $p_query = mysqli_query($con, $p_assign_sql);
    if (mysqli_affected_rows($con) > 0) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Your Assignment has been Added!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Your Assignment Failed to Add!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

// Delete
if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $sql = "DELETE FROM `upload` WHERE `id` = $id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   Deleted Successfully!
     <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>';
    }
}
// Reassign Assignment
if (isset($_POST['assignment_submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $assign_id = $_POST['ass_assign_id'];
    $reassign_user_stdBatch = date('y');
    $assign_sql = "INSERT INTO `upload` (`course_id`, `teacher_id`, `Semester`, `title`, `total_marks`, `description`, `deadline`, `file`, `section`, `student_batch`) SELECT `course_id`, `teacher_id`, `Semester`, `title`, `total_marks`, `description`, `deadline`, `file`, `section`, '{$reassign_user_stdBatch}' FROM `upload` WHERE id = '$assign_id'";
    $query = mysqli_query($con, $assign_sql);
    if ($query) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Your Assignment Duplicate has been created!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Your Assignment Failed to reassign!
            <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}
// Edit
if (isset($_POST['snoEdit'])) {
    $editno = $_POST['snoEdit'];
    $editCourse = $_POST['a_title'];
    $u_course_id = $_POST['Course'];
    // Semester Query Starts Here
    $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$u_course_id}'";
    $c_sql = mysqli_query($con, $c_query);
    $c_row = mysqli_fetch_array($c_sql);
    $u_semester = $c_row['semesters'];
    // Semester Query Ends Here
    $total_marks = $_POST['total_marks'];
    // File Update Starts Here
    $u_filename = $_FILES['upload_file']['name'];
    $u_filepath = $_FILES['upload_file']['tmp_name'];
    $u_fileerror = $_FILES['upload_file']['error'];
    $u_filesize = $_FILES['upload_file']['size'];
    // $u_file = $_POST['upload_file'];
    $u__param_file = $u_filename;
    move_uploaded_file($u_filepath, $u__param_file);
    // File Update Ends Here
    // $editSemester = $_POST['u_param_semester'];
    $editDisc = $_POST['a_desc'];
    $editDeadline = $_POST['a_deadline'];
    $edit_usection = $_POST['a_userSection'];
    if ($u__param_file) {
        $sql = "UPDATE `upload` SET `title` = '$editCourse', `total_marks` = '$total_marks', `Semester` = '$u_semester', `course_id` = '$u_course_id', `description` ='$editDisc', file ='$u__param_file', `deadline` ='$editDeadline', `section` ='$edit_usection' WHERE `upload`.`id` = $editno";
    } else {
        $sql = "UPDATE `upload` SET `title` = '$editCourse', `total_marks` = '$total_marks', `Semester` = '$u_semester', `course_id` = '$u_course_id', `description` ='$editDisc', `deadline` ='$editDeadline', `section` ='$edit_usection' WHERE `upload`.`id` = $editno";
    }
    $result = mysqli_query($con, $sql);
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>View Assignments</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="text-primary ml-3">View Assignments</h4>
            </div>
            <div class="col-md-6">
                <?php
                if (isset($_GET['id'])) {
                    echo '<a class="btn btn-primary btn-sm float-right text-white" href="upload_assignments.php?id=' . $_GET['id'] . '">Create Assignment</a>';
                } else {
                ?>
                    <a class="btn btn-primary btn-sm float-right text-white" data-toggle="modal" data-target="#createCourseAssignment">Create Assignment</a>
                    <!-- Modal Starts Here -->
                    <div class="modal fade" id="createCourseAssignment" tabindex="-1" role="dialog" aria-labelledby="createCourseAssignmentTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Select Course</h5>
                                    <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="view_assignment.php" method="POST">
                                        <div class="mb-2">
                                            <label>Select Course</label>
                                            <select class="form-control" name="c_courseId" id="c_courseId" required>
                                                <?php include "db_connect.php";
                                                $t_id = $_SESSION['id'];
                                                $select = "SELECT * FROM `teacher_courses` WHERE section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}'";
                                                $sql = mysqli_query($conn, $select);
                                                while ($row = mysqli_fetch_assoc($sql)) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="button" onclick="location.href='upload_assignments.php?id='+document.getElementById('c_courseId').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Continue to Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End Here -->
                <?php
                }
                ?>
                <button class="btn btn-secondary btn-sm float-right text-white mr-1" data-toggle="modal" data-target="#addPreviousAssignments">Add Preivous Assignments</button>

                <!-- Modal Add Previous Assignments Starts Here -->
                <div class="modal fade" id="addPreviousAssignments" tabindex="-1" role="dialog" aria-labelledby="addPreviousAssignmentsTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPreviousAssignmentsTitle">Add Previous Assignments</h5>
                                <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="view_assignment.php?id=<?php echo $_GET['id'] ?>" method="POST">
                                    <div class="mb-2">
                                        <label>Select Assignment</label>
                                        <select class="form-control" name="add_previous_assignments" id="add_previous_assignments">
                                            <?php
                                            $select = "SELECT * FROM `upload` WHERE course_id='{$_GET['id']}' GROUP BY title";
                                            $sql = mysqli_query($conn, $select);
                                            if (mysqli_num_rows($sql) >= 1) {
                                                while ($row = mysqli_fetch_assoc($sql)) {
                                            ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="">No Assignments Found</option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1" name="add_previousAssignments">Add to Listing</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Add Previous Assignments End Here -->

            </div>
        </div>
    </div>
    <div class="container mt-3 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pb-3 pt-3">
            <div class="align-center">
                <table class="table" id="viewAssignmentsTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Title</th>
                            <th class="d-none">Display_none</th>
                            <th scope="col">Course</th>
                            <th class="d-none">Display_none</th>
                            <th scope="col">Deadline</th>
                            <th class="d-none">Display_none</th>
                            <th scope="col">Section</th>
                            <th class="d-none">Display_none</th>
                            <!-- <th scope="col">Marks</th> -->
                            <th scope="col">File</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $t_id = $_SESSION['id'];
                        if (isset($_GET['id'])) {
                            $c_id = $_GET['id'];
                            $select = "SELECT * FROM `upload` WHERE teacher_id= '{$t_id}' AND course_id= '{$c_id}' ORDER BY id DESC";
                        } else {
                            $select = "SELECT * FROM `upload` WHERE teacher_id= '{$t_id}'";
                        }
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                            // $u_param_semester = $result['Semester'];
                            $task = $result['course_id'];
                            $title = $result['title'];
                            $deadline = $result['deadline'];
                            $dat = $result['description'];
                            $total_marks = $result['total_marks'];
                            $fileDownload = $result['file'];
                        ?>
                            <tr>
                                <td><?php echo $c++ ?></td>
                                <td><?php echo substr($result['title'], 0, 20) ?>..</td>
                                <td style="display: none;"><?php echo $title ?></td>
                                <td><?php include "db_connect.php";
                                    $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$result['course_id']}'";
                                    $c_sql = mysqli_query($conn, $c_query);
                                    $c_row = mysqli_fetch_array($c_sql);
                                    $course_id = $c_row['course_code'];
                                    echo $course_id;
                                    ?></td>
                                <td style="display: none;"><?php include "db_connect.php";
                                                            $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$result['course_id']}'";
                                                            $c_sql = mysqli_query($conn, $c_query);
                                                            $c_row = mysqli_fetch_array($c_sql);
                                                            $course_id = $c_row['id'];
                                                            echo $course_id;
                                                            ?></td>
                                <td><?php echo $deadline ?></td>
                                <td style="display: none;"><?php echo $dat ?></td>
                                <td><?php echo $result['section'] ?></td>
                                <td style="display: none;"><?php echo $total_marks ?></td>
                                <td><a target="_blank" href="download.php?file=<?php echo $fileDownload ?>">Download File</br></a></td>
                                <td>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $a_form_action = 'view_assignment.php?id=' . $_GET['id'];
                                    } else {
                                        $a_form_action = 'view_assignment.php';
                                    }
                                    ?>
                                    <form action="<?php echo $a_form_action ?>" method="POST" enctype="multipart/form-data" style="display:inline-block !important;">
                                        <input type="hidden" name="ass_assign_id" id="ass_assign_id" value="<?php echo $result['id'] ?>">
                                        <button type="submit" name="assignment_submit" data-toggle="tooltip" title="re-assign Assignment" class="btn btn-primary btn-sm btn-inline text-light"><i class="fas fa-clone"></i></button>
                                    </form>

                                    <button class="Delete btn btn-danger btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="delete">Delete</button>
                                    <?php
                                    if (isset($result['student_batch']) && $result['student_batch'] == date('y')) {
                                    ?>
                                        <button class="Edit btn btn-secondary btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="edit">Edit</button>
                                        <a href="submit_assignments.php?id=<?php echo $result['id'] ?>" data-toggle="tooltip" title="Submitted Assignments" class="btn btn-info btn-sm btn-inline text-light"><i class="fas fa-tasks"></i></a>
                                        <a href="submit_failed_assignments.php?id=<?php echo $result['id'] ?>" data-toggle="tooltip" title="Repeat Assignments" class="btn btn-secondary btn-sm btn-inline text-light"><i class="fas fa-repeat"></i></a>
                                        <a href="marking.php?id=<?php echo $result['id'] ?>" data-toggle="tooltip" title="Assignment's Result" class="btn btn-success btn-sm btn-inline text-light"><i class="fas fa-bullhorn"></i></a>
                                    <?php
                                    } else {
                                    ?>
                                        <button class="btn btn-secondary btn-sm btn-inline text-light disabled" disabled>Edit</button>
                                        <a href="submit_assignments.php?id=<?php echo $result['id'] ?>" class="btn btn-info btn-sm btn-inline text-light disabled"><i class="fas fa-tasks"></i></a>
                                        <a href="marking.php?id=<?php echo $result['id'] ?>" class="btn btn-secondary btn-sm btn-inline text-light disabled"><i class="fas fa-bullhorn"></i></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                $t_id = $_SESSION['id'];
                if (isset($_GET['id'])) {
                    $c_id = $_GET['id'];
                    $f_select = "SELECT * FROM `upload` WHERE teacher_id= '{$t_id}' AND course_id= '{$c_id}'";
                } else {
                    $f_select = "SELECT * FROM `upload` WHERE teacher_id= '{$t_id}'";
                }
                $f_query = mysqli_query($con, $f_select);
                if (mysqli_num_rows($f_query) <= 0) {
                    echo "<p class='text-center'>No Records Found!</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal Edit Form Starts Here -->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Assignment</h5>
                    <button type="button" class="close close__box_shadow_none" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="view_assignment.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="a_title" class="form-control" id="a_title">
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <!-- <input type="text" name="Course" class="form-control" id="Course" required> -->
                            <select class="form-control" name="Course" id="Course">
                                <?php include "db_connect.php";
                                $t_id = $_SESSION['id'];
                                $select = "SELECT * FROM `teacher_courses` WHERE section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}'";
                                $sql = mysqli_query($conn, $select);
                                while ($row = mysqli_fetch_assoc($sql)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <?php
                        if (isset($_GET['id'])) {
                        ?>
                            <div class="form-group">
                                <label>Select Section</label>
                                <select class="form-control" name="a_userSection" id="a_userSection">
                                    <?php include "db_connect.php";
                                    $t_c_id = $_SESSION['id'];
                                    $select = "SELECT * FROM `teacher_courses` WHERE id='{$_GET['id']}' AND (section_a= '{$t_c_id}' OR section_b= '{$t_c_id}' OR section_c= '{$t_c_id}' OR section_d= '{$t_c_id}')";
                                    $sql = mysqli_query($conn, $select);
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        if ($row['section_a'] == $t_c_id) {
                                            echo '<option value="a">Section A</option>';
                                        }
                                        if ($row['section_b'] == $t_c_id) {
                                            echo '<option value="b">Section B</option>';
                                        }
                                        if ($row['section_c'] == $t_c_id) {
                                            echo '<option value="c">Section C</option>';
                                        }
                                        if ($row['section_d'] == $t_c_id) {
                                            echo '<option value="d">Section D</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="form-group d-none">
                                <label>User Section</label>
                                <select class="form-control" name="a_userSection" id="a_userSection">
                                    <option value="a">Section A</option>
                                    <option value="b">Section B</option>
                                    <option value="c">Section C</option>
                                    <option value="d">Section D</option>
                                </select>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <label>Total Marks</label>
                            <input type="number" name="total_marks" class="form-control" id="total_marks">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="a_desc" class="form-control" id="a_desc">
                        </div>
                        <div class="form-group">
                            <label>Deadline</label>
                            <input type="Datetime-local" name="a_deadline" class="form-control" id="a_deadline">
                        </div>
                        <div class="form-group">
                            <input type="file" name="upload_file" class="mt-3" accept=".doc,.docx,.pdf,.zip,.jepg,.png,.jpg,.giff,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </div>
                        <div class="form-group">
                            <?php
                            if (isset($_GET['id'])) {
                            ?>
                                <button name="submit" type="submit" formaction="view_assignment.php?id=<?php echo $_GET['id'] ?>" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update details</button>
                            <?php
                            } else {
                            ?>
                                <button name="submit" type="submit" formaction="view_assignment.php" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update details</button>
                            <?php
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Form Ends Here -->

    <script>
        // Datatable
        $(document).ready(function() {
            $('#viewAssignmentsTable').DataTable();
        });
        // ToolTip
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Delete Function
        deletes = document.getElementsByClassName('Delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("Delete");
                id = e.target.id.substr(0);
                if (confirm("Are you sure you want to delete this?")) {
                    console.log("yes");
                    window.location = `view_assignment.php?Delete=${id}`;
                } else {
                    console.log("no");
                }

            })
        })
        // Edit Function
        edits = document.getElementsByClassName('Edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                // file = tr.getElementsByTagName("td")[7].innerText;
                title = tr.getElementsByTagName("td")[2].innerText;
                course = tr.getElementsByTagName("td")[4].innerText;
                deadline = tr.getElementsByTagName("td")[5].innerText;
                Disc = tr.getElementsByTagName("td")[6].innerText;
                u_section = tr.getElementsByTagName("td")[7].innerText;
                totalMarks = tr.getElementsByTagName("td")[8].innerText;

                Course.value = course;
                a_deadline.value = deadline;
                // upload_file = file;
                a_title.value = title;
                a_desc.value = Disc;
                total_marks.value = totalMarks;
                a_userSection.value = u_section;
                snoEdit.value = e.target.id;
                $('#EditModal').modal('toggle');
            })
        })
    </script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>