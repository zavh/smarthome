<?php
#####ESSENTIALS######
include("config/serverconfig.php");
require_once(UTILSDIR."/commons.php");

if(!isset($_SERVER['HTTP_REFERER'])){
	header ('Location:'.MAINHOST);
	exit();
}
else $_SERVER['HTTP_REFERER'] = stripGets($_SERVER['HTTP_REFERER']);
require_once(UTILSDIR."/db_read.php");
require_once(CLASSDIR."/class_db_tables.php");
#####ESSENTIALS######


//Creating Credential Object to access DB
$crobj = new DbTables($con, "users");

$usrcols = array('table_id', 'pwd', 'level');
$uid = $con->real_escape_string($_POST['uid']);
//First, look for a valid user id
$credentials = $crobj->valueLookUp($usrcols, $uid, "uid");

//print_r($credentials);
if(count($credentials)<1){
	header ('Location:'.$_SERVER['HTTP_REFERER']."?errno=1&user=".$_POST['uid']);
}
else{
	$pwd = $_POST['pwd'];
	if(!password_verify ( $pwd , $credentials[0]['pwd'] )){
		header ('Location:'.$_SERVER['HTTP_REFERER']."?errno=2&user=".$_POST['uid']);
	}
	else {
		session_start();
		$_SESSION['loggedin'] = true;
		$_SESSION['uid'] = $uid;
		$_SESSION['level'] = $credentials[0]['level'];
		$_SESSION['table_id'] = $credentials[0]['table_id'];
		$_SESSION['lastactivity'] = strtotime(date("Y-m-d"));
		header ('Location:'.MAINHOST."/site/emreport/");
	}
}

require_once(UTILSDIR."/db_close.php");
?>
