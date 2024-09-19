<?php
include 'teachernav.php';
include "link.php";
include "db_connect.php";
?>

<?php
// Delete
if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $sql = "DELETE FROM `discussion_question` WHERE `id` = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   Discussion Deleted Successfully!
     <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>';
    }
}

// Edit GDBs
if (isset($_POST['snoEdit'])) {
    $editno = $_POST['snoEdit'];
    $p_t_questionTitle = $_POST['d_question'];
    $p_t_totalMarks = $_POST['d_totalMarks'];
    $p_t_courseId = $_POST['d_courseId'];
    $p_t_sectionId = $_POST['d_sectionId'];
    $p_t_dueDate = $_POST['d_dueDate'];

    $update_sql = "UPDATE `discussion_question` SET `question` = '$p_t_questionTitle', `course_id` = '$p_t_courseId', `section` = '$p_t_sectionId', `total_marks` = '$p_t_totalMarks', `due_date` ='$p_t_dueDate' WHERE `discussion_question`.`id` = $editno";
    $u_result = mysqli_query($conn, $update_sql);
    if ($u_result) {
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
    <title>Student Discussion Board</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <style>
        a.btn.btn-primary.mb-5.mr-3 {
            float: right;
        }
    </style>
</head>

<body>
    <div class="container mt-4 col-lg-12 col-md-12 col-sm-12">
        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="text-primary ml-3">Graded Discussion Board</h4>
            </div>
            <div class="col-md-6">
                <?php
                if (isset($_GET['id'])) {
                    echo '<a class="btn btn-primary btn-sm float-right text-white" href="create_grade_board.php?id=' . $_GET['id'] . '">Add New Discussion</a>';
                } else {
                ?>
                    <a class="btn btn-primary btn-sm float-right text-white" data-toggle="modal" data-target="#createGDBModal">Add New Discussion</a>
                    <!-- Modal Starts Here -->
                    <div class="modal fade" id="createGDBModal" tabindex="-1" role="dialog" aria-labelledby="createGDBModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Select Course</h5>
                                    <button type="button" class="close close__box_shadow_none" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="manage_graded_board.php" method="POST">
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
                                        <button type="button" onclick="location.href='create_grade_board.php?id='+document.getElementById('c_courseId').value" class="btn btn-success text-white float-right btn-sm ml-1 mt-4 mb-1 pl-4 pr-4 pb-1 pt-1">Continue to Create</button>
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
    <div class="container mt-3 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card mb-3 pt-3 pb-3">
            <div class="align-center">
                <table class="table data-table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Discussion Topic</th>
                            <th scope="col" style="display: none;">display_none</th>
                            <th scope="col" style="width:18%">Course</th>
                            <th scope="col" style="display: none;">display_none</th>
                            <th scope="col">Total Marks</th>
                            <th scope="col">Section</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dt_user_stdBatch = date('y');
                        if (isset($_GET['id'])) {
                            $query = "SELECT * FROM discussion_question WHERE course_id ='{$_GET['id']}' AND student_batch='{$dt_user_stdBatch}' AND teacher_id= '{$_SESSION['id']}'";
                        } else {
                            $query = "SELECT * FROM discussion_question WHERE teacher_id= '{$_SESSION['id']}' AND student_batch='{$dt_user_stdBatch}'";
                        }
                        $sql = mysqli_query($conn, $query);
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $count = $count + 1;
                            $question = $row['question'];
                            // $description = $row['description'];
                            $dueDate = $row['due_date'];
                            $totalMarks = $row['total_marks'];
                            // Passing Course Id Starts Here
                            if (isset($_GET['id'])) {
                                $courseId = $_GET['id'];
                            } else {
                                $courseId = $row['course_id'];
                            }
                            // Passing Course Id Ends Here
                        ?>
                            <tr>
                                <td><?php echo $count ?></td>
                                <td><?php echo substr($question, 0, 20) ?>..</td>
                                <td style="display: none;"><?php echo $question ?></td>
                                <td>
                                    <?php
                                    $course_query = "SELECT * FROM `teacher_courses` WHERE id= '{$row['course_id']}'";
                                    $course_sql = mysqli_query($conn, $course_query);
                                    $course_row = mysqli_fetch_array($course_sql);
                                    echo $course_row['courses_heading'];
                                    ?>
                                </td>
                                <td style="display: none !important;"><?php
                                                                        $course_query = "SELECT * FROM `teacher_courses` WHERE id= '{$row['course_id']}'";
                                                                        $course_sql = mysqli_query($conn, $course_query);
                                                                        $course_row = mysqli_fetch_array($course_sql);
                                                                        echo $course_row['id'];
                                                                        ?></td>
                                <td><?php echo $totalMarks ?></td>
                                <td><?php echo $row['section'] ?></td>
                                <td><?php echo $dueDate ?></td>
                                <td>
                                    <?php
                                    if (isset($row['student_batch']) && $row['student_batch'] == date('y')) {
                                    ?>
                                        <a href="view_grade_discussion.php?id=<?php echo $row['id'] ?>&cid=<?php echo $courseId ?>" class="btn btn-primary btn-sm">View</a>
                                        <button class="Edit btn btn-info btn-sm btn-inline text-light" id=<?php echo $row['id'] ?> name="edit">Edit</button>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="view_grade_discussion.php?id=<?php echo $row['id'] ?>&cid=<?php echo $courseId ?>" class="btn btn-primary btn-sm disabled">View</a>
                                        <button class="btn btn-info btn-sm btn-inline text-light disabled">Edit</button>
                                    <?php
                                    }
                                    ?>
                                    <button class="Delete btn btn-danger btn-sm btn-inline text-light" id=<?php echo $row['id'] ?> name="delete">Delete</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit Form Starts Here -->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Graded Discussion Board</h5>
                    <button type="button" class="close close__box_shadow_none" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="manage_graded_board.php" method="POST">
                        <input type="hidden" class="hidden" id="snoEdit" name="snoEdit">
                        <div class="form-group">
                            <label>Discussion Question</label>
                            <input type="text" name="d_question" class="form-control" id="d_question">
                        </div>
                        <div class="form-group">
                            <label>Total Marks</label>
                            <input type="number" name="d_totalMarks" class="form-control" id="d_totalMarks">
                        </div>
                        <div class="form-group">
                            <label>Select Course</label>
                            <select class="form-control" name="d_courseId" id="d_courseId">
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
                                <select class="form-control" name="d_sectionId" id="d_sectionId">
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
                                <select class="form-control" name="d_sectionId" id="d_sectionId">
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
                            <label>Due Date</label>
                            <input type="date" name="d_dueDate" class="form-control" id="d_dueDate" min="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group">
                            <?php
                            if (isset($_GET['id'])) {
                            ?>
                                <button name="submit" type="submit" formaction="manage_graded_board.php?id=<?php echo $_GET['id'] ?>" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update details</button>
                            <?php
                            } else {
                            ?>
                                <button name="submit" type="submit" formaction="manage_graded_board.php" class="btn btn-success btn-sm float-right active" role="button" aria-pressed="true">Update details</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script>
        // Datatable
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
        // Delete Function
        deletes = document.getElementsByClassName('Delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("Delete");
                id = e.target.id.substr(0);
                if (confirm("Are you sure you want to delete this Discussion?")) {
                    console.log("yes");
                    window.location = `manage_graded_board.php?Delete=${id}`;
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
                t_questionTitle = tr.getElementsByTagName("td")[2].innerText;
                t_courseId = tr.getElementsByTagName("td")[4].innerText;
                t_dueDatae = tr.getElementsByTagName("td")[7].innerText;
                u_section = tr.getElementsByTagName("td")[6].innerText;
                t_totalMarks = tr.getElementsByTagName("td")[5].innerText;

                d_question.value = t_questionTitle;
                d_totalMarks.value = t_totalMarks;
                d_courseId.value = t_courseId;
                d_sectionId.value = u_section;
                d_dueDate.value = t_dueDatae;
                snoEdit.value = e.target.id;
                $('#EditModal').modal('toggle');
            })
        })
    </script>
</body>

</html>