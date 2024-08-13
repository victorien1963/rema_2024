<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include(ROOTPATH."member/includes/pay.inc.php");

//獲取付款方式參數
$pv=getPayVal("alipay_db");

///////////////////////////////////////////////////////////////////
/*	
	*功能：付完款後跳轉的頁面
	*版本：2.0
	*日期：2008-08-01
	*作者：支付寶公司銷售部技術支持團隊
	*聯絡：0571-26888888
	*版權：支付寶公司
*/

$partner        = $pv["pcenteruser"];       //合作夥伴ID
$security_code  = $pv["pcenterkey"];       //安全檢驗碼
$seller_email   = $pv["key1"];       //賣家支付寶帳戶
$_input_charset = "utf-8";  //字元編碼格式  目前支持 GBK 或 utf-8
$sign_type      = "MD5";    //加密方式  系統預設(不要修改)
$transport      = "http";  //瀏覽模式,你可以根據自己的伺服器是否支持ssl瀏覽而選擇http以及https瀏覽模式(系統預設,不要修改)

require_once("alipay_notify.php");

$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->return_verify();

	//獲取支付寶的反映參數
    $dingdan    = $_GET['out_trade_no'];   //獲取訂單號
    $total_fee  = $_GET['total_fee'];      //獲取總價格
    $receive_name    =$_GET['receive_name'];    //獲取收貨人姓名
	$receive_address =$_GET['receive_address']; //獲取收貨人地址
	$receive_zip     =$_GET['receive_zip'];     //獲取收貨人郵編
	$receive_phone   =$_GET['receive_phone'];   //獲取收貨人電話
	$receive_mobile  =$_GET['receive_mobile'];  //獲取收貨人手機
  

if($verify_result){

	//轉成規定變量，交給面向模組的PayBack函數來處理
	$arr=explode("-",$dingdan);
	$back_coltype=$arr[1];
	$back_orderid=$arr[2];
	$back_fee=$total_fee;
	$back_payid=$pv["payid"];
	PayBack($back_payid,$back_coltype,$back_orderid,$back_fee);

}else {    
	echo "fail";
}

?>