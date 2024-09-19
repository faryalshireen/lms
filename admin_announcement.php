<?php
include 'db3.php';
require 'adminnav.php';
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
    // $u_course_id = $_POST['Course'];
    // Semester Query Starts Here
    // $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$u_course_id}'";
    // $c_sql = mysqli_query($con, $c_query);
    // $c_row = mysqli_fetch_array($c_sql);
    // $u_semester = $c_row['semesters'];
    // Semester Query Ends Here
    $user_id = $_SESSION['id'];
    date_default_timezone_set('Asia/Karachi');
    $a_date = date('Y-m-d H:i:s', time());
    $editDisc = $_POST['a_comments'];
    $a_assigedId = $_POST['admin_assignId'];

    $sql = "UPDATE `announcements` SET `role_id` = 2, `user_id` = '$user_id',  `title` = '$editCourse', `assign_id` = '$a_assigedId', `date` = '$a_date', `comments` ='$editDisc' WHERE `announcements`.`id` = $editno";
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
    <div class="container mt-5 col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-primary">Manage Announcements</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary btn-sm float-right text-white" href="admin_create_announcement.php">Create Announcement</a>
            </div>
        </div>
    </div>
    <div class="container mt-3 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3">
            <div class="align-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Assigned</th>
                            <!-- <th scope="col">Semester</th> -->
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
                        $select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}'";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                            // $semester = $result['semester'];
                            $task = $result['course_id'];
                            $title = $result['title'];
                            $date = $result['date'];
                            $comments = $result['comments'];
                        ?>
                            <tr>
                                <td><?php echo $c++ ?> </td>
                                <td><?php echo substr($title, 0, 20) ?>..</td>
                                <td><?php
                                    if ($result['assign_id'] == 2) {
                                        echo 'Teacher';
                                    } else {
                                        echo 'Student';
                                    }
                                    ?></td>
                                <td style="display: none;"><?php echo $result['assign_id'] ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php echo substr($result['comments'], 0, 40) ?>..</td>
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
                $f_select = "SELECT * FROM `announcements` WHERE user_id= '{$t_id}'";
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_announcement.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="a_title" class="form-control" id="a_title">
                        </div>
                        <div class="form-group">
                            <label>Assigned to</label>
                            <select class="form-control" name="admin_assignId" id="admin_assignId">
                                <option value="3">Student</option>
                                <option value="2">Teacher</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="a_comments" class="form-control" id="a_comments" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <button name="submit" type="submit" formaction="admin_announcement.php" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update Details</button>
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
                    window.location = `admin_announcement.php?Delete=${id}`;
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
                assign_id = tr.getElementsByTagName("td")[3].innerText;
                comments = tr.getElementsByTagName("td")[7].innerText;

                admin_assignId.value = assign_id;
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