<?php
header('Content-Type: text/html; charset=utf-8');
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
ob_start();
$msql->query("SELECT id,fz,orderid,bn,goods,nums FROM {P}_shop_orderitems WHERE id>7792");
while($msql->next_record()){
	$getFZ = $msql->f("fz");
	$itemid = $msql->f("id");
	$orderid = $msql->f("orderid");
	$good = $msql->f("bn").$msql->f("goods");
	$nums = $msql->f("nums");
	list($size,$money,$specid) = explode("^",$getFZ);
	$gg = $fsql->getone("SELECT size FROM {P}_shop_conspec WHERE id='$specid'");
	$getSize = $gg["size"];
	if($getSize != $size){
		echo $orderid."[".$good."][".$itemid."][購買 ".$size." ".$nums."件，記錄成 ".$getSize."]<br/>";
	    ob_flush();
	    flush();
	}
}
ob_end_clean();
?>