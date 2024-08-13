<?php
/*合作金庫線上刷卡 專用*/
/*此程式帶入的變量是由shop/module/ShopOrderPay.php產生*/

$orderid=$_GET["orderid"];

list($merID, $MerchantID) = explode("-", $pcenteruser);

//特店代號 $merID
//廠商編號 $MerchantID

//請帶入hashkey 資料
$TerminalID = $pcenterkey;       			//安全檢驗碼

$AuthResURL = $return_url; 			//交易後伺服器通知的頁面-->通知程式修改訂單狀態

//$ReturnURL = $SiteUrl.$key2.$orderid;			//客戶想交易中斷時返回的上一頁頁面

list($coltpye) = explode("-",$v_orderid);
if($coltpye == "SHOP"){ $coltpye = "1"; }elseif($coltpye == "MEMBER"){ $coltpye = "2";}else{ $coltpye = "9"; }

$OrderNo = $OrderNo? $OrderNo:$orderid;				//商店訂單編號

//傳送給金流系統之訂單編號
$lidm = $coltpye.$OrderNo; //加上付款類別號的訂單編號，SHOP開頭加1，MEMBER開頭加2：返回參數時必須判斷為哪種付款(購物或是儲值)
$lidm = rand(10,99).$lidm;				//商店訂單編號

//交易金額
$purchAmt = parse_number($paytotal);				//付款金額

//刷卡授權介面網址
$link= $key1;						//連接金流公司測試網址 https://www.focas-test.fisc.com.tw/FOCAS_WEBPOS/online/

//店家名稱
//$MerchantName = mb_convert_encoding($GLOBALS['GLOBALS']['CONF'][SiteName], "BIG5", "UTF-8");
$MerchantName = $GLOBALS['GLOBALS']['CONF'][SiteName]; 

//是否自動請款長度為1
$AutoCap="0";

//交易金額註記說明文字，最長為15 個中文字。
$CurrencyNote = "";

//交易方式，長度為一碼數字/一般交易：0/分期交易：1/
$PayType="";
// (optional, 亦可不使用本參數，但若為分期交易，此參數為必填)表示分期交易之期數。特店應於購物車帶入與收單行約定之分期期數，固定長度為2 位數字。
$PeriodNum="";

//客製化的資訊 //1:電腦版 2:手機版
if($ism){
	if($_COOKIE["LANTYPE"] == "en"){
		$customize = "4";
		
		$strpay = "Pay by Credit Card";
		
	}elseif($_COOKIE["LANTYPE"] == "zh_cn"){
		$customize = "2";
		
		$strpay = "在线刷卡";
		
	}else{
		$customize = "2";
		
		$strpay = "進行線上刷卡";
	}
}else{
	if($_COOKIE["LANTYPE"] == "en"){
		$customize = "3";
		
		$strpay = "Pay by Credit Card";
		
	}elseif($_COOKIE["LANTYPE"] == "zh_cn"){
		$customize = "1";
		
		$strpay = "在线刷卡";
		
	}else{
		$customize = "1";
		
		$strpay = "進行線上刷卡";
	}
}

$enCodeType = "UTF-8";

$debug = "";

$CurrencyNote = "";//交易註記

$MerchantName = preg_replace("/[\x80-\xff\s]/i","",$MerchantName);


////////////////////產生付款按鈕///////////////////////////////////////////////

$hiddenString ='<input type="hidden" id="customizestr" value="'.$customize.'">';
//$hiddenString ='<form method="post" action="'.$link.'" id="ordersubmit" accept-charset="big5">';
$hiddenString.='<form method="post" action="'.$link.'" id="ordersubmit" accept-charset="utf-8" class="style-toggle">';
$hiddenString.='<input type="hidden" name="merID" value="'.$merID.'">';
$hiddenString.='<input type="hidden" name="MerchantID" value="'.$MerchantID.'">';
$hiddenString.='<input type="hidden" name="TerminalID" value="'.$TerminalID.'">';
$hiddenString.='<input type="hidden" name="MerchantName" value="'.$MerchantName.'">';
$hiddenString.='<input type="hidden" id="customize" name="customize" value="'.$customize.'">';
$hiddenString.='<input type="hidden" name="lidm" value="'.$lidm.'">';
$hiddenString.='<input type="hidden" name="purchAmt" value="'.(INT)$purchAmt.'">';
$hiddenString.='<input type="hidden" name="CurrencyNote" value="'.$CurrencyNote.'">';
$hiddenString.='<input type="hidden" name="AutoCap" value="'.$AutoCap.'">';
$hiddenString.='<input type="hidden" name="AuthResURL" value="'.$AuthResURL.'">';
$hiddenString.='<input type="hidden" name="payType" value="'.$payType.'">';
$hiddenString.='<input type="hidden" name="enCodeType" value="'.$enCodeType.'">';

$hiddenString.='<div class="btn-group" data-toggle="buttons" style="margin-top:-40px;margin-left:0px;">
        <label class="btn active fix-padding payment" id="payment1">
          <input type="radio" id="pay1" name="payment" value="1" checked><i class="icon-circle-o"></i><i class="icon-dot-circle-o"></i> <span>  VISA、MASTER CARD、JCB</span>
        </label>
      </div>';
$hiddenString.='<div class="btn-group2" data-toggle="buttons">
        <label class="btn fix-padding payment" id="payment2">
          <input type="radio" id="pay2" name="payment" value="2"><i class="icon-circle-o"></i><i class="icon-dot-circle-o"></i> <span> China UnionPay 中国银联</span>
        </label>
      </div>';

//$hiddenString.='<input type="image" src="{#RP#}base/files/Brusco/ShoppingCart/Finish/cread1_next_154x33.png" />';

$hiddenString.='<button type="submit" class="btn btn-black btn-lg" style="display:block; clear:both; width:150px;margin-top:20px;">'.$strpay.'</button>';

$hiddenString.='</form>';

//https://www.focas.fisc.com.tw/FOCAS_WEBPOS/online/
$hiddenString.='<script>
	$("#payment1").click(function(){
		$("#ordersubmit").prop("action","https://www.focas.fisc.com.tw/FOCAS_WEBPOS/online/");
		//$("#ordersubmit").prop("action","https://www.focas-test.fisc.com.tw/FOCAS_WEBPOS/online/");
		var cuz = $("#customizestr").val();
		$("#customize").val(cuz);
		//$("#customize").val("");
	});
	$("#payment2").click(function(){
		$("#ordersubmit").prop("action","https://www.focas.fisc.com.tw/FOCAS_UPOP/upop/");
		//$("#ordersubmit").prop("action","https://www.focas-test.fisc.com.tw/FOCAS_UPOP/upop/");
		$("#customize").val("");
	});
</script>';
function parse_number($number, $dec_point=null) {
    if (empty($dec_point)) {
        $locale = localeconv();
        $dec_point = $locale['decimal_point'];
    }
    return floatval(str_replace($dec_point, '.', preg_replace('/[^\d'.preg_quote($dec_point).']/', '', $number)));
}

?>