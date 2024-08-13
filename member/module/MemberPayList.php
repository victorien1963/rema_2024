<?php


function MemberPayList(){

	global $msql,$fsql;


	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$memberid=$_COOKIE["MEMBERID"];


	//模板解釋
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);


	//取出目前帳戶資訊
	$msql->query("select * from {P}_member where memberid='".$_COOKIE["MEMBERID"]."'");
	if($msql->next_record()){
		$account=$msql->f('account');
		$paytotal=$msql->f('paytotal');
		$buytotal=$msql->f('buytotal');
	}


	$var=array(
		'account' => $account,
		'paytotal' => $paytotal,
		'buytotal' => $buytotal
	);
		
	$str=ShowTplTemp($TempArr["start"],$var);

	$scl=" memberid='$memberid' ";
	$sclb=" a.memberid='$memberid' ";
	
	include_once(ROOTPATH."includes/pages.inc.b.php");
	$pages=new pages;
	$totalnums=TblCount("_member_pay","id",$scl);
	$pages->setvar(array("key" => $key));
	$pages->set(20,$totalnums);		                          
	$pagelimit=$pages->limit();	  
	$msql->query("select a.*,b.* from {P}_member_pay AS a LEFT JOIN {P}_member_buylist AS b ON a.addtime=b.daytime WHERE $sclb order by a.id desc limit $pagelimit");
	while($msql->next_record()){
		$id=$msql->f('id');
		$oof=$msql->f('oof');
		$method=$msql->f('method');
		$type=$msql->f('type');
		$payhb=$msql->f('payhb');
		$addtime=$msql->f('addtime');
		$fpnum=$msql->f('fpnum');
		$memo=$msql->f('memo');
		$logname=$msql->f('logname');
		$addtime=date("Y-n-j",$addtime);
		$orderid=$msql->f('orderid');
		$OrderNo=$msql->f('OrderNo');
		$thisaccount=$msql->f('thisaccount');
		
		$getdis = $fsql->getone("SELECT disaccount FROM {P}_shop_order WHERE orderid='$orderid'");
		$getdisaccount = $getdis["disaccount"];
		
		$oof = number_format($oof);
		$getdisaccount = $getdisaccount>0? number_format($getdisaccount):0;
		
		$var=array (
		'id' => $id,
		'oof' => $oof, 
		'oof_A' => $getdisaccount>0? "0":"NT$ ".$oof, 
		'oof_B' => $getdisaccount==0 && $method=="退刷"? "NT$ ".$oof:"0", 
		'oof_C' => $getdisaccount>0? "NT$ ".$getdisaccount:"0", 
		'addtime' => $addtime,
		'method' => $method,
		'type' => $type,
		'fpnum' => $fpnum,
		'memo' => $memo,
		'logname' => $logname,
		'OrderNo' => $OrderNo? $OrderNo:"---",
		'orderid' => $orderid,
		'account' => $thisaccount? "NT$ ".number_format($thisaccount):0,
		);
		
		if($thisaccount>0 || $getdisaccount>0){
			$str.=ShowTplTemp($TempArr["list"],$var);
		}
	}

	$pagesinfo=$pages->ShowNow();

	$var=array (
	'showpages' => $pages->output(1),
	'pagestotal' => $pagesinfo["total"],
	'pagesnow' => $pagesinfo["now"],
	'pagesshownum' => $pagesinfo["shownum"],
	'pagesfrom' => $pagesinfo["from"],
	'pagesto' => $pagesinfo["to"],
	'totalnums' => $totalnums,
	'account' => $account,
	);

	$str.=ShowTplTemp($TempArr["end"],$var);
	return $str;

}

?>