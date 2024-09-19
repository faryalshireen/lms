<?php
include 'db3.php';
require 'teachernav.php';
?>

<?php
// Delete
if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $sql = "DELETE FROM `announcements` WHERE `id` = $id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   Announcement Deleted Successfully!
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
    $user_id = $_SESSION['id'];
    date_default_timezone_set('Asia/Karachi');
    $a_date = date('Y-m-d H:i:s', time());
    $editDisc = $_POST['a_comments'];

    $sql = "UPDATE `announcements` SET `role_id` = 2, `user_id` = '$user_id',  `title` = '$editCourse', `date` = '$a_date', `semester` = '$u_semester', `course_id` = '$u_course_id', `comments` ='$editDisc' WHERE `announcements`.`id` = $editno";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
       Announcement has been updated!
       <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Announcement has failed to update!
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Manage Announcements</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-primary pl-2 pt-2">Manage Announcements</h4>
            </div>
            <div class="col-md-6">
                <?php
                if (isset($_GET['id'])) {
                    echo '<a class="btn btn-primary btn-sm float-right mt-2 text-white" href="create_announcement.php?id=' . $_GET['id'] . '">Create Announcement</a>';
                } else {
                ?>
                    <a class="btn btn-primary btn-sm float-right text-white" data-toggle="modal" data-target="#createStdAnnouncementModal">Create Announcement</a>
                    <!-- Modal Starts Here -->
                    <div class="modal fade" id="createStdAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="createStdAnnouncementModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Select Course</h5>
                                    <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="announcement.php" method="POST">
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
                                        <button type="button" onclick="location.href='create_announcement.php?id='+document.getElementById('c_courseId').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Continue to Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End Here -->
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container mt-2 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3">
            <div class="align-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Course</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        require 'db3.php';
                        $t_id = $_SESSION['id'];
                        if (isset($_GET['id'])) {
                            $select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}' AND course_id= '{$_GET['id']}'";
                        } else {
                            $select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}'";
                        }
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                            $semester = $result['semester'];
                            $task = $result['course_id'];
                            $title = $result['title'];
                            $date = $result['date'];
                            $comments = $result['comments'];
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo  substr($title, 0, 20) ?>..</td>
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
                                <td><?php echo $semester ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php echo substr($result['comments'], 0, 20) ?>..</td>
                                <td style="display: none;"><?php echo $comments ?></td>
                                <td style="display: none;"><?php echo $title ?></td>
                                <td>
                                    <button class="Edit btn btn-info btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="edit">Edit</button>
                                    <button class="Delete btn btn-danger btn-sm btn-inline text-light" id=<?php echo $result['id'] ?> name="delete">Delete</button>
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
                    $f_select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}' AND course_id= '{$_GET['id']}'";
                } else {
                    $f_select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}'";
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
    <div class="modal fade" id="editAnnounceModal" tabindex="-1" role="dialog" aria-labelledby="editAnnounceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAnnounceModalLabel">Edit Announcement</h5>
                    <button type="button" class="close close__box_shadow_none" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="announcement.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="a_title" class="form-control" id="a_title">
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <select class="form-control" name="Course" id="Course">
                                <?php include "db_connect.php";
                                $t_id = $_SESSION['id'];
                                $select = "SELECT * FROM `teacher_courses` WHERE teacher_id= '{$t_id}'";
                                $sql = mysqli_query($conn, $select);
                                while ($row = mysqli_fetch_assoc($sql)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="a_comments" class="form-control" id="a_comments" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <?php
                            if (isset($_GET['id'])) {
                            ?>
                                <button name="submit" type="submit" formaction="announcement.php?id=<?php echo $_GET['id'] ?>" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update Details</button>
                            <?php
                            } else {
                            ?>
                                <button name="submit" type="submit" formaction="announcement.php" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update Details</button>
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
        // Delete Function
        deletes = document.getElementsByClassName('Delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("Delete");
                id = e.target.id.substr(0);
                if (confirm("Are you sure you want to delete this?")) {
                    console.log("yes");
                    window.location = `announcement.php?Delete=${id}`;
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
                title = tr.getElementsByTagName("td")[8].innerText;
                course = tr.getElementsByTagName("td")[3].innerText;
                comments = tr.getElementsByTagName("td")[7].innerText;

                Course.value = course;
                a_title.value = title;
                a_comments.value = comments;
                snoEdit.value = e.target.id;
                $('#editAnnounceModal').modal('toggle');
            })
        })
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>