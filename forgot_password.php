<?php
include "link.php";
include "db_connect.php";
if (!isset($_SESSION['username']) && !isset($_SESSION['id'])) {
} else {
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>FUUAST LOGIN</title>
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .password_mismatched {
            display: none;
        }
    </style>

</head>

<body class="bg-gradient-primary">


    <!-- Start of Navbar -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                    <h3 style="color:black;">Learning Management System</h3>
                </form>
            </nav>
            <!-- End Of Navbar -->


            <div class="container">
                <!-- Outer Row -->
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="p-3">
                                            <div class="text-center">
                                                <h1 class="h4 mb-4" style="color:#0a3500; font-weight:bold;">FUUAST LMS</h1>
                                                <p>Enter Password to Reset</p>
                                            </div>
                                            <!-- Toaster Alert Start -->
                                            <div class="alert alert-danger alert-dismissible password_mismatched fade show" role="alert">
                                                Password do not Match!
                                                <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Toaster Alert End -->
                                            <?php if (isset($_GET['error'])) { ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_GET['error'] ?>
                                                </div><?php
                                                    } ?>
                                            <form onsubmit="return false" method="post">
                                                <div class="form-group">
                                                    <input type="password" pattern="(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" title="Must contain at least one digit, uppercase, lowercase letter, and 8 characters in length" class="form-control form-control-user" id="f_password" name="f_password" placeholder="Enter Password" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" pattern="(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" title="Must contain at least one digit, uppercase, lowercase letter, and 8 characters in length" class="form-control form-control-user" id="f_confirm_password" name="f_confirm_password" placeholder="Confirm Password" required>
                                                </div>
                                                <button type="submit" onclick="formsubmit()" name="resetPassword_submit" class="btn btn-block" style="background:#0a3500; color:white;">Reset Password</button>
                                                <hr>
                                            </form>
                                            <hr>
                                            <div class="text-center">
                                                <a class="small" href="login.php">Back to Login?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script>
                function formsubmit(announcementId) {
                    var u_password = document.getElementById('f_password').value;
                    var u_confirmPassword = document.getElementById('f_confirm_password').value;
                    var u_token_key = window.location.href.split('?key=')[1];
                    var formdata = 'f_password=' + u_password + '&f_confirm_password=' + u_confirmPassword + '&f_tokenkey=' + u_token_key;
                    $.ajax({
                        type: "POST",
                        url: "forgot_password_temp.php",
                        data: formdata,
                        cache: false,
                        success: function(html) {
                            if (html == 1) {
                                window.location.href = 'login.php?success=Password Reset Successfully!';
                            } else if (html == 2) {
                                window.location.href = 'login.php?error=Password Failed to Reset!';
                            } else if (html == 3) {
                                var alertDismissable = document.getElementsByClassName('password_mismatched')[0];
                                alertDismissable.classList.remove("password_mismatched");
                                setTimeout(() => {
                                    var alertDismissable = document.getElementsByClassName('alert-dismissible')[0];
                                    alertDismissable.classList.add("password_mismatched");
                                }, 5000);
                            } else if (html == 4) {
                                window.location.href = 'login.php?error=Token expired!';
                            } else if (html == 5) {
                                window.location.href = 'login.php?error=Token Missing!';
                            }
                        },
                    });
                    return false;
                }
            </script>

            <!-- Bootstrap core JavaScript-->
            <script src="assets/vendor/jquery/jquery.min.js"></script>
            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>