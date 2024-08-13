<?php

$partner        = $pcenteruser;       //合作夥伴ID
$security_code  = $pcenterkey;       //安全檢驗碼
$seller_email   = $key1;       //賣家支付寶帳戶
$_input_charset = "utf-8";  //字元編碼格式  目前支持 GBK 或 utf-8
$sign_type      = "MD5";    //加密方式  系統預設(不要修改)
$transport      = "http";  //瀏覽模式,你可以根據自己的伺服器是否支持ssl瀏覽而選擇http以及https瀏覽模式(系統預設,不要修改)
$notify_url     = $notify_url; //交易過程中伺服器通知的頁面 要用 http://格式的完整路徑
$return_url     = $return_url; //付完款後跳轉的頁面 要用 http://格式的完整路徑
$show_url       = $myurl;      //網站地址
$out_trade_no   = date(YmdHis)."-".$v_orderid;


////////////////////////////////////////////////////////////////////////////////

class alipay_service {

	var $gateway = "https://www.alipay.com/cooperate/gateway.do?";         //支付接口
	var $parameter;       //全部需要傳遞的參數
	var $security_code;   //安全校驗碼
	var $mysign;          //簽名

	//構造支付寶外部服務接口控制
	function alipay_service($parameter,$security_code,$sign_type = "MD5",$transport= "https") {
		$this->parameter      = $this->para_filter($parameter);
		$this->security_code  = $security_code;
		$this->sign_type      = $sign_type;
		$this->mysign         = '';
		$this->transport      = $transport;
		if($parameter['_input_charset'] == "")
		$this->parameter['_input_charset']='utf-8';
		if($this->transport == "https") {
			$this->gateway = "https://www.alipay.com/cooperate/gateway.do?";
		} else $this->gateway = "http://www.alipay.com/cooperate/gateway.do?";
		$sort_array = array();
		$arg = "";
		$sort_array = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".$this->charset_encode($val,$this->parameter['_input_charset'])."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最後一個問號
		$this->mysign = $this->sign($prestr.$this->security_code);
	}


	function create_url() {
		$url        = $this->gateway;
		$sort_array = array();
		$arg        = "";
		$sort_array = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->mysign ."&sign_type=".$this->sign_type;
		return $url;

	}

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;

	}

	function sign($prestr) {
		$mysign = "";
		if($this->sign_type == 'MD5') {
			$mysign = md5($prestr);
		}elseif($this->sign_type =='DSA') {
			//DSA 簽名方法待後續開發
			die("DSA 簽名方法待後續開發，請先使用MD5簽名方式");
		}else {
			die("支付寶暫不支持".$this->sign_type."類型的簽名方式");
		}
		return $mysign;

	}
	function para_filter($parameter) { //除去陣列中的空值和簽名模式
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
	//實現多種字元編碼方式
	function charset_encode($input,$_output_charset ,$_input_charset ="utf-8" ) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset '];
		if($_input_charset == $_output_charset || $input ==null) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
}


$parameter = array(
	"service"        => "create_partner_trade_by_buyer",  //交易類型
	"partner"        => $partner,         //合作商戶號
	"return_url"     => $return_url,      //同步返回
	"notify_url"     => $notify_url,      //異步返回
	"_input_charset" => $_input_charset,  //字元集，預設為utf-8
	"subject"        => $items,       //商品名稱，必填
	"body"           => $items,       //商品描述，必填
	"out_trade_no"   => $out_trade_no,     //商品外部交易號，必填（保證唯一性）
	"price"          => $paytotal,          //訂購金額
	"payment_type"   => "1",              //預設為1,不需要修改
	"quantity"       => "1",              //商品數量，必填
		
	"logistics_fee"      =>'0.00',        //物流配送費用
	"logistics_payment"  =>'BUYER_PAY',   //物流費用付款方式：SELLER_PAY(賣家支付)、BUYER_PAY(買家支付)、BUYER_PAY_AFTER_RECEIVE(貨到付款)
	"logistics_type"     =>'EXPRESS',     //物流配送方式：POST(平郵)、EMS(EMS)、EXPRESS(其他快遞)

	"show_url"       => $show_url,        //商品相關網站
	"seller_email"   => $seller_email     //賣家郵箱，必填
);
$alipay = new alipay_service($parameter,$security_code,$sign_type);

$link=$alipay->create_url();



////////////////////產生按鈕///////////////////////////////////////////////

$hiddenString ="<form method='post' id='post' action='".$link."'>";
$hiddenString .= "<input type='submit' class='bigbutton' value='通過".$pcenter."付款'>";
$hiddenString .= "</form>";

?>


