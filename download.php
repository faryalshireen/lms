<?php
if(!empty($_GET['file'])){
    $filename=basename($_GET['file']);
    $desfile= $filename;

if(!empty($filename) && file_exists($desfile)){

    header('Content-Description: File Transfer');
    header('Content-Type: application/zip');
    header("Content-Disposition: attachment; filename=$filename");
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    readfile($desfile);

exit;
}else{
    ?>
    <script>
     alert ("File not Exist");
    </script>
    <?php
    
}

}

?>