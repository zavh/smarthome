<?php
#####ESSENTIALS######
require_once($_SERVER['DOCUMENT_ROOT']."/emapp/config/serverconfig.php");
require_once(UTILSDIR."/essentials_open.php");
require_once(UTILSDIR."/commons.php");

if(!isset($_SERVER['HTTP_REFERER'])){
	header ('Location:'.$_SERVER['DOCUMENT_ROOT']."/mga/");
	exit();
}
else $_SERVER['HTTP_REFERER'] = stripGets($_SERVER['HTTP_REFERER']);
#####ESSENTIALS######
//print_r($_POST);
//print_r($_SESSION);
$crobj = new DbTables($con, "users");
if($_POST['command'] == 'newuser'){
	if(!($_SESSION['level']>9))
		header ('Location:'.$_SERVER['HTTP_REFERER']."?errno=1");
	else {
		$uid = $con->real_escape_string($_POST['uid']);
		$pwd = password_hash($con->real_escape_string($_POST['pwd']), PASSWORD_DEFAULT);

		$userdata['uid'] = $uid;
		$userdata['pwd'] = $pwd;
		$userdata['level'] = $_POST['level'];
		if($crobj->insertRecord($userdata))
			echo "User created successfully|101";
		else echo "User creation failed. User already exists|3";
	}
}
if($_POST['command'] == "changepasswd"){
	//if($_SESSION['user_level']>9)
	//	header ('Location:'.$_SERVER['HTTP_REFERER']."?errno=1");
	$pwd = $_POST['existing_password'];
	$fields = array('pwd');
	$value = $_SESSION['table_id'];
	$credentials = $crobj->valueLookUp($fields, $value, 'table_id');
	if(!password_verify ( $pwd , $credentials[0]['pwd'] )){
		echo "Failed to match current password|3";
	}
	else {
		$pwd = password_hash($con->real_escape_string($_POST['newpassword']), PASSWORD_DEFAULT);
		$crobj->updateRecord('pwd', $pwd, 'table_id', $_SESSION['table_id']);
		echo "Password changed. Auto logout in 2 seconds|103";
	}
}
if($_POST['command'] == "deleteuser"){
	if(!($_SESSION['level']>9))
		echo "User Unauthorized to execute level change|3";
	else {
		$crobj->deleteRecord('table_id', $_POST['table_id']);
		echo "User Deleted successfully|103";
	}
}
if($_POST['command'] == "changelevel"){
	if(!($_SESSION['level']>9)){
		echo "User Unauthorized to execute level change|3";
	}
	else {
		$config = explode("|",$_POST['config']);
		$crobj->updateRecord('level', $config[0], 'table_id', $config[1]);
		echo "User level changed successfully|103";
	}
}
if($_POST['command'] == "resetpass"){
	if(!($_SESSION['level']>9)){
		echo "User Unauthorized to execute Password Reset|3";
	}
	else {
		$config = $_POST['table_id'];
		//echo "Your random password:".randPassGen()."|103";
		$newpass = randPassGen();
		$pwd = password_hash($con->real_escape_string($newpass), PASSWORD_DEFAULT);
		$crobj->updateRecord('pwd', $pwd, 'table_id', $_POST['table_id']);
		if($crobj->updateRecord('pwd', $pwd, 'table_id', $_POST['table_id']))
			echo "Resetted password is $newpass|103";
	}
}
require_once(UTILSDIR."/essentials_close.php");
?>
