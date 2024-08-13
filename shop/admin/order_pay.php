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
<script type="text/javascript" src="js/orderpay.js"></script>
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
		if( $payid == "0" ){
			$fsql->query( "UPDATE {P}_shop_order SET payid='2',paytype='貨到付款' where orderid='{$orderid}'" );
			$payid = "2";
			$paytype = "貨到付款";
		}
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
/*if ( $ifok == "1" )
{
		echo "訂單是已完成狀態，不能進行付款確認";
}
else*/ if ( $iftui == "1" )
{
		echo "訂單已退訂，不能進行付款確認";
}
else if ( $ifpay == "1" )
{
		echo "訂單已付款，不能重複進行付款確認";
}
else if ( $payid == "0" )
{
		echo "本訂單的付款方式是會員帳戶扣款，進行付款確認時將從會員帳戶扣除訂單所需費用<br />";
		$fsql->query( "select account from {P}_member where memberid='{$memberid}'" );
		if ( $fsql->next_record( ) )
		{
				$account = $fsql->f( "account" );
		}
		if ( $account < $paytotal )
		{
				echo "訂單總金額：".$paytotal." 元，會員帳戶餘額：".$account." 元，會員帳戶餘額不足";
		}
		else
		{
				echo "訂單總金額：".$paytotal." 元，會員帳戶餘額：".$account." 元，可以從會員帳戶扣款";
				echo "<br /><br /><input type='button' class='button' value='會員帳戶扣款' id='orderpaychk'>";
		}
}
else
{
		$fsql->query( "select * from {P}_member_paycenter where id='{$payid}'" );
		if ( $fsql->next_record( ) )
		{
				$pcenter = $fsql->f( "pcenter" );
				$pcentertype = $fsql->f( "pcentertype" );
				if ( $pcentertype == "0" )
				{
						if ( $memberid == "0" )
						{
								echo "本訂單是非會員訂購，所選付款方式是【".$pcenter."】，是非會員線下付款<br />";
								echo "線下付款的後台訂單付款確認，用於確定已通過線下方式收到款<br />";
								echo "非會員訂單付款確認，將直接把訂單狀態改變為已付款狀態，不發生會員帳戶處理<br />";
								echo "<br /><input type='button' class='button' value='確定已通過".$pcenter."收到款' id='orderpaychk'>";
						}
						else
						{
								echo "本訂單是會員訂購，所選付款方式是【".$pcenter."】，是會員線下付款<br />";
								echo "線下付款的後台訂單付款確認，用於確定已通過線下方式收到款<br />";
								echo "會員訂單付款確認，將同時進行消費紀錄，會員帳戶餘額不變<br />";
								echo "<br /><input type='button' class='button' value='確定已通過".$pcenter."收到款' id='orderpaychk'>";
						}
				}
				else if ( $memberid == "0" )
				{
						echo "本訂單是非會員訂購，所選付款方式是【".$pcenter."】，是非會員線上付款<br />";
						echo "線上付款的後台訂單付款確認，用於通過線上付款平台付款但未能正常返回的情況<br />";
						echo "非會員訂單付款確認，將直接把訂單狀態改變為已付款狀態，不發生會員帳戶處理<br />";
						echo "<br /><input type='button' class='button' value='確定已通過".$pcenter."收到款' id='orderpaychk'>";
				}
				else
				{
						echo "本訂單是會員訂購，所選付款方式是【".$pcenter."】，是會員線上付款<br />";
						echo "線上付款的後台訂單付款確認，用於通過線上付款平台付款但未能正常返回的情況<br />";
						echo "會員訂單付款確認，將同時進行消費紀錄，會員帳戶餘額不變<br />";
						echo "<br /><input type='button' class='button' value='確定已通過".$pcenter."收到款' id='orderpaychk'>";
				}
		}
		else
		{
				echo "訂單所選付款方式不存在，可能已被管理員刪除";
		}
}
echo "</div><p>&nbsp;</p></body></html>";
?>