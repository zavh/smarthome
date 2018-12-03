<!DOCTYPE html>
<?php
include("config/serverconfig.php");
session_start();
if(isset($_SESSION)){
	if(isset($_SESSION['loggedin']))
		if($_SESSION['loggedin'])
			header ('Location:'.MAINHOST."/site/dailyreport/");
}
?>
<html>
<title>MGA Application Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo CSSDIR;?>/w3s.css">
<link rel="stylesheet" href="<?php echo CSSDIR;?>/site.css">

<body>

<div class="w3-container">
  <div class="w3-display-container" style="height:100vh;">
    <div class="w3-display-middle" style="min-width:300px;">
	  <div class="w3-card-4 w3-round-xlarge w3-small" style="overflow:hidden">
		<div class="w3-container w3-light-blue">
		  <h5 class="w3-center" style="font-family:Arial Narrow">APPLICATION LOGIN</h5>
		</div>
		<form class="w3-container w3-margin" method="POST" action="login.php">
		  <p>
		  <!-- <label>Username</label></p> -->
		  <input class="w3-input" type="email" name="uid" size="50" placeholder="Insert Username" required>
		  <p>
			<!-- <label>Password</label> -->
			<input class="w3-input" type="password" name="pwd" placeholder="Insert Password" required>
		  </p>
		  <div class="w3-row w3-right w3-tiny"><button type="submit" >GO</button></div>
		</form>
	  </div>

			<?php
				if(isset($_GET['errno'])){
						switch ($_GET['errno']) {
							case '1':
								$errmgs = "User \"".$_GET['user']."\" does not exist";
								echo "<input type='hidden' id='errmsg' value='$errmgs|1'>";
								break;
							case '2':
								$errmgs = "Password did not match for User: ".$_GET['user'];
								echo "<input type='hidden' id='errmsg' value='$errmgs|2'>";
								break;
							case '10':
								$errmgs = "Unauthorized access detected.";
								echo "<input type='hidden' id='errmsg' value='$errmgs|10'>";
								break;
							case '20':
								$errmgs = "You are not loggedin";
								echo "<input type='hidden' id='errmsg' value='$errmgs|20'>";
								break;

							default:
								echo $_GET['errno'];
						}

				}
			?>
	</div>
  </div>
</div>
<div id="snackbar"></div>
</body>
</html>
<script src="<?php echo JSDIR;?>/snackbar.js"></script>
