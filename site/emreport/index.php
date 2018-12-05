<script>
function reportAjaxFunction(instruction, execute_id, divid){
	var ajaxRequest;  // The variable that makes Ajax possible!
		try{
				ajaxRequest = new XMLHttpRequest();
		} catch (e){
				try{
						ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
						try{
								ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
						} catch (e){
								alert("Your browser broke!");
								return false;
						}
				}
		}
		ajaxRequest.onreadystatechange = function(){
				if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200){
					if(instruction=="changelevel"){
						document.getElementById("errmsg").value = ajaxRequest.responseText;
						msgInASnackbar();
						var status = ajaxRequest.responseText.split("|");
						if(parseInt(status[1])<100){
							document.getElementById(config[2]).value = document.getElementById("orig-"+config[2]).value;
							return;
						}
						else userAjaxFunction('refreshList', '', 'userlist');
					}
					if(instruction=="showReport"){

					}
						if(divid!=''){
							var ajaxDisplay = document.getElementById(divid);
							ajaxDisplay.innerHTML = ajaxRequest.responseText;
						}
				}
			}

			if(instruction == "showReport"){
				ajaxRequest.open("POST", "em_report.php", true);
				ajaxRequest.setRequestHeader("Content-type", "application/json");
				ajaxRequest.send(execute_id);
			}
}

function validateRPP(e, el){
	if(e.keyCode == 13){
		if(isNaN(el.value) || el.value == '' || el.value < 1){
			el.value = page['rpp'];
			return;
		}
		else {
			page['rpp'] = el.value;
			page['page_index'] = 1;
			page['num_pages'] = Math.ceil(page['records']/page['rpp']);
			reportAjaxFunction('showReport', JSON.stringify(page), 'data-table-container');
			document.getElementById('page_index').value = 1;
		}
	}
}
function validatePageId(e, el){
	var rpp = document.getElementById('rpp');
	if(e.keyCode == 13){
		if(isNaN(el.value) || el.value == "" || el.value < 1){
			el.value = page['page_index'];
			return;
		}
		else if(isNaN(rpp.value) || rpp.value == ''){
			rpp.value = page['rpp'];
		}
		if(el.value > page['num_pages']){
			el.value = page['num_pages'];
		}
			page['rpp'] = rpp.value;
			page['page_index'] = el.value;
			page['num_pages'] = Math.ceil(page['records']/page['rpp']);
			reportAjaxFunction('showReport', JSON.stringify(page), 'data-table-container');
		}
	}
	function trimInputs(el){
		el.value = el.value.trim();
	}
	function validateDate(e, el){
		if(e.keyCode == 13){
			var x = new Date(el.value);
			y = x.getDate();
			if(isNaN(y)){
				 z = new Date(Date.now());
				 el.value = z.getFullYear()+"-"+z.getMonth()+"-"+z.getDate();
			}
			else{
				document.getElementById('report_date').value=el.value;
				var f = document.getElementById('hiddenParamsForm');
				f.submit();
				console.log(document.getElementById('hiddenParamsForm'));
			}
		}
	}

</script>

<?php
	include($_SERVER['DOCUMENT_ROOT']."/emapp/config/serverconfig.php");
	include(TEMPLATEDIR."/header.php");
	include(TEMPLATEDIR."/mainmenu.php");

	if(isset($_POST['report_date']))
		$report_date = $_POST['report_date'];
	else
		$report_date = date("Y-m-d");

		$dateUpper = "$report_date 23:59:59";
		$dateLower = "$report_date 00:00:00";
?>

<div class="w3-gray w3-row" style="min-height:100vh;height:100%">
	 <!-- Top Panel Starts-->
	 <?php
	 	$pagetitle = "Performance Dashboard";
		$menuid = "dayreportmenu";

		 //$menuitems[0]['classes']  = "w3-small w3-center darkmenu";
	 	 //$menuitems[0]['details']  = "Total Number of records";
	 	include(TEMPLATEDIR."/topmenu.php");

		$report = new DbTables($con, 'emdata');

	  $query = "SELECT COUNT(id) as records FROM emdata WHERE event BETWEEN '$dateLower' AND '$dateUpper'";
	  $result = $report->getSqlResult($query);
	  $page['records'] = $result[0]['records'];
	 ?>

	 <div class="w3-container w3-margin-top">
		<div class="w3-card" id='data-table-container' style='max-height:80vh;overflow:auto'>
				 <script type="text/javascript" defer>
				 		var page = {};
				 		page['records'] = <?php echo $page['records']; ?>;
						page['rpp'] = <?php echo PAGINATIONRPP; ?>;
						page['page_index'] = 1;
						page['num_pages'] = Math.ceil(page['records']/page['rpp']);
						page['target_date'] ='<?php echo $report_date; ?>';
				 	reportAjaxFunction('showReport', JSON.stringify(page), 'data-table-container');
				 </script>
		</div>
	 </div>
	 <div class="w3-center w3-row">
		 <div class='w3-col m6 s6 w3-round'>
			 <div class="w3-margin w3-padding w3-card w3-round w3-light-grey">
			 	Records per page: <input type="number" name="rpp" value="<?php echo PAGINATIONRPP; ?>" size=3 id='rpp' onkeypress="validateRPP(event, this)" onkeyup="trimInputs(this)" autocomplete="off">
			 </div>
		 </div>
		 <div class='w3-col m6 s6'>
			 <div class="w3-margin w3-padding w3-card  w3-round w3-light-grey">
				Go to page: <input type="number" name="page_index" value="1" size=3 id='page_index' onkeypress="validatePageId(event, this)" onkeyup="trimInputs(this)" autocomplete="off">
			 </div>
		 </div>
	 </div>
	 <form id="hiddenParamsForm" name="hiddenParamsForm" action="index.php" method="post">
	 	<input type="hidden" name="report_date" id="report_date" value="<?php echo date('Y-m-d'); ?>">
	 	<input type="hidden" name="report_equipment" id="report_equipment" value="all">
	 	<input type="submit" name="s" value="" style="display:none" >
	 </form>
</div>
<?php
	include(TEMPLATEDIR."/footer.php");
?>
