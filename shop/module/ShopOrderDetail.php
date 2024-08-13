<?php

/*
	[元件名稱] 訂單詳情
*/

function ShopOrderDetail(){

	global $msql,$fsql,$tsql,$sybtype;

	$tempname=$GLOBALS["PLUSVARS"]["tempname"];

		//2016獲取貨幣、匯率
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}

	$orderid=$_GET["orderid"];
	$orderno=$_GET["orderno"];

	if($orderid=="" && $orderno==""){
		return "NO ORDERID";
	}

	//讀入模板
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);


	$msql->query("select * from {P}_shop_order where `orderid`='$orderid' or `OrderNo`='$orderno' limit 0,1");
	if($msql->next_record()){
		$orderid=$msql->f('orderid');
		$OrderNo=$msql->f('OrderNo');
		$memberid=$msql->f('memberid');
		$user=$msql->f('user');
		$name=$msql->f('name');
		$tel=$msql->f('tel');
		$mobi=$msql->f('mobi');
		$qq=$msql->f('qq');
		$email=$msql->f('email');
		$s_name=$msql->f('s_name');
		$s_tel=$msql->f('s_tel');
		$s_addr=$msql->f('s_addr');
				
		$s_addr_a=mb_substr($s_addr,0,9);
		$s_addr_b=mb_substr($s_addr,9,9);
		$s_addr_c=mb_substr($s_addr,18);
		
		$country=$msql->f('country');
		
		$s_postcode=$msql->f('s_postcode');
		$s_mobi=$msql->f('s_mobi');
		$s_qq=$msql->f('s_qq');
		$s_time=$msql->f('s_time');
		$goodstotal=$msql->f('goodstotal');
		$yunzoneid=$msql->f('yunzoneid');
		$yunid=$msql->f('yunid');
		$yuntype=$msql->f('yuntype');
		$yunifbao=$msql->f('yunifbao');
		$yunbaofei=$msql->f('yunbaofei');
		$yunfei=$msql->f('yunfei');
		$totaloof=$msql->f('totaloof');
		$totalcent=$msql->f('totalcent');
		$totalweight=$msql->f('totalweight');
		$payid=$msql->f('payid');
		$paytype=$msql->f('paytype');
		$paytotal=$msql->f('paytotal');
		$iflook=$msql->f('iflook');
		$ifpay=$msql->f('ifpay');
		$ifyun=$msql->f('ifyun');
		$ifok=$msql->f('ifok');
		$iftui=$msql->f('iftui');
		$ip=$msql->f('ip');
		$dtime=$msql->f('dtime');
		$yuntime=$msql->f('yuntime');
		$paytime=$msql->f('paytime');
		$bz=$msql->f('bz');
		$items=$msql->f('items');
		$disaccount=$msql->f('disaccount');
		$promoprice=$msql->f('promoprice');
		$pricesymbol = $msql->f('pricesymbol');
		$multiprice = $msql->f('multiprice');
		$multiyunfei = $msql->f('multiyunfei');
		
		$tjine = $multiprice+$multiyunfei;
			
			
		if($payid == 1){
			$paypic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderPayment_Credit_75x14.png";
		}else{
			$paypic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderPayment_Delivery_89x14.png";
		}
		$statupic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderProcess_New_73x14.png";
		
		/*取上一則下一則*/
	$msql->query("(SELECT orderid FROM {P}_shop_order WHERE `orderid` < $orderid and memberid='$memberid' ORDER BY orderid DESC LIMIT 0,1) UNION ALL (SELECT orderid FROM {P}_shop_order WHERE `orderid` > $orderid and memberid='$memberid' ORDER BY orderid ASC LIMIT 0,1)");
	while($msql->next_record()){
		$get_id = $msql->f("orderid");
		if($get_id < $orderid ){
			$sid[0] = $get_id;
		}else{
			$sid[1] = $get_id;
		}
	}
				/*帳戶餘額*/
				$memberid = $_COOKIE['MEMBERID'];
				$fsql->query( "select account from {P}_member where memberid='{$memberid}'" );
				if ( $fsql->next_record( ) )
				{
						$account = $fsql->f( "account" );
				}
				else
				{
						$account = "0";
				}

	}else{
		$var=array('ntc'=>"訂單不存在");
		$str=ShowTplTemp($TempArr["err1"],$var);
		return $str;
	}

	
	if($memberid!="0"){
		if(isLogin()){
			$mymemberid=$_COOKIE["MEMBERID"];
			$membertypeid=$_COOKIE["MEMBERTYPEID"];
			if($mymemberid!=$memberid){
				$var=array('ntc'=>"訂單身份校驗未通過，您無權觀看此訂單");
				$str=ShowTplTemp($TempArr["err1"],$var);
				return $str;
			}
		}else{
			header("location:".ROOTPATH."member/login.php");
		}
	}else{
		//非會員訂單查詢校驗碼
		$chkmd=substr(md5($OrderNo.$s_name),0,5);
		$md=$_GET["md"];
		if($md!=$chkmd){
			$var=array('ntc'=>"訂單查詢碼錯誤，您無權觀看此訂單");
			$str=ShowTplTemp($TempArr["err1"],$var);
			return $str;
		}

		$user="非會員";
	}


	$dtime=date("Y-m-d",$dtime);
	$yuntime=date("Y-m-d",$yuntime);
	
	
	$bz=nl2br($bz);


	if($ifpay=="1"){
		$paystat="已付款";
		$paytime=date("Y-m-d",$paytime);
	}else{
		$paystat="未付款";
		$paytime="未付款";
	}

	if($ifyun=="1"){
		$yunstat="已發貨";
		$statupic = ROOTPATH."base/files/Brusco/Members/Order/isyun.png";
		$showtui = "style='display:none;'";
	}else{
		$yunstat="未發貨";
	}

	if($ifok=="1"){
		$okstat="已完成";
		$statupic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderProcess_Finish_88x14.png";
	}else{
		$okstat="處理中";
	}
	
	if($iftui=="1"){
		$statupic = ROOTPATH."base/files/Brusco/Members/Order/TableOrderProcess_Cancel_73x14.png";
		$showtui = "style='display:none;'";
	}else{
		
	}

	//獲取配送地區資訊
	$msql->query("select * from {P}_shop_yunzone where id='$yunzoneid'");
	if($msql->next_record()){
		$zonepid=$msql->f('pid');
		$zonestr=$msql->f('zone');
		if($zonepid!="0"){
			$fsql->query("select * from {P}_shop_yunzone where id='$zonepid'");
			if($fsql->next_record()){
				$pzone=$fsql->f('zone');
				$zonestr=$pzone." ".$zonestr;
			}
			
		}
	}
	/*運費 刷卡*/
	if($getpriceid == 1){
		$msql->query("select dgs from {P}_shop_yun where id='1'");
		if($msql->next_record()){
				$dgs = $msql->f("dgs");
				list($setyunfei, $setyunprice) = explode("|",$dgs);
		}
		$setyunfei = $getrate!="1"? round(($setyunfei*$getrate),$getpoint):$setyunfei;
	}else{
			$tsql->query("select dgs from {P}_shop_yun where spec='{$getpricecode}'");
			if($tsql->next_record()){
				$dgs = $tsql->f("dgs");
				
				list($setyunfei, $setyunprice) = explode("|",$dgs);
				$yunfei = countyunfeip( $tweight, $realtjine, $dgs, $getrate );
				$setyunfei2 = $setyunfei;
				$setyunprice2 = $setyunprice;
				$oriyunfei = $yunfei;
				$oriyunfei2 = $yunfei;
				$yunfei = $getrate!="1"? round(($yunfei*$getrate),$getpoint):$yunfei;
				$yunfei2 = $yunfei;
			}
	}
	$multiyunfei = number_format($multiyunfei,$getpoint);

	$var=array (
	'sitename' => $GLOBALS["CONF"]["SiteName"],
	'orderid' => $orderid,
	'OrderNo' => $OrderNo,
	'user' => $user,
	'name' => $name,
	'qq' => $qq,
	'addr' => $addr,
	'tel' => $tel,
	'mobi' => $mobi,
	'email' => $email,
	's_name' => $s_name,
	's_tel' => $s_tel,
	's_addr' => $s_addr,
	's_addr_a' => $s_addr_a,
	's_addr_b' => $s_addr_b,
	's_addr_c' => $s_addr_c,
	'country' => $country,
	's_postcode' => $s_postcode,
	's_mobi' => $s_mobi,
	's_qq' => $s_qq,
	's_time' => $s_time,
	'goodstotal' => $goodstotal,
	'yunzoneid' => $yunzoneid,
	'yunid' => $yunid,
	'yuntype' => $yuntype,
	'yunifbao' => $yunifbao,
	'yunbaofei' => $yunbaofei,
	'yunfei' => $yunfei,
	'zonestr' => $zonestr,
	'totaloof' => $totaloof,
	'totalcent' => $totalcent,
	'totalweight' => $totalweight,
	'payid' => $payid,
	'paytype' => $paytype,
	'paytotal' => number_format($paytotal,0),
	'paystat' => $paystat,
	'yunstat' => $yunstat,
	'okstat' => $okstat,
	'ip' => $ip,
	'dtime' => $dtime,
	'yuntime' => $yuntime,
	'paytime' => $paytime,
	'bz' => $bz,
	'items' => $items,
		'paypic' => $paypic,
		'statupic' => $statupic,
		'showtui' => $showtui,
		'preid' => $sid[0]!=""? ROOTPATH."shop/orderdetail.php?orderid=".$sid[0]:"javascript:;",
		'nextid' => $sid[1]!=""? ROOTPATH."shop/orderdetail.php?orderid=".$sid[1]:"javascript:;",
		'account' => $account,
		'disaccount' => $disaccount,
		'promoprice' => $promoprice,
		'pricesymbol' => $pricesymbol,
		'tjine' => $tjine,
		'getsymbol' => $getsymbol,
		'multiyunfei' => $multiyunfei,
		'setyunfei' => $setyunfei,
	);

	$str=ShowTplTemp($TempArr["start"],$var);



	//訂單項目列表

	$msql->query("select * from {P}_shop_orderitems where orderid='$orderid' and iftui='0'");
	while($msql->next_record()){

		$itemid=$msql->f('id');
		$memberid=$msql->f('memberid');
		$orderid=$msql->f('orderid');
		$gid=$msql->f('gid');
		$bn=$msql->f('bn');
		$goods=$msql->f('goods');
		$price=$msql->f('price');
		$weight=$msql->f('weight');
		$nums=$msql->f('nums');
		$danwei=$msql->f('danwei');
		$jine=$msql->f('jine');
		$cent=$msql->f('cent');
		$iftui=$msql->f('iftui');
		$ifyun=$msql->f('ifyun');
		$yuntime=$msql->f('yuntime');
		$msg=$msql->f('msg');
		
		$colorname = $msql->f("colorname");
		
		$pricesymbol=$msql->f('pricesymbol');
		$multiprice=$msql->f('multiprice');
		$multijine=$msql->f('multijine');
		
		$price=$multiprice? $multiprice:$price;
		$jine=$multijine? $multijine:$jine;
		
		list($buysize, $buyprice, $buyspecid) = explode("^",$msql->f('fz'));
		//$ccode = $tsql->getone("select colorcode from {P}_shop_conspec where id='{$buyspecid}'");
		/*$tsql->query("select * from {P}_shop_conspec where gid='{$gid}' and colorcode='$ccode[colorcode]' order by id");
		while($tsql->next_record()){
			if($tsql->f("iconsrc")){
				$iconsrc = ROOTPATH.$tsql->f("iconsrc");
				$colorname = ROOTPATH.$tsql->f("colorname");
			}
		}
		$coloricon = "<img src='".$iconsrc."' width='11' height='11' />";*/

		$yuntime=date("y-n-j",$yuntime);
		
		if($ifyun=="1"){
			$itemyun="已發貨";
		}else{
			$itemyun="未發貨";
		}
		
		$var=array (
		'itemid' => $itemid,
		'bn' => $bn,
		'goods' => $goods,
		'gid' => $gid,
		'price' => number_format($price,$getpoint),
		'nums' => $nums,
		'weight' => $weight,
		'danwei' => $danwei,
		'jine' => number_format($jine,$getpoint),
		'yuntime' => $yuntime,
		'cent' => $cent,
		'msg' => $msg,
		'itemyun' => $itemyun,
		'size' => $buysize,
		'coloricon' => $coloricon,
		'colorname' => $colorname,
		'pricesymbol' =>$pricesymbol,
		'getsymbol' => $getsymbol,
		);

		$str.=ShowTplTemp($TempArr["list"],$var);

	}


	$var=array (
	'orderid' => $orderid,
	'OrderNo' => $OrderNo,
	'goodstotal' => $goodstotal,
	'yunbaofei' => $yunbaofei,
	'yunfei' => number_format($yunfei,$getpoint),
	'totaloof' => $totaloof,
	'totalcent' => $totalcent,
	'totalweight' => $totalweight,
	'payid' => $payid,
	'paytype' => $paytype,
	'paytotal' => number_format($paytotal,$getpoint),
	'paystat' => $paystat,
	'yunstat' => $yunstat,
	'okstat' => $okstat,
	'ip' => $ip,
	'dtime' => $dtime,
	'paytime' => $paytime,
	'bz' => $bz,
		'paypic' => $paypic,
		'statupic' => $statupic,
		'showtui' => $showtui,
		'preid' => $sid[0]!=""? ROOTPATH."shop/orderdetail.php?orderid=".$sid[0]:"javascript:;",
		'nextid' => $sid[1]!=""? ROOTPATH."shop/orderdetail.php?orderid=".$sid[1]:"javascript:;",
		'account' => $account,
		'disaccount' => $disaccount,
		'promoprice' => $promoprice,
		'pricesymbol' => $pricesymbol,
		'getsymbol' => $getsymbol,
		'tjine' => $tjine,
		'multiyunfei' => $multiyunfei,
		'setyunfei' => $setyunfei,
	);
	$str.=ShowTplTemp($TempArr["end"],$var);
	return $str;
	
}

?>