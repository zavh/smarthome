<?php
function stripGets($url){
	$processedUrl = explode("?",$url);
	return $processedUrl[0];
}

function randPassGen(){
	$chars=array("ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz","0123456789");
	$tempPass = "";
	for($i=0;$i<8;$i++){
		$a = rand(0,2);
		$b = rand(0,(strlen($chars[$a])-1));
		$tempPass .= $chars[$a][$b];
	}
	$tempPass .= $chars[0][rand(0,(strlen($chars[0])-1))];
	$tempPass .= $chars[1][rand(0,(strlen($chars[1])-1))];
	$tempPass .= $chars[2][rand(0,(strlen($chars[2])-1))];
	return $tempPass;
}

function monthUpdated($con, $tdReadable, $status){
	$mrObj = new DbTables($con, "monthreport");
	$idvalue = "'".getMonth($tdReadable)."-01'";
	$mrObj->updateRecord('update_status', $status, 'report_month', $idvalue);
}

function monthArrearUpdate($con, $tdReadable, $arrearArr){
	echo "Accessed for $tdReadable<br>";
	$mrObj = new DbTables($con, "monthreport");
	$idvalue = "'".getMonth($tdReadable)."-01'";
	$arrearSTMT = json_encode($arrearArr);
	$mrObj->updateRecord('arrear', $arrearSTMT, 'report_month', $idvalue);
}

function getMonth($dateString){
	return date("Y-m",strtotime($dateString));
}

function getJSONobj($jsonfile){
	$str = file_get_contents($jsonfile);
	$json = json_decode($str, true);
	return $json;
}
function getLastMonthArrear($con, $targetMonth){
	$mrDbObj = new DbTables($con, "monthreport");
	$sql = "SELECT `repository_name`,`arrear` from `monthreport` WHERE `report_month`<'$targetMonth' ORDER BY `report_month` DESC LIMIT 1";
	$pf = $mrDbObj->getSqlResult($sql);
	return $pf;
}
function getConsecutiveMonths($con, $month){
	$mrDbObj = new DbTables($con, "monthreport");
	$sql = "SELECT * FROM `monthreport` WHERE `report_month`>'$month' ORDER BY `report_month` ASC";
	$cm = $mrDbObj->getSqlResult($sql); //consecutive months
	return $cm;
}
function updateConsucutiveMonths($con, $mdObj){
	$nmArr = getConsecutiveMonths($con, $mdObj->md['month']); //Next Months Array
	if(count($nmArr)>0){
		$tmpArrear = $mdObj->getArrearArr();
		for($i=0;$i<count($nmArr);$i++){
			$tmpFName = PERFORMANCEREPORTDIR."/".$nmArr[$i]['repository_name'];
			$tempMrData = getJSONobj($tmpFName);
			$tempMdObj = new month_data($tempMrData); //Object instantiated
			$tempMdObj->setRepository($tmpFName); //Setting up filename where data is saved at the end of execution.

			$tempArrearArr = json_decode($nmArr[$i]['arrear'],true);
			$tempMdObj->setPrevArrear($tmpArrear);
			$tempMdObj->setArrear();
			$tempMdObj->writeMonthlyData($tempMdObj->md);
			$tmpArrear = $tempMdObj->getArrearArr();
			monthArrearUpdate($con, $nmArr[$i]['report_month'], $tmpArrear);
		}
	}
}

function getBankName($con, $id){
  $bank = new DbTables($con, 'bank');
  $values = $bank->valueLookUp(array('bank_code'), $id, 'bank_id');
  return $values[0]['bank_code'];
}
function getCorpName($con, $id){
  $bank = new DbTables($con, 'corporate');
  $values = $bank->valueLookUp(array('corporate_name'), $id, 'corporate_id');
  return $values[0]['corporate_name'];
}
function getBanks($con){
	$sql = "SELECT * FROM bank";
	$result = $con->query($sql);
	$banks = array();
	while($row = $result->fetch_assoc()){
		$banks[$row['bank_id']] = $row['bank_code'];
	}
	return $banks;
}
function getCorps($con){
	$sql = "SELECT * FROM `corporate`";
	$result = $con->query($sql);
	$corps = array();
	while($row = $result->fetch_assoc()){
		$corps[$row['corporate_id']] = $row['corporate_name'];
	}
	return $corps;
}
?>
