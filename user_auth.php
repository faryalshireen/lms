<!-- session_start();
if(isset($_SESSION['LAST_ACTIVE_TIME'])){
if((time()-$_SESSION['LAST_ACTIVE_TIME'])>10){
// header('location:logout.php');
header('location:login.php?error=Session timeout');
die();
}
}
$_SESSION['LAST_ACTIVE_TIME']=time();
if(!isset($_SESSION['IS_LOGIN'])){
header('location:login.php?error=Session timeout');
die();
} -->