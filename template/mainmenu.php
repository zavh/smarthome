<!-- Side Bar starts-->
<?php
if(count(get_included_files()) ==1) {
	include("index.php");
	exit();
}
$current_page = str_replace("index.php",'',WEBSERVER.$_SERVER['PHP_SELF']);
$links = array(
			// "DAILY REPORTS"=>MAINHOST."/site/dailyreport/",
			// "INVOICING"=>MAINHOST."/site/invoicing/",
			"REPORT"=>MAINHOST."/site/emreport/",
			"USER MANAGEMENT"=>MAINHOST."/site/users/"
		);
//if($_SESSION['level']<10) array_pop($links);
$active = "w3-blue-gray";
$menustyle = "<div style=\"border-bottom:0.5px solid black;\"><a [|#POINTER|] href=\"[|#LINK$$#|]\" class=\"w3-bar-item w3-button [|#ACTIVELINK#|]\">[|#ITEMNAMES#|]</a></div>";
?>
<div class="w3-sidebar w3-bar-block w3-animate-left" style="display:none;z-index:5" id="mySidebar">
<?php
foreach($links as $item=>$link){
	$temp = str_replace("[|#LINK$$#|]",$link,$menustyle);
	$temp = str_replace("[|#ITEMNAMES#|]",$item,$temp);
	if($current_page == $link){
		$temp = str_replace("[|#ACTIVELINK#|]",$active,$temp);
		$temp = str_replace("[|#POINTER|]","style=\"cursor:default;pointer-events:none;\"",$temp);
	}
	else{
		$temp = str_replace("[|#ACTIVELINK#|]",'',$temp);
		$temp = str_replace("[|#POINTER|]",'',$temp);
	}
	echo $temp;
}
?>
  <div class="w3-display-container" style="height:150px">
	<div class="w3-display-middle" style="width:80px;height:80px;border-radius:100%;background:#eee;">
		<a href="site/users/"><img src=""></a>
	</div>
  </div>
	<div class="w3-padding" id="sessionData">Logged in as <?php echo $_SESSION['uid']?></div>
  <div style="border-bottom:0.5px solid black;border-top:0.5px solid black">
	<a href="<?php echo MAINHOST;?>/logout.php" class="w3-bar-item w3-button">Logout</a>
	</div>
  <div style="border-bottom:0.5px solid black"><a href="javascript:void(0)" onclick='w3_close()' class="w3-bar-item w3-button">Close Menu</a></div>
</div>


<div class="w3-overlay w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>
	<!-- Side Bar ends-->
