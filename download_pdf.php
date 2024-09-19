<?php
include('db_connect.php');
include('db3.php');
require('assets/dompdf/autoload.inc.php');

// $semester = $_GET['semester'];
// $qid = $_GET['quiz'];
// echo $semester;
$sql = "SELECT * FROM quiz_details WHERE quiz_id = '{$_GET['quiz']}'";

$no= 0;
   
$run1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row1 = mysqli_fetch_array($run1);
$sid = $row1['student_id'];
$quizid=$row1['quiz_id'];
// echo $sid;
$query = "SELECT * FROM userdata WHERE user_id = '$sid'" ;
$run = mysqli_query($con , $query) or die(mysqli_error($con));

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();   
ob_start();
require ('student_quiz_details_pdf.php');
$html=ob_get_contents();
ob_get_clean();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('student_quiz_details.pdf',['Attachment'=>true]);

?>