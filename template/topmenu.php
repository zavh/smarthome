<?php
if(count(get_included_files()) ==1) {
	include("index.php");
	exit();
}
$widthclass = "w3-row";
$itemCosmetics = "";
if(isset($menuitems)){
  if(count($menuitems) == 1){
    $widthclass = "w3-half";
  }
  if(count($menuitems) == 2){
    $widthclass = "w3-third";
  }
  if(count($menuitems) == 3){
    $widthclass = "w3-quarter";
  }

  for($i=0;$i<count($menuitems);$i++){
    $itemCosmetics .= "<div class='$widthclass ".$menuitems[$i]['classes']."'>";
		if(isset($menuitems[$i]['include']))
			$itemCosmetics .= file_get_contents($menuitems[$i]['include']);
    $itemCosmetics .= $menuitems[$i]['details'];
    $itemCosmetics .= "</div>";
  }
  if(!isset($menuid))
    $menuid = '';
}
?>
<div class="w3-row w3-tiny w3-dark-gray" id="<?php echo $menuid?>">

    <div class="<?php echo $widthclass?> pagetitle">
      <span style="float:left">&nbsp;<a href="javascript:void(0)" class="nodec" onclick="w3_open()">&#9776;</a>&nbsp;</span>
      <?php echo $pagetitle;?>
    </div>
    <?php echo $itemCosmetics;?>
</div>
