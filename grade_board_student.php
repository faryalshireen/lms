<?php
include 'studentnav.php';
//include "link.php";
include "db_connect.php";
?>

<?php
if (isset($_POST['submit'])) {
    $qid = $_POST['qid'];
    $cid = $_POST['cid'];
    $st_id = $_POST['st_id'];
    $des = $_POST['description'];
    $cuser_section = $_SESSION['user_section'];
    $stu_user_stdBatch = date('y');

    if (isset($_GET['repeat'])) {
        $st_c_isRepeat = 1;
    } else {
        $st_c_isRepeat = 0;
    }

    $sql = "INSERT INTO discussion_answers (question_id, course_id, answer, student_id, is_attempt, section, student_batch, is_repeat) VALUES ('$qid','$cid','$des','$st_id', '1', '$cuser_section', '$stu_user_stdBatch', '$st_c_isRepeat')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your answer is submitted! Thank You.
        <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        $update_sql = "UPDATE `discussion_question` SET `is_attempt` = '1' WHERE `discussion_question`.`id` = $qid";
        mysqli_query($conn, $update_sql);
?>
        <script>
            setTimeout(() => {
                window.location = `student_discussion.php`;
            }, 2000);
        </script>
<?php
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Your Answer must not contain apostrophe or single quote!
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="math,science" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Rich HTML editor to create">
    <meta name="author" content="WIRIS">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Graded Discussion Student Submission</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- Ck Editor -->
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
    <!-- <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> -->
    <!-- Extra -->
    <link rel="shortcut icon" href="assets/editor/img/favicon.ico" type="image/x-icon" />
    <style>
        .display-4 {
            font-size: 35px;
            font-weight: 400;
            line-height: 1.2;
            color: black;
        }

        p {
            margin-top: 0px;
            margin-bottom: 1rem;
            font-size: 28px;
            color: #666666;
            ;

        }

        .jumbotron {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            background-color: #bdd9fd;
            border-radius: 0.3rem;
        }

        .des,
        .lead {
            place-items: center;
            display: grid;
        }

        /* .btn:hover {
            background-color: #102228;
            color: white;
        } */

        p.marks.mb-5 {
            float: right;
        }

        .marks {
            margin-top: 0px;
            margin-bottom: 1rem;
            font-size: 28px;
            color: #4c4545;
            float: right;
        }
    </style>
</head>

<body>




    <div class="container">
        <div class="row">
            <form action="grade_board_student.php" method="POST">
                <div class="mt-3 col-md-7 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="text-primary mb-3 mt-3">Submit Student Discussion</h4>
                    <?php
                    $st_id = $_SESSION['id'];
                    $id = $_GET['id'];
                    $cid = $_GET['cid'];
                    $select = "SELECT * FROM discussion_question WHERE id = $id";
                    $query = mysqli_query($conn, $select);

                    if (!empty($query) && $query->num_rows > 0) {
                        $row = mysqli_fetch_assoc($query);

                    ?>
                        <form action="grade_board_student.php?id=' . $id . '&cid=' . $cid . '" method="POST">
                            <input type="hidden" name="qid" value="<?php echo $row['id'] ?>">
                            <input type="hidden" name="cid" value="<?php echo $cid ?>">
                            <input type="hidden" name="st_id" value="<?php echo $st_id ?>">
                            <div class="mt-2">
                                <label>Total Marks</label>
                                <input type="number" class="form-control" value="<?php echo $row['total_marks'] ?>" disabled>
                            </div>
                            <div class="mt-2">
                                <label>Question</label>
                                <input type="text" class="form-control" value="<?php echo $row['question'] ?>" disabled>
                            </div>
                            <div class="mt-2">
                                <label>Comments</label>
                                <div id="editorContainer">
                                    <div id="toolbarLocation"></div>
                                    <textarea name="description" value="" id="example" class="wrs_div_box" contenteditable="true" tabindex="0" spellcheck="false" role="textbox" aria-label="Rich Text Editor, example" title="Rich Text Editor, example">
                                            <?php echo $row['description'] ?>
                                        </textarea>
                                </div>
                                <small>Press the MathType icon <i class="wrs_icon_editor"></i> or the ChemType icon <i class="wrs_icon_chem"></i> to create and edit equations and formulas</small>
                            </div>
                            <div class="float-right w-100 text-right">
                                <a href="student_discussion.php" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Discussion</a>
                                <?php
                                if (isset($_GET['repeat'])) {
                                ?>
                                    <button type="submit" formaction="grade_board_student.php?id=<?php echo $id ?>&cid=<?php echo $cid ?>&repeat=1" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="submit">Submit Answer</button>
                                <?php
                                } else {
                                ?>
                                    <button type="submit" formaction="grade_board_student.php?id=<?php echo $id ?>&cid=<?php echo $cid ?>" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="submit">Submit Answer</button>
                                <?php
                                }
                                ?>

                            </div>
                        </form>
                    <?php
                    }
                    ?>
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