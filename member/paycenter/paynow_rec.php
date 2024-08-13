<?php
define( "ROOTPATH", "../../" );
include_once( ROOTPATH."includes/common.inc.php" );
include_once( ROOTPATH."member/includes/pay.inc.php" );

     function getParameter($pname){
     return isset($_POST[$pname])?urldecode($_POST[$pname]):"";
     }
$PayTypeValue = getParameter('PayType');//01信用卡 02WEBATM
if( $PayTypeValue == "01" ) {$paytype = "paynow_card";}
elseif( $PayTypeValue == "02" ) {$paytype = "paynow_webatm";}
else {exit("付款方式參數錯誤!");}
$pv = getpayval( $paytype );
$WebNo = $pv['pcenteruser'];
$Code = $pv['pcenterkey'];
$TranStatus = getParameter('TranStatus');//交易結果
$OrderNo = getParameter('OrderNo');//商家自訂訂單編號
$TotalPrice = getParameter('TotalPrice');//交易金額
$Note1 = getParameter('Note1');//備註 1
$Note2 = getParameter('Note2');//備註 2
$PassCode = strtolower(getParameter('PassCode'));//驗證碼

//-- 交易成功
if($TranStatus=="S"){//S 表交易成功；F 表交易失敗
$OriPassCode = strtolower(sha1($WebNo.$OrderNo.$TotalPrice.$Code));//驗證碼:WebNo+OrderNo+TotalPrice+商家交易碼
if( $OriPassCode != $PassCode ){
$arr_1 = substr($OrderNo,0,1);
if($arr_1 == "1"){
$arr_2 = substr($OrderNo,1);
$arr_2 = $arr_2 - 100000;
}elseif($arr_1 == "2"){
$arr_2 = substr($OrderNo,1);
}
$msql->query("DELETE FROM {P}_shop_order WHERE orderid='{$arr_2}'");
$msql->query("DELETE FROM {P}_shop_orderitems WHERE orderid='{$arr_2}'");
$showjob_msg="請注意!驗證碼錯誤!!\\r\\n本網站將會刪除這筆訂單，請您重新訂購，不便之處敬請見諒。";
echo "<html>
<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<script>alert(\"".$showjob_msg."\");window.location.href=\"".ROOTPATH."shop/class/\";
</script></head></html>";
}
      			$showjob_msg="交易成功!!";
				$arr_1 = substr($OrderNo,0,1);
				if($arr_1 == "1"){ 
					$arr_1 = "SHOP";
					$arr_2 = substr($OrderNo,1);
					$arr_2 = $arr_2 - 100000;
				}elseif($arr_1 == "2"){
					$arr_1 = "MEMBER";
					$arr_2 = substr($OrderNo,1);
				}else{
					$arr_1 = "NONE";
				}
				$back_coltype = $arr_1;
				$back_orderid = $arr_2;
				$back_fee = $TotalPrice;
				$back_payid = $pv['payid'];
				payback( $back_payid, $back_coltype, $back_orderid, $back_fee );
				}else{
				$arr_1 = substr($OrderNo,0,1);
				if($arr_1 == "1"){ 
					$arr_2 = substr($OrderNo,1);
					$arr_2 = $arr_2 - 100000;
				}elseif($arr_1 == "2"){
					$arr_2 = substr($OrderNo,1);
				}
				$msql->query("DELETE FROM {P}_shop_order WHERE orderid='{$arr_2}'");
				$msql->query("DELETE FROM {P}_shop_orderitems WHERE orderid='{$arr_2}'");
         $ErrDesc = getParameter('ErrDesc');//錯誤描述
          $showjob_msg=$ErrDesc."\\r\\n本網站將會刪除這筆訂單，請您重新訂購，不便之處敬請見諒。";
echo "<html>
	<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<script>
alert(\"".$showjob_msg."\");
window.location.href=\"".ROOTPATH."shop/class/\";
</script></head></html>";
    }

?>