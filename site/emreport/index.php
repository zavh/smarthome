<?php
	include($_SERVER['DOCUMENT_ROOT']."/emapp/config/serverconfig.php");
	include(TEMPLATEDIR."/header.php");
	include(TEMPLATEDIR."/mainmenu.php");

	//Setting the default report date
	if(!isset($_SESSION['dailyreportdate'])){
		$_SESSION['dailyreportdate'] = date("Y-m-d");
	}
	$reportdate = $_SESSION['dailyreportdate']; //Report date is the default unless other date is posted
	if(isset($_POST['reportdate'])){ //POSTed date found, default and reportdate both will be changed
		$reportdate = $_POST['reportdate'];
		$_SESSION['dailyreportdate'] = $reportdate;
	}
?>
<style>
.entryAction{
}
.summaryTable{
	width:100%;
	//border-collapse: collapse;
	background-color: #eee;
}
.summaryTable tr th{
	border-top: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
	text-align:left;
	background-color: #ddd;
	font-size: 10px;
}
.summaryTable tr.card{
	border-top: 1px solid #aaa;
	border-bottom: 1px solid #aaa;
	color: rgba(10,129,20,1);
	vertical-align: middle;
}
.summaryTable tr.cardDetailsShow{
	color: rgba(0,0,0,0.8);
}
.summaryTable tr.corpDetailsShow{
	border-top: 1px solid #aaa;
	border-bottom: 1px solid #aaa;
	color: rgba(129,20,20,0.9);
}
.summaryTable tr.cardMonthDetailsShow{
	border-top: 1px solid #aaa;
	border-bottom: 1px solid #aaa;
	color: rgba(20,170,50,0.9);
}
.summaryTable tr.corpMonthDetailsShow{
	border-top: 1px solid #aaa;
	border-bottom: 1px solid #aaa;
	color: rgba(89,70,250,0.8);
}
@media print {
	#dayreportmenu {
      display :  none;
    }
	.entryAction{
		display :  none;
	}
	.entryreport{
		max-height:none;
	}
}
</style>
	<!-- Page background or Page Wrapper -->
	<div class="w3-gray w3-row" style="min-height:100vh;height:100%">
	 <!-- Top Panel Starts-->
	 <?php
	 	$pagetitle = "Performance Dashboard";
		$menuid = "dayreportmenu";

		// $menuitems[0]['classes']  = "w3-small w3-center darkmenu";
	 	// $menuitems[0]['details']  = "<a href=\"javascript:void(0)\" ";
	 	// $menuitems[0]['details'] .= "onclick=\"document.getElementById('newbill').style.display='block'\" class=\"nodec\">New Bill/Request</a>";

	 	include(TEMPLATEDIR."/topmenu.php");
		$report = new DbTables($con, 'emdata');
		$query = "SELECT * FROM emdata ORDER BY id DESC";
		$result = $report->getSqlResult($query);
	 ?>
	 <div class="w3-container w3-margin-top">
		 <table class='w3-table-all w3-hoverable w3-card'>
				<tr class='w3-light-blue'>
				<th>ID</th>
				<th>GMT Time</th>
				<th>DeviceID</th>
				<th>Load Current(RMS)</th>
				<th>Apparent Power</th>
				<th>Temperature</th>
				</tr>
				<?php
				$tabval = '';
				for($i=0;$i<count($result);$i++){
					$tabval .= '<tr>
												<td>'.$result[$i]['id'].'</td>
												<td>'.$result[$i]['event'].'</td>
												<td>'.$result[$i]['DeviceID'].'</td>
												<td>'.$result[$i]['Irms'].'</td>
												<td>'.$result[$i]['AppPower'].'</td>
												<td>'.$result[$i]['Temperature'].'</td>
											</tr>
												';
				}
				echo $tabval;
				?>
			</table>
	 </div>

	 </div>
<?php
	include(TEMPLATEDIR."/footer.php");
?>
