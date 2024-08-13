<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 321 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="js/orderpay.js?1"></script>
</head>
<body>

<?php
$orderid = $_GET['orderid'];
$msql->query( "select * from {P}_shop_order where `orderid`='{$orderid}' limit 0,1" );
if ( $msql->next_record( ) )
{
		$OrderNo = $msql->f( "OrderNo" );
		$user = $msql->f( "user" );
		$name = $msql->f( "name" );
		$memberid = $msql->f( "memberid" );
		$goodstotal = $msql->f( "goodstotal" );
		$yunzoneid = $msql->f( "yunzoneid" );
		$yunid = $msql->f( "yunid" );
		$yuntype = $msql->f( "yuntype" );
		$yunifbao = $msql->f( "yunifbao" );
		$yunbaofei = $msql->f( "yunbaofei" );
		$yunfei = $msql->f( "yunfei" );
		$totaloof = $msql->f( "totaloof" );
		$paytotal = $msql->f( "paytotal" );
		$payid = $msql->f( "payid" );
		$paytype = $msql->f( "paytype" );
		$ifpay = $msql->f( "ifpay" );
		$ifok = $msql->f( "ifok" );
		$iftui = $msql->f( "iftui" );
		$ifyun = $msql->f( "ifyun" );
		$itemtui = $msql->f( "itemtui" );
		$source = $msql->f( "source" );
		$onlineshop = substr($source,0,1);
}
if ( $memberid == "0" )
{
		$user = "非會員";
}
?>
  <div class="tablezone">
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
      <td>訂 單 號：</td>
      <td width="160"><?php echo $OrderNo;?></td>
      <td>訂 購 人：</td>
      <td><?php echo $name;?></td>
    </tr>
    <tr>
      <td width="70">會員帳號：</td>
      <td width="160"><?php echo $user;?></td>
      <td width="70">商品總價：</td>
      <td><?php echo $goodstotal;?> 元</td>
    </tr>
    <tr>
      <td width="70">配送費用：</td>
      <td width="160"><?php echo $yunfei;?> 元 </td>
      <td width="70">保險費用：</td>
      <td><?php echo $yunbaofei;?> 元</td>
    </tr>
    <tr>
      <td width="70">訂單總額：</td>
      <td width="160"><?php echo $paytotal;?> 元</td>
      <td width="70">付款方式：</td>
      <td><?php echo $paytype;?></td>
    </tr>
  </table>
</div>
<div class="listzone" style="margin:10px;padding:15px;font:12px/25px Verdana, Arial, Helvetica, sans-serif">
<input name="orderid" type="hidden" id="orderid" value='<?php echo $orderid;?>' />

<?php
if ( $ifok == "1" )
{
		echo "訂單是已完成狀態，不能進行退款確認";
}
/*else if ( $iftui == "1" )
{
		echo "訂單已退訂，不能進行退款確認";
}*/
else if ( $ifpay != "1" )
{
		echo "訂單未付款，不能進行退款確認";
}
else if ( $memberid == "0" )
{
		echo "本訂單是非會員訂購，訂單退款確認時只將訂單變為未付款狀態，請另外進行實際退款行為<br />";
		echo "<br /><input type='button' class='button' value='將訂單確認為未付款狀態' id='orderunpay'>";
}
else
{
		if($onlineshop == 2){
			echo "本訂單是網路平台訂單，訂單退款不會退到會員帳戶，僅產生消費負記錄<br />";
			echo "<br /><input type='button' class='button' value='確認平台已退刷/退費' id='orderunpay'>";
		}elseif( ($payid == '1' || $payid == '4') && $itemtui == "1"){
			echo "本訂單是刷卡訂單，訂單退款「不會」退到會員帳戶，僅產生消費負記錄(餘額付款會扣除運費後退還)<br />";
			//echo "本訂單是【".$paytype."】，訂單退款確認時訂單款項退到會員帳戶，並產生消費負記錄<br />";
			echo "<br /><input type='button' class='button' value='確認已退刷' id='orderunpay'>";
		}elseif(($payid == '1' || $payid == '4') && $ifyun == "0" && $itemtui == "0"){
			echo "本訂單是刷卡訂單，商品尚未配送，請進入會員頁面「訂單查詢」中操作「取消訂單」<br />";
			//echo "<br /><input type='button' class='button' value='確認已退刷' id='orderunpay'>";
		}else{
			echo "本訂單是【".$paytype."】，訂單退款確認時訂單款項退到會員帳戶，並產生消費負記錄<br />";
			echo "<br /><input type='button' class='button' value='退款到會員帳戶' id='orderunpay'>";
			
		}
}
echo "</div><p>&nbsp;</p></body></html>";
?>