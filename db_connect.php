<?php 
$server= "localhost";
$user= "root";
$password="";
$db = "lms3";
$conn = mysqli_connect($server,$user,$password,$db);

    if($conn){
    // echo "connect";

    }else{
        echo "not connect";
    }
?>