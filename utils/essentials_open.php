<?php 
if(count(get_included_files()) ==1) 
	include("index.php");
session_start();
if(isset($_SESSION['loggedin'])){
	if(!$_SESSION['loggedin'])
		header ('Location:'.MAINHOST."?errno=20");
	else
		$_SESSION['lastactivity'] = strtotime(date("Y-m-d"));
}
else header ('Location:'.MAINHOST."?errno=20");

date_default_timezone_set(TIMEZONE);
include(CLASSDIR."/class_db_tables.php");

if(file_exists(UTILSDIR."/db_read.php"))
	include(UTILSDIR."/db_read.php");
else exit;
?>