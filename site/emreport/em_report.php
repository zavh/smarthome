<?php
if(!isset($_SERVER['HTTP_REFERER']) && ((count(get_included_files()) ==1))){
		header ('Location:index.php');
}
else if(isset($_SERVER['HTTP_REFERER']) && ((count(get_included_files()) ==1))){
	require_once("../../config/serverconfig.php");
	require_once(UTILSDIR."/essentials_open.php");

  $pagedata = json_decode(file_get_contents('php://input'), true);
  $limit = $pagedata['rpp'];

  $offset = $pagedata['rpp']*($pagedata['page_index'] - 1);
  $lower = $offset+1;
  $upper = $lower + $limit - 1;
  if($upper > $pagedata['records'])
  $upper = $pagedata['records'];
  $report = new DbTables($con, 'emdata');
  $dateUpper = $pagedata['target_date']." 23:59:59";
  $dateLower = $pagedata['target_date']." 00:00:00";
  $query = "SELECT * FROM emdata WHERE event BETWEEN '$dateLower' AND '$dateUpper' ORDER BY id DESC LIMIT $limit OFFSET $offset";

  $result = $report->getSqlResult($query);
}
 ?>
<table class='w3-table-all w3-hoverable' style="border:none;font-size:9px;font-family:Arial, Helvetica, sans-serif;">
   <tr class='w3-light-blue'>
   <th class='w3-center'>ID</th>
   <th class='w3-center'>
       <input type="date" name="report_date" value="<?php echo $pagedata['target_date'];?>" onkeydown="validateDate(event, this)">
   </th>
   <th class='w3-center'>DeviceID</th>
   <th class='w3-center'>Load Current(RMS)</th>
   <th class='w3-center'>Apparent Power</th>
   <th class='w3-center'>Temperature</th>
   </tr>
   <?php
   $tabval = '';
   for($i=0;$i<count($result);$i++){
     if($result[$i]['Irms'] == 0)
      $class = 'w3-red';
     else $class = '';
     $tabval .= "<tr class='$class'>
                   <td class='w3-center'>".$result[$i]['id']."</td>
                   <td class='w3-center'>".$result[$i]['event']."</td>
                   <td class='w3-center'>".$result[$i]['DeviceID']."</td>
                   <td class='w3-center'>".$result[$i]['Irms']."</td>
                   <td class='w3-center'>".$result[$i]['AppPower']."</td>
                   <td class='w3-center'>".$result[$i]['Temperature']."</td>
                 </tr>
                   ";
   }
   echo $tabval;
   ?>
   <tr class='w3-light-blue' style='border:none'>
     <th colspan="3" class='w3-center'>
       Showing page <span id='page_id_text'><?php echo $pagedata['page_index']; ?></span> of <?php echo $pagedata['num_pages'];?>
     </th>
     <th colspan="3" class='w3-center'>Showing Records: <?php echo $lower; ?> to <?php echo $upper; ?> out of <?php echo $pagedata['records'];?></th>
   </tr>
 </table>
