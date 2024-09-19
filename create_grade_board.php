<?php
include 'teachernav.php';
include "link.php";
include "db_connect.php";
?>

<?php
if (isset($_POST['discussion_submit'])) {
    $title = $_POST['question'];
    $des = $_POST['description'];
    $cid = $_POST['courseId'];
    // $semester_id = $_POST['semester_id'];
    // Semester Query Starts Here
    $c_query = "SELECT * FROM `teacher_courses` WHERE id= '{$_POST['courseId']}'";
    $c_sql = mysqli_query($conn, $c_query);
    $c_row = mysqli_fetch_array($c_sql);
    $grade_semester = $c_row['semesters'];
    // Semester Query Ends Here

    $semester_id = $_SESSION['id'];
    $total_marks = $_POST['total_marks'];
    $board_due_date = $_POST['due_date'];
    $user_section = $_POST["u_section"];
    // $date = date_create($due_date);
    // $dd = date_format($date, "d-m-Y");
    $t_user_stdBatch = date('y');

    $sql = "INSERT INTO discussion_question(question, description,course_id,teacher_id,total_marks,due_date, semester, section, student_batch) VALUES ('$title' , '$des', '$cid', '$semester_id','$total_marks','$board_due_date', '$grade_semester', '$user_section', '$t_user_stdBatch')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Discussion Published Successfully!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
?>
        <script>
            setTimeout(() => {
                window.location = `manage_graded_board.php`;
            }, 1500);
        </script>
<?php
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Discussion Failed to Publish!
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
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="math,science" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Rich HTML editor to create">
    <meta name="author" content="WIRIS">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Create Grade Discussion Board</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- CK Editor -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
    <script type="text/javascript">
        if (window.location.search !== '') {
            var urlParams = window.location.search;
            if (urlParams[0] == '?') {
                urlParams = urlParams.substr(1, urlParams.length);
                urlParams = urlParams.split('&');
                for (i = 0; i < urlParams.length; i = i + 1) {
                    var paramVariableName = urlParams[i].split('=')[0];
                    if (paramVariableName === 'language') {
                        _wrs_int_langCode = urlParams[i].split('=')[1];
                        break;
                    }
                }
            }
        }
    </script>
    <!-- Editor Plugin -->
    <!-- <link type="text/css" rel="stylesheet" href="''" /> -->
    <script type="text/javascript" src="assets/editor/tinymce5/tinymce.min.js"></script>
    <!-- Style for html code -->
    <!-- <link type="text/css" rel="stylesheet" href="assets/editor/css/prism.css" /> -->
    <!-- Style -->
    <!-- <link rel="stylesheet" href="assets/editor/css/style.css"> -->
    <!-- Roboto Font -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <!-- Extra -->
    <link rel="shortcut icon" href="assets/editor/img/favicon.ico" type="image/x-icon" />
    <style>
        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
            width: fit-content;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <form action="create_grade_board.php" method="POST">
                <div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="text-primary mb-3 mt-3">Create New Discussion</h4>
                    <div class="mt-2">
                        <label>Discussion Question</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>
                    <div class="mt-2">
                        <label>Total Marks</label>
                        <input type="number" class="form-control" id="total_marks" name="total_marks" required>
                    </div>
                    <div class="mt-2">
                        <label>Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" min="<?php echo date("Y-m-d"); ?>" required>
                    </div>
                    <div class="mt-2">
                        <label>Select Course</label>
                        <select class="form-control" name="courseId" required>
                            <?php include "db_connect.php";
                            $t_id = $_SESSION['id'];
                            $select = "SELECT * FROM `teacher_courses` WHERE id='{$_GET['id']}' AND (section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}')";
                            $sql = mysqli_query($conn, $select);
                            while ($row = mysqli_fetch_assoc($sql)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['courses_heading']; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label>Select Section</label>
                        <select class="form-control" name="u_section" required>
                            <?php include "db_connect.php";
                            $t_id = $_SESSION['id'];
                            $select = "SELECT * FROM `teacher_courses` WHERE id='{$_GET['id']}' AND (section_a= '{$t_id}' OR section_b= '{$t_id}' OR section_c= '{$t_id}' OR section_d= '{$t_id}')";
                            $sql = mysqli_query($conn, $select);
                            while ($row = mysqli_fetch_assoc($sql)) {
                                if ($row['section_a'] == $t_id) {
                                    echo '<option value="a">Section A</option>';
                                }
                                if ($row['section_b'] == $t_id) {
                                    echo '<option value="b">Section B</option>';
                                }
                                if ($row['section_c'] == $t_id) {
                                    echo '<option value="c">Section C</option>';
                                }
                                if ($row['section_d'] == $t_id) {
                                    echo '<option value="d">Section D</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label>Comments</label>
                        <div id="editorContainer">
                            <div id="toolbarLocation"></div>
                            <textarea name="description" id="example" class="wrs_div_box" contenteditable="true" tabindex="0" spellcheck="false" role="textbox" aria-label="Rich Text Editor, example" title="Rich Text Editor, example">
                             </textarea>
                        </div>
                        <small>Press the MathType icon <i class="wrs_icon_editor"></i> or the ChemType icon <i class="wrs_icon_chem"></i> to create and edit equations and formulas</small>
                    </div>
                    <div class="float-right w-100 text-right">
                        <a href="manage_graded_board.php" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Discussion</a>
                        <button type="submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="discussion_submit" id="imp">Publish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Prism JS script to beautify the HTML code -->
    <script type="text/javascript" src="assets/editor/js/prism.js"></script>

    <!-- WIRIS script -->
    <script type="text/javascript" src="assets/editor/js/wirislib.js"></script>

    <!-- Google Analytics -->
    <script src="assets/editor/js/google_analytics.js"></script>

    <script>
        if (typeof urlParams !== 'undefined') {
            var selectLang = document.getElementById('lang_select');
            selectLang.value = urlParams[1];
        }
    </script>

</body>

</html>