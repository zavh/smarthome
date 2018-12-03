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
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<head>
		<link rel="stylesheet" href="<?php echo CSSDIR;?>/w3s.css">
		<link rel="stylesheet" href="<?php echo CSSDIR;?>/autocomplete.css">
		<link rel="stylesheet" href="<?php echo CSSDIR;?>/site.css?version=1.0.7">
		<script src="<?php echo JSDIR;?>/autocomplete.js"></script>
		<title> MGA Voucher Application</title>
		<script src="<?php echo JSDIR;?>/site.js?version=0.1.5"></script>
	</head>

	<body onclick="upActivityCounter()" onload="upActivityCounter()" class="w3-gray">
	<input type='hidden' id='lastActiveTime' value=0>
