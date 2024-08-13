<?php


function ShopMemberOrderTui(){

	global $fsql,$msql,$tsql,$sybtype,$strAlreadyFinish,$strDelivering,$strReturn,$strInProcessing,$strTuiInProcessing;
	
	//ACT
	$act = $_GET["act"];
	//2016獲取貨幣、匯率
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}
	
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$memberid=$_COOKIE["MEMBERID"];

	//網址攔參數
	$key=$_GET["key"];
	$showpay=$_GET["showpay"];
	$showyun=$_GET["showyun"];
	$showok=$_GET["showok"];
	$startday=$_GET["startday"];
	$endday=$_GET["endday"];

	if($startday=="" || $endday==""){
		$endday=date("Y-m-d");
		$enddayArr=explode("-",$endday);
		$endtime=mktime(23,59,59,$enddayArr[1],$enddayArr[2],$enddayArr[0]);
		$starttime=$endtime-(86400*11-1);
		$startday=date("Y-m-d",$starttime);
	}else{
		$enddayArr=explode("-",$endday);
		$endtime=mktime(23,59,59,$enddayArr[1],$enddayArr[2],$enddayArr[0]);
		$startdayArr=explode("-",$startday);
		$starttime=mktime(0,0,0,$startdayArr[1],$startdayArr[2],$startdayArr[0]);
	}

	if($showpay==""){$showpay="all";}
	if($showyun==""){$showyun="all";}
	if($showok==""){$showok="0";}

	//模板解釋
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	
	switch ( $act )
	{
		case "list" :
		

	$var=array (
	'key' => $key,
	'showpay' => $showpay,
	'showyun' => $showyun, 
	'showok' => $showok, 
	'startday' => $startday, 
	'endday' => $endday,
	);

	$str=ShowTplTemp($TempArr["start"],$var);

	//$scl=" memberid='$memberid' and iftui!='1' and dtime>$starttime and dtime<$endtime ";
	
	if($_COOKIE["SYSUSER"]!=""){
		$oktime= time() - ((86400*366)-1);
	}else{
		$oktime= time() - ((86400*11)-1);
	}
	
	$scl=" memberid='$memberid' AND ifyun='1' AND (yuntime>='$oktime' OR itemtui='1')";

	if($showpay=="1" || $showpay=="0"){
		$scl.=" and ifpay='$showpay' ";
	}

	if($showyun=="1" || $showyun=="0"){
		$scl.=" and ifyun='$showyun' ";
	}

	/*if($showok=="1" || $showok=="0"){
		$scl.=" and ifok='$showok' ";
	}*/

	if($key!=""){
		//$scl.=" and (OrderNo='$key' or items regexp '$key' or name regexp '$key' or s_name regexp '$key') ";
	}
	

	include_once(ROOTPATH."includes/pages.inc.php");
	
	$pages=new pages;

	$totalnums=TblCount("_shop_order","orderid",$scl);
	
	$pages->setvar(array(
		"key" => $key,
		"startday" => $startday,
		"endday" => $endday,
		"showpay" => $showpay,
		"showyun" => $showyun,
		"showok" => $showok
		));

	$pages->set(5000,$totalnums);		                          
		
	$pagelimit=$pages->limit();
	

	$msql->query("select * from {P}_shop_order where $scl order by dtime desc limit $pagelimit");

	while($msql->next_record()){
		
		$orderid=$msql->f('orderid');
		$OrderNo=$msql->f('OrderNo');
		$memberid=$msql->f('memberid');
		$goodstotal=$msql->f('goodstotal');
		$yunzoneid=$msql->f('yunzoneid');
		$yunid=$msql->f('yunid');
		$yuntype=$msql->f('yuntype');
		$yunfei=$msql->f('yunfei');
		$paytotal=$msql->f('paytotal');
		$payid=$msql->f('payid');
		$iflook=$msql->f('iflook');
		$ifpay=$msql->f('ifpay');
		$ifyun=$msql->f('ifyun');
		$ifok=$msql->f('ifok');
		$iftui=$msql->f('iftui');
		$dtime=$msql->f('dtime');
		$paytime=$msql->f('paytime');
		$yuntime=$msql->f('yuntime');
		$items=$msql->f('items');
		$itemtui=$msql->f('itemtui');
		$tuiok=$msql->f('tuiok');
		
		$pricesymbol=$msql->f('pricesymbol');
		$multiprice=$msql->f('multiprice');
		$price=$multiprice? $multiprice:$price;
		$multiyunfei=$msql->f('multiyunfei');
		$yunfei=$multiyunfei? $multiyunfei:$yunfei;		
		$paytotal=$multiprice? $price+$yunfei:$paytotal;
		
		$payid=$msql->f('payid');
		if($payid == 1){
			$paypic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderPayment_Credit_75x14.png";
		}else{
			$paypic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderPayment_Delivery_89x14.png";
		}
		
		$statupic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderProcess_New_73x14.png";
		if(!$ifpay && $payid == 1){
			$statupic = ROOTPATH."base/files/Brusco/Members/Order/orderrepay_150x14.png\" style=\"cursor:pointer;\" class=\"repay\" id=\"repay_".$orderid;
		}
		
		$dtime=date("Y-n-j",$dtime);
		
		$showtui = $status ="";
		
		switch($iftui){
			case "0":
				$okimg="no.png";
			break;
			case "1":
				$status = $strReturn;
				$showtui = "style='display:none;'";
			break;
		}
		
		switch($ifpay){
			case "0":
				$payimg="no.png";
			break;
			case "1":
				$payimg="ok.png";
			break;
		}

		switch($ifyun){
			case "0":
				$yunimg="no.png";
			break;
			case "1":
				$yunimg="ok.png";
				$status = $strDelivering;
				$showtui = "style='display:block;'";
			break;
		}
		
		switch($ifok){
			case "0":
				$okimg="no.png";
			break;
			case "1":
				$okimg="ok.png";
				$status = $strAlreadyFinish;
				$showtui = "style='display:block;'";
			break;
		}

		switch($itemtui){
			case "0":
				$status = "---";
				$showtui = "style='display:none;'";
			break;
			case "1":
				$status = $strTuiInProcessing;
				//$showtui = "style='display:none;'";
			break;
		}

		switch($tuiok){
			case "0":
				$status = "---";
				$showtui = "style='display:;'";
			break;
			case "1":
				$status = $strAlreadyFinish;
				$showtui = "style='display:none;'";
			break;
		}
		

		$var=array (
		'orderid' => $orderid,
		'OrderNo' => $OrderNo,
		'items' => $items, 
		'paytotal' => number_format($paytotal,0), 
		'yuntype' => $yuntype, 
		'yunfei' => $yunfei, 
		'okimg' => $okimg, 
		'payimg' => $payimg, 
		'yunimg' => $yunimg, 
		'dtime' => $dtime,
		'paypic' => $paypic,
		'statupic' => $statupic,
		'showtui' => $showtui,
		'pricesymbol' => $pricesymbol,
		'status' => $status,
		);

		$str.=ShowTplTemp($TempArr["list"],$var);

	}

		$str.=$TempArr["end"];

		$pagesinfo=$pages->ShowNow();

		$var=array (
		'key' => $key,
		'showpages' => $pages->output(1),
		'pagestotal' => $pagesinfo["total"],
		'pagesnow' => $pagesinfo["now"],
		'pagesshownum' => $pagesinfo["shownum"],
		'pagesfrom' => $pagesinfo["from"],
		'pagesto' => $pagesinfo["to"],
		'totalnums' => $totalnums
		);

		$str=ShowTplTemp($str,$var);


		return $str;
			

		break;
		
		default:
		$str=$TempArr["m0"];
		return $str;
	}


}

?>