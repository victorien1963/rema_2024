<?php
/*中國信託 線上刷卡 專用*/
/*此程式帶入的變量是由shop/module/ShopOrderPay.php產生*/

include "auth_mpi_mac.php";


$orderid=$_GET["orderid"];

//特店代號
$merID = "4783";
	
//廠商編號
$MerchantID = $pcenteruser;		//商店代碼
//請帶入hashkey 資料
$TerminalID = $pcenterkey;       			//安全檢驗碼

$AuthResURL = $return_url; 			//交易後伺服器通知的頁面-->通知程式修改訂單狀態

//$ReturnURL = $SiteUrl.$key2.$orderid;			//客戶想交易中斷時返回的上一頁頁面

list($coltpye) = explode("-",$v_orderid);
if($coltpye == "SHOP"){ $coltpye = "1"; }elseif($coltpye == "MEMBER"){ $coltpye = "2";}else{ $coltpye = "9"; }

$OrderNo = $OrderNo? $OrderNo:$orderid;				//商店訂單編號

//傳送給金流系統之訂單編號
$lidm = $coltpye.$OrderNo; //加上付款類別號的訂單編號，SHOP開頭加1，MEMBER開頭加2：返回參數時必須判斷為哪種付款(購物或是儲值)

//交易金額
$purchAmt = (INT)$paytotal;				//付款金額

//刷卡授權介面網址
$link= $key1;						//連接中國信託測試網址 https://testepos.chinatrust.com.tw/auth/SSLAuthUI.jsp
$link_j = "https://testepos.chinatrust.com.tw/UPOP/unionPayAuth.do";

//交易方式，長度為一碼數字/一般交易：0/分期交易：1/紅利折抵一般交易：2/紅利折抵分期交易：4/
$txType="0";
/*純數字欄位，依交易方式不同填入不同的資料，說明如下：
 若 txType=0，資料請填「1」。
 若 txType=1，資料為一到兩碼的分期期數。
 若 txType=2，資料為固定兩碼的產品代碼。
 若 txType=4，資料為三到四碼，前兩碼固定為
產品代碼，後一碼或兩碼為分期期數。*/
$Option="1";

//是否自動請款長度為1
$AutoCap="0";

//預設(進行交易時)請填0，偵錯時請填1。
$debug="0";

//店家名稱
$MerchantName = mb_convert_encoding($GLOBALS['GLOBALS']['CONF'][SiteName], "BIG5", "UTF-8");
//$MerchantName = $GLOBALS['GLOBALS']['CONF'][SiteName]; 

//訂單描述
$OrderDetail = "";

//客製化的資訊 (保留欄位)
$Customize = "";

//此為貴特店在URL 帳務管理後台登錄的壓碼字串。
$Key = "Mjy0siZOWPwopW7ijSi4oOM6";

//交易識別資料
//$MACString =  auth_in_mac($MerchantID,$TerminalID,$lidm,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$debug);
$MACString =  auth_in_mac($MerchantID,$TerminalID,$lidm,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$MACString,$debug);
$URLEnc = get_auth_urlenc($MerchantID,$TerminalID,$lidm,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$MACString,$debug);

////////////////////產生付款按鈕///////////////////////////////////////////////

$hiddenString ='<form method="post" action="'.$link.'" id="ordersubmit" >';
/*
$hiddenString.='<input type="hidden" name="MerchantID" value="'.$MerchantID.'">';
$hiddenString.='<input type="hidden" name="TerminalID" value="'.$TerminalID.'">';
$hiddenString.='<input type="hidden" name="lidm" value="'.$lidm.'">';

$hiddenString.='<input type="hidden" name="purchAmt" value="'.(INT)$purchAmt.'">';
$hiddenString.='<input type="hidden" name="txType" value="'.$txType.'">';
$hiddenString.='<input type="hidden" name="Option" value="'.$Option.'">';
$hiddenString.='<input type="hidden" name="Key" value="'.$Key.'">';
	
$hiddenString.='<input type="hidden" name="MerchantName" value="'.$MerchantName.'">';
$hiddenString.='<input type="hidden" name="AuthResURL" value="'.$AuthResURL.'">';
$hiddenString.='<input type="hidden" name="OrderDetail" value="'.$OrderDetail.'">';
$hiddenString.='<input type="hidden" name="AutoCap" value="'.$AutoCap.'">';
$hiddenString.='<input type="hidden" name="Customize" value="'.$Customize.'">';
$hiddenString.='<input type="hidden" name="debug" value="'.$debug.'">';

$hiddenString.='<input type="hidden" name="merID" value="'.$merID.'">';
*/
/*
$hiddenString_j.='<input type="hidden" name="MACString" value="'.$MACString.'">';
*/

$hiddenString.='<input type="hidden" name="URLEnc" value="'.$URLEnc.'">';
$hiddenString.='<input type="hidden" name="merID" value="'.$merID.'">';

//$hiddenString.='<input type="submit" class="bigbutton" value="通過'.$pcenter.'付款" />';
$hiddenString.='<input type="image" src="{#RP#}base/files/Brusco/ShoppingCart/Finish/cread1_next_154x33.png" />';
$hiddenString.='</form>';

/*JBC專用*/
$hiddenString_j ='<form method="post" action="'.$link_j.'" >';

$hiddenString_j.='<input type="hidden" name="MerchantID" value="'.$MerchantID.'">';
$hiddenString_j.='<input type="hidden" name="TerminalID" value="'.$TerminalID.'">';
$hiddenString_j.='<input type="hidden" name="lidm" value="'.$lidm.'">';

$hiddenString_j.='<input type="hidden" name="purchAmt" value="'.(INT)$purchAmt.'">';
$hiddenString_j.='<input type="hidden" name="txType" value="'.$txType.'">';
$hiddenString_j.='<input type="hidden" name="Option" value="'.$Option.'">';
$hiddenString_j.='<input type="hidden" name="Key" value="'.$Key.'">';
	
$hiddenString_j.='<input type="hidden" name="MerchantName" value="'.$MerchantName.'">';
$hiddenString_j.='<input type="hidden" name="AuthResURL" value="'.$AuthResURL.'">';
$hiddenString_j.='<input type="hidden" name="OrderDetail" value="'.$OrderDetail.'">';
$hiddenString_j.='<input type="hidden" name="AutoCap" value="'.$AutoCap.'">';
$hiddenString_j.='<input type="hidden" name="Customize" value="'.$Customize.'">';
$hiddenString_j.='<input type="hidden" name="debug" value="'.$debug.'">';
$hiddenString_j.='<input type="hidden" name="MACString" value="'.$MACString.'">';

$hiddenString_j.='<input type="hidden" name="merID" value="'.$merID.'">';

$hiddenString_j.='<input type="image" src="{#RP#}base/files/Brusco/ShoppingCart/Finish/cread2_next_121x30.png" />';
$hiddenString_j.='</form>';

?>