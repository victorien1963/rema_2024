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
<script type="text/javascript" src="js/orderdetail.js"></script>
</head>
<body>

<?php
$orderid = $_GET['orderid'];
$msql->query( "select * from {P}_shop_order where `orderid`='{$orderid}' limit 0,1" );
if ( $msql->next_record( ) )
{
		$OrderNo = $msql->f( "OrderNo" );
		$memberid = $msql->f( "memberid" );
		$user = $msql->f( "user" );
		$name = $msql->f( "name" );
		$tel = $msql->f( "tel" );
		$mobi = $msql->f( "mobi" );
		$qq = $msql->f( "qq" );
		//$email = $msql->f( "email" );
		$email = $user;
		$s_name = $msql->f( "s_name" );
		$s_tel = $msql->f( "s_tel" );
		$s_addr = $msql->f( "s_addr" );
		$s_postcode = $msql->f( "s_postcode" );
		$s_mobi = $msql->f( "s_mobi" );
		$s_qq = $msql->f( "s_qq" );
		$goodstotal = $msql->f( "goodstotal" );
		$yunzoneid = $msql->f( "yunzoneid" );
		$yunid = $msql->f( "yunid" );
		$yuntype = $msql->f( "yuntype" );
		$yunifbao = $msql->f( "yunifbao" );
		$yunbaofei = $msql->f( "yunbaofei" );
		$yunfei = $msql->f( "yunfei" );
		$totaloof = $msql->f( "totaloof" );
		$paytotal = $msql->f( "paytotal" );
		$totalweight = $msql->f( "totalweight" );
		$paytype = $msql->f( "paytype" );
		$ifpay = $msql->f( "ifpay" );
		$ifyun = $msql->f( "ifyun" );
		$ifok = $msql->f( "ifok" );
		$iftui = $msql->f( "iftui" );
		$bz = $msql->f( "bz" );
		$paytime = $msql->f( "paytime" );
		$yuntime = $msql->f( "yuntime" );
		
		$promoprice = $msql->f( "promoprice" );
		
		$invoicename = $msql->f( "invoicename" );
		$invoicenumber = $msql->f( "invoicenumber" );
}
if ( $memberid == "0" )
{
		$user = "非會員";
}
if ( $ifpay == "1" )
{
		$paystat = "已付款";
		$paytime = date( "Y-m-d", $paytime );
}
else
{
		$paystat = "未付款";
		$paytime = "未付款";
}
if ( $ifyun == "1" )
{
		$yunstat = "已發貨";
		$yuntime = date( "Y-m-d", $yuntime );
}
else
{
		$yunstat = "未發貨";
		$yuntime = "未發貨";
}
if ( $ifok == "1" )
{
		$okstat = "已完成";
}
else
{
		$okstat = "處理中";
}
if ( $iftui == "1" )
{
		$tuistat = "退訂訂單";
}
else
{
		$tuistat = "有效訂單";
}
$msql->query( "select * from {P}_shop_yunzone where id='{$yunzoneid}'" );
if ( $msql->next_record( ) )
{
		$zonepid = $msql->f( "pid" );
		$zonestr = $msql->f( "zone" );
		if ( $zonepid != "0" )
		{
				$fsql->query( "select * from {P}_shop_yunzone where id='{$zonepid}'" );
				if ( $fsql->next_record( ) )
				{
						$pzone = $fsql->f( "zone" );
						$zonestr = $pzone." ".$zonestr;
				}
		}
}
?>
<div id="shoporderdetail" style="margin:20px;width:630px">
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
    <tr >
      <td width="78" align="center" bgcolor="#F2F9FD">訂 單 號： </td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $OrderNo;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">訂 購 人：</td>
      <td bgcolor="#FFFFFF"><?php echo $name;?></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">聯絡電話：</td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $tel;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">手機號碼：</td>
      <td bgcolor="#FFFFFF"><?php echo $mobi;?></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">電子郵箱：</td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $email;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">即時通號碼：</td>
      <td bgcolor="#FFFFFF"><?php echo $qq;?></td>
    </tr>
  </table>
  <br />
  <div id="fahuodan">
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">收 貨 人：</td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $s_name;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">聯絡電話：</td>
      <td bgcolor="#FFFFFF"><?php echo $s_tel;?></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">手機號碼：</td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $s_mobi;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">即時通號碼：</td>
      <td bgcolor="#FFFFFF"><?php echo $s_qq;?></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">配送地區：</td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $zonestr;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">郵遞區號：</td>
      <td bgcolor="#FFFFFF"><?php echo $s_postcode;?></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">詳細地址：</td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $s_addr;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">配送方法：</td>
      <td bgcolor="#FFFFFF"><?php echo $yuntype;?></td>
    </tr>
  </table>
  <br />
  <table width="100%" border="0" cellpadding="3" cellspacing="0" style="border:1px #def solid">
  <tr>
    <td width="3" height="23" class="biaoti">&nbsp;</td>
    <td width="75" height="23" class="biaoti">商品編號</td>
    <td height="23" class="biaoti">商品名稱</td>
    <td height="23" class="biaoti">顏色</td>
    <td height="23" class="biaoti">尺寸</td>
    <td width="80" height="23" class="biaoti">單價(元)</td>
    <td width="39" height="23" class="biaoti">數量</td>
	<td width="39" height="23" class="biaoti">單位</td>
    <td width="80" height="23" class="biaoti">小計(元)</td>
    </tr>
 
<?php
$msql->query( "select * from {P}_shop_orderitems where orderid='{$orderid}'" );
while ( $msql->next_record( ) )
{
		$itemid = $msql->f( "id" );
		$memberid = $msql->f( "memberid" );
		$orderid = $msql->f( "orderid" );
		$gid = $msql->f( "gid" );
		$bn = $msql->f( "bn" );
		$goods = $msql->f( "goods" );
		$price = $msql->f( "price" );
		$weight = $msql->f( "weight" );
		$nums = $msql->f( "nums" );
		$danwei = $msql->f( "danwei" );
		$jine = $msql->f( "jine" );
		$cent = $msql->f( "cent" );
		$iftui = $msql->f( "iftui" );
		$ifyun = $msql->f( "ifyun" );
		$msg = $msql->f( "msg" );
		
		list($specsize,$specprice,$specid) = explode("^",$msql->f( "fz" ));
		$ccode = $tsql->getone("select colorcode from {P}_shop_conspec where id='{$specid}'");
	$tsql->query("select * from {P}_shop_conspec where gid='{$gid}' and colorcode='$ccode[colorcode]' order by id");
	while($tsql->next_record()){
		if($tsql->f("iconsrc")){
			$speccolor = "<img src='".ROOTPATH.$tsql->f(iconsrc)."' width='10' height='10' />";
			$specname = $tsql->f(colorname);
		}
	}
		echo "<tr>
    <td width=\"3\" height=\"25\">&nbsp;</td>
    <td width=\"75\" height=\"25\">".$bn."</td>
    <td height=\"25\">".$goods."</td>
    		 <td height=\"25\">".$speccolor." ".$specname."</td>
    		 <td height=\"25\">".$specsize."</td>
    <td width=\"80\" height=\"25\">".$price."</td>
    <td width=\"39\" height=\"25\" id=\"nums_".$itemid."\">".$nums."</td>
    <td width=\"39\" height=\"25\">".$danwei."</td>
    <td width=\"80\" height=\"25\">".$jine."</td>
    </tr>";
}
?>
</table>
</div>

<br />
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">商品總價：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo $goodstotal;?> 元</td>
    <td width="78" align="center" bgcolor="#F2F9FD">配送費用：</td>
    <td bgcolor="#FFFFFF"><?php echo $yunfei;?> 元 </td>
  </tr>
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">保險費用：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo $yunbaofei;?> 元</td>
    <td width="78" align="center" bgcolor="#F2F9FD">訂單總額：</td>
    <td bgcolor="#FFFFFF"><?php echo $paytotal;?> 元</td>
  </tr>
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">付款方式：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo $paytype;?></td>
    <td width="78" align="center" bgcolor="#F2F9FD">是否付款：</td>
    <td bgcolor="#FFFFFF"><?php echo $paystat;?></td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">發票抬頭：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo $invoicename;?></td>
    <td width="78" align="center" bgcolor="#F2F9FD">統一編號：</td>
    <td bgcolor="#FFFFFF"><?php echo $invoicenumber;?></td>
  </tr> 
</table>
<br />
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">訂購備註：</td>
    <td bgcolor="#FFFFFF">
	<input type="hidden" id="orderid" value="<?php echo $orderid;?>" />
	
<?php
if ( $ifok != "1" && $iftui != "1" )
{
		echo "<textarea rows=\"3\" id=\"bztext\" style=\"border:0px;width:500px;height:60px\">".$bz."</textarea>
	<input type=\"button\" class=\"button\" id=\"savebz\" value=\"保存備註資訊\" style=\"display:none\" />";
}
else
{
		echo nl2br( $bz );
}
?>
    
</td>
    </tr>
</table>
</div>
<br />
<div id="printout"> <div id="print_fahuo_button">[列印發貨清單]</div><div id="print_button">[列印訂單]</div>
訂單狀態：[<?php echo $paystat;?>] [<?php echo $yunstat;?>] [<?php echo $okstat;?>]  [付款日期：<?php echo $paytime;?>] [發貨日期：<?php echo $yuntime;?>] </div>
<p>&nbsp;</p>
</body>
</html>