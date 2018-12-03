<?php
	include("config/serverconfig.php");
	include(TEMPLATEDIR."/header.php");
	include(TEMPLATEDIR."/mainmenu.php");

	include(UTILSDIR."/autocompletedata.php");
	$reportdate = date("Y-m-d");
	if(isset($_POST['reportdate'])){
		$reportdate = $_POST['reportdate'];
	}
?>
<style>
@media print {
	#dayreportmenu {
        display :  none;
    }
}
</style>
	<!-- Top menu starts-->
	<div class="w3-blue-gray w3-row" style="min-height:100vh">
	<?php
		$pagetitle = "Error Code: 404";
		include(TEMPLATEDIR."/topmenu.php");
	?>
		<!-- Top menu ends-->
		<div class="w3-display-container" style="height:80vh">
			<div class="w3-display-middle"><h5>Sorry, the requested URL could not be found.</h5></div>
		</div>
<?php
	include(TEMPLATEDIR."/footer.php");
?>
