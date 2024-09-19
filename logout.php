<?php  
session_start();
// unset($_SESSION['LAST_ACTIVE_TIME']);
// unset($_SESSION['IS_LOGIN']);
session_unset();
session_destroy();

header("Location: login.php");
?>