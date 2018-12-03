<?php
include("config/serverconfig.php");
session_start();
if(isset($_SESSION['loggedin'])){
	if(!$_SESSION['loggedin'])
		header ('Location:'.MAINHOST."?errno=20");
}
session_unset();
session_destroy();
header ('Location:'.MAINHOST);
?>