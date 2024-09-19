<?php
include "db_connect.php";
include "SimpleXLSXGen.php";

$data=[[ 
'Sno','Teacher Name','teacher Department','teacher Email','Username']];

$role_id = $_GET['id'];
      $sql = "SELECT * FROM users WHERE role_id = '{$role_id}'";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        // echo $row['id'];
        // echo $row['courses_heading'];

        $id = $row['id'];
        $name = $row['name'];
        $department = $row['department'];
        $email = $row['email'];
        $username=$row['username'];

        $data=array_merge($data,array(array($id,$name,$department,$email,$username)));
      }
      $xlsx = SimpleXLSXGen::fromArray($data);
$xlsx->downloadAs('data.xlsx');

?>