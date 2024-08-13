<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( ROOTPATH."includes/ebmail.inc.php" );
needauth( 321 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>

<script type="text/javascript" src="../../base/js/base.js"></script>

<script type="text/javascript" src="js/orderyun.js"></script>
</head>
<body>

<?php
$orderid = $_GET['orderid'];
$act = $_GET['act'];
$sendtype = $_GET['sendtype'];
$sendno = $_GET['sendno'];

if($act == "sendtypeno" && $orderid){	
	$sendtypeno = $sendtype."|".$sendno;	
	$msql->query( "UPDATE {P}_shop_order SET `sendtypeno`='{$sendtypeno}' WHERE `orderid`='{$orderid}' " );
	//寄發發貨信件
	$fsql->query( "SELECT * FROM {P}_shop_order WHERE `orderid`='{$orderid}' AND `yun_mail`='0'" );
	if( $fsql->next_record() ){					
		$memname = $fsql->f("name");
		$membermail = $fsql->f("email");
		$OrderNo = $fsql->f("OrderNo");
		$paytype = $fsql->f("paytype");
		$paytotal = $fsql->f("paytotal");
		$yun_no = $sendno."^".$strSend[$sendtype]."^".$strSendAPI[$sendtype];
				$msql->query( "SELECT * FROM {P}_shop_mailtemp WHERE tid='2' AND status='1'");//§쩺¼˪O
					if($msql->next_record()){
				$smsg = $memname."|".$GLOBALS['GLOBALS']['CONF'][SiteName]."|".time()."|".$OrderNo."|".$paytype."|".$paytotal."|".$GLOBALS['GLOBALS']['CONF'][SiteHttp]."|".$yun_no;
				$from = $GLOBALS['GLOBALS']['CONF'][SiteEmail];
				shopmail( $membermail, $from, $smsg, "2" );							
					}
				$msql->query("UPDATE {P}_shop_order SET `yun_mail`='1' WHERE `orderid`='{$orderid}'");
	}
}
	
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
		$email = $msql->f( "email" );
		$s_name = $msql->f( "s_name" );
		$s_tel = $msql->f( "s_tel" );
		//$addrnote = $msql->f( "addrnote" );
		$s_addr = $addrnote==1? $msql->f( "s_addr" )." <span style='color:red;'>(偏遠、外離島地區)</span>":$msql->f( "s_addr" );
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
		list($getsendtype,$getsendno) = explode("|",$msql->f( "sendtypeno" ));
		$disaccount = $msql->f( "disaccount" );
		$promoprice = $msql->f( "promoprice" );
}
if ( $memberid == "0" )
{
		$user = "非會員";
}
if ( $ifpay == "1" )
{
		$paystr = "已付款";
}
else
{
		$paystr = "未付款";
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
<div class="tablezone">
<table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr >
      <td width="70">訂 單 號： </td>
      <td width="260"><?php echo $OrderNo;?></td>
      <td width="70">訂 購 人：</td>
      <td><?php echo $name;?></td>
    </tr>
    <tr>
      <td>聯絡電話：</td>
      <td><?php echo $tel;?></td>
      <td>手機號碼：</td>
      <td><?php echo $mobi;?></td>
    </tr>
    <tr>
      <td>電子郵箱：</td>
      <td colspan="3"><?php echo $email;?></td>
    </tr>
  </table></div>
  <div class="tablezone">
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
      <td>收 貨 人：</td>
      <td><?php echo $s_name;?></td>
      <td>聯絡電話：</td>
      <td><?php echo $s_tel;?></td>
    </tr>
    <tr>
      <td width="70">郵遞區號：</td>
      <td><?php echo $s_postcode;?></td>
      <td width="70">手機號碼：</td>
      <td width="260"><?php echo $s_mobi;?></td>
    </tr>
    <tr>
      <td width="70">詳細地址：</td>
      <td width="260" colspan="3"><?php echo $s_addr;?></td>
    </tr>
    <tr>
      <td>商品總價：</td>
      <td><?php echo number_format($goodstotal,0);?> 元</td>
      <td>配送費用：</td>
      <td><?php echo $yunfei;?> 元 </td>
    </tr>
    <tr>
      <td width="70">折扣費用：</td>
      <td width="260"><?php echo number_format($disaccount,0);?>/<?php echo number_format($promoprice,0);?> 元</td>
      <td width="70">訂單總額：</td>
      <td><?php echo number_format($paytotal,0);?> 元</td>
    </tr>
    <tr>
      <td>付款方式：</td>
      <td><?php echo $paytype;?></td>
      <td>是否付款：</td>
      <td><?php echo $paystr;?></td>
    </tr>
  </table>
</div>
	
<a name="send"></a>
<div class="tablezone" style="margin:10px">
	<form name="sendtypeno" action="order_yun.php" method="get" id="sendtypeno">
<table width="100%" border="0" cellpadding="3" cellspacing="0"><tr><td>
	<?php echo $strSendType; ?> <select name="sendtype" id="sendtype" class="input"> 
	<?php 
	foreach($strSend as $key=>$value){
		if($getsendtype == $key){$check[$key] = "selected";}
		echo "<option value=\"".$key."\" ".$check[$key].">".$value."</option>";
	}
	?>
	</select> 
	<?php echo $strSendNo; ?>
	<input type="input" name="sendno" id="sendno" size="30" class="input" value="<?php echo $getsendno; ?>" />
	<input type="hidden" name="orderid" value="<?php echo $orderid; ?>" />
	<input type="hidden" name="act" value="sendtypeno" />
	<input type="submit" name="Submit" class="button" value="送出" />
	<?php 
		if($getsendtype>0){
			$getsendno = (INT)$getsendno;
			echo "<input type=\"button\" id=\"sendcom\" class=\"button\" value=\"貨物托運查詢\" onclick=\"window.open('".$strSendAPI[$getsendtype].$getsendno."');\" />";
		}
	?>
	</td>
</tr></table></form>
</div>

<div class="listzone" style="margin:10px">
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td width="3" height="23" class="biaoti">&nbsp;</td>
    <td width="75" height="23" class="biaoti">商品編號</td>
    <td height="23" class="biaoti">商品名稱</td>
    <td height="50" class="biaoti">顏色</td>
    <td height="50" class="biaoti">尺寸</td>
    <td width="70" height="23" class="biaoti">單價(元)</td>
    <td width="39" height="23" class="biaoti">數量</td>
	<td width="39" height="23" class="biaoti">單位</td>
    <td width="70" height="23" class="biaoti">小計(元)</td>
    <td width="50" height="23" class="biaoti">庫存</td>
    <td height="23" colspan="2" class="biaoti">配送</td>
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
		$yuntime = $msql->f( "yuntime" );
		$msg = $msql->f( "msg" );
		$fz = $msql->f( "fz" );
		$colorname=$msql->f( "colorname" );
		
		$yuntime = date( "Y-n-j", $yuntime );
		if ( $ifyun == "1" )
		{
				$yunimg = "toolbar_ok.gif";
				$yuntext = "退貨";
		}
		else
		{
				$yunimg = "toolbar_no.gif";
				$yuntext = "發貨";
		}
		list($buysize, $buyprice, $buyspecid) = explode("^",$fz);
		if($buyspecid){
			
			$fsql->query( "select stocks,colorname from {P}_shop_conspec where id='{$buyspecid}'" );
			if ( $fsql->next_record( ) )
			{
				$kucun = $fsql->f( "stocks" );
				//$specname = $fsql->f( "colorname" );
			}
		}else{
			$fsql->query( "select kucun from {P}_shop_con where id='{$gid}'" );
			if ( $fsql->next_record( ) )
			{
				$kucun = $fsql->f( "kucun" );
			}
		}
		/*if ( $kucun < $nums && $ifyun != "1" )
		{
				$dis = " disabled ";
		}
		else
		{
				$dis = " ";
		}*/
		echo "<tr>
    <td width=\"3\" height=\"25\">&nbsp;</td>
    <td width=\"75\" height=\"25\">".$bn."</td>
    <td height=\"25\">".$goods."</td>
    		<td height=\"25\">".$colorname."</td>
    		 <td height=\"25\">".$buysize."</td>
    <td width=\"70\" height=\"25\">".number_format($price,0)."</td>
    <td width=\"39\" height=\"25\" id=\"nums_".$itemid."\">".$nums."</td>
    <td width=\"39\" height=\"25\">".$danwei."</td>
    <td width=\"70\" height=\"25\">".number_format($jine,0)."</td>
    <td width=\"50\" height=\"25\" id=\"kucun_".$itemid."\">".$kucun."</td>
    <td width=\"30\" height=\"25\"><img id=\"yunstat_".$itemid."\" src=\"images/".$yunimg."\"  border=\"0\"  /></td>
	<td width=\"50\" height=\"25\" align=\"center\">
	  <input name=\"cc\" type=\"button\" id=\"doyun_".$itemid."\" class=\"doyun\" value=\"".$yuntext."\" ".$dis." /></td>
  </tr>";
}
?>
</table>
</div>
		
<p>&nbsp;</p>
</body>
</html>
