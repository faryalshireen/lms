<?php 
$server= "localhost";
$user= "root";
$password="";
// $db = "courses";
$db = "lms3";
$con = mysqli_connect($server,$user,$password,$db);

if(!$con){
    die("Something Went Wrong");

}else{
   
}
?>