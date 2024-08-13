<?php
/*
	*功能：付款過程中伺服器通知頁面
	*版本：2.0
	*日期：2008-08-01
	*作者：支付寶公司銷售部技術支持團隊
	*聯絡：0571-26888888
	*版權：支付寶公司
*/
exit;
//暫不使用
$partner        = "2088002053153634";       //合作夥伴ID
$security_code  = "9fkjby5pbzscg61vil4pf6xwlp8b9w6d";       //安全檢驗碼
$seller_email   = "wangjinmin1982@126.com";       //賣家支付寶帳戶
$_input_charset = "utf-8";  //字元編碼格式  目前支持 GBK 或 utf-8
$sign_type      = "MD5";    //加密方式  系統預設(不要修改)
$transport      = "http";  //瀏覽模式,你可以根據自己的伺服器是否支持ssl瀏覽而選擇http以及https瀏覽模式(系統預設,不要修改)

require_once("alipay_notify.php");

$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->notify_verify();

if($verify_result) {   //認證合格
 //獲取支付寶的反映參數
    $dingdan   = $_POST['out_trade_no'];   //獲取支付寶傳遞過來的訂單號
    $total     = $_POST['total_fee'];      //獲取支付寶傳遞過來的總價格
    $receive_name    =$_POST['receive_name'];    //獲取收貨人姓名
	$receive_address =$_POST['receive_address']; //獲取收貨人地址
	$receive_zip     =$_POST['receive_zip'];     //獲取收貨人郵編
	$receive_phone   =$_POST['receive_phone'];   //獲取收貨人電話
	$receive_mobile  =$_POST['receive_mobile'];  //獲取收貨人手機

/*
	獲取支付寶反映過來的狀態,根據不同的狀態來更新資料庫 
	WAIT_BUYER_PAY(表示等待買家付款);
	WAIT_SELLER_SEND_GOODS(表示買家付款成功,等待賣家發貨);
	WAIT_BUYER_CONFIRM_GOODS(表示賣家已經發貨等待買家確認);
	TRADE_FINISHED(表示交易已經成功結束);
*/
	if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {                   //等待買家付款
        //這裡放入你自訂原始碼,比如根據不同的trade_status進行不同操作
		//echo "success";
		log_result("WAIT_BUYER_PAY");
	}
	else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {      //買家付款成功,等待賣家發貨
        //這裡放入你自訂原始碼,比如根據不同的trade_status進行不同操作
		//echo "success";
		log_result("WAIT_SELLER_SEND_GOODS");
	}
	else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {    //賣家已經發貨等待買家確認
        //這裡放入你自訂原始碼,比如根據不同的trade_status進行不同操作
		//echo "success";
		log_result("WAIT_BUYER_CONFIRM_GOODS");
	}
	else if($_POST['trade_status'] == 'TRADE_FINISHED') {              //交易成功結束
        //這裡放入你自訂原始碼,比如根據不同的trade_status進行不同操作
		//echo "success";
		log_result("TRADE_FINISHED");
	}
	else {
		//echo "fail";
		log_result ("verify_failed");
	}


}else{    //認證不合格
	echo "fail";
	log_result ("verify_failed");
}

?>