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
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/orderdetail.js?523"></script>
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
		$email = $msql->f( "email" );
		//$email = $user;
		$s_name = $msql->f( "s_name" );
		$s_tel = $msql->f( "s_tel" );
		//$addrnote = $msql->f( "addrnote" );
		$s_addr = $addrnote==1? $msql->f( "s_addr" )." <span style='color:red;'>(偏遠、外離島地區)</span>":$msql->f( "s_addr" );
		//$s_addr = $msql->f( "s_addr" );
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
		$totalcent = $msql->f( "totalcent" );
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
		$country = $msql->f( "country" );
		$uptime = $msql->f( "uptime" );
		
		$uptime = date( "Y-m-d H:i:s", $uptime );
		
		$invoicename = $msql->f( "invoicename" );
		$invoicenumber = $msql->f( "invoicenumber" );
		
		$CreateInvoice = $msql->f( "CreateInvoice" );
		
		
		/*捐款*/
		list($contribute_title,$contribute_code) = explode("|",$msql->f( "contribute" ));
		
		/*載具*/
		list($integrated_title,$integrated_code) = explode("|",$msql->f( "integrated" ));
		
		$disaccount = (INT)$msql->f( "disaccount" );
		$promoprice =  round($msql->f( "promoprice" ));
		
		
		
		//實際原始付款 2019-04-30
		$getJine = $fsql->getone( "select SUM(jine) from {P}_shop_orderitems where orderid='{$orderid}'" );
		$totaljine = $getJine["SUM(jine)"];
		$promocode =  $msql->f( "promocode" );
		$getPromo = $fsql->getone( "select type,type_value,pricelimit from {P}_shop_promocode where `code`='{$promocode}' limit 0,1" );
		if($getPromo["type"] == 1){
			if($totaljine>$getPromo["pricelimit"]){
				$cutpromoprice = $totalcent - $getPromo["type_value"];
				$oripromoprice = $getPromo["type_value"];
			}else{
				$cutpromoprice = $totalcent;
			}
		}elseif($getPromo["type"] == 2){
			$cutpromoprice = round($totalcent * $getPromo["type_value"]);
		}
		
		if( ($totalcent-$promoprice) <1500){
			$oripay = $cutpromoprice + $yunfei;
		}else{
			if($totaljine != $goodstotal){
				$oripay = $cutpromoprice - $oripromoprice;
			}else{
				$oripay = $cutpromoprice - $promoprice;
			}
		}
}

/*修改載具*/
//$msql->query( "UPDATE {P}_shop_order SET integrated='銳馬會員載具|$user|EG0029' WHERE `orderid`='{$orderid}'" );

if ( $memberid == "0" )
{
		$user = "非會員";
}
if ( $ifpay == "1" )
{
		$paystat = "已付款";
		$paytime = date( "Y-m-d H:i:s", $paytime );
}
else
{
		$paystat = "未付款";
		$paytime = "未付款";
}
if ( $ifyun == "1" )
{
		$yunstat = "已發貨";
		$yuntime = date( "Y-m-d H:i:s", $yuntime );
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
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF" class="chgsaddr">
    <tr >
      <td width="78" align="center" bgcolor="#F2F9FD">訂 單 號： </td>
      <td width="230" bgcolor="#FFFFFF"><?php echo $OrderNo;?></td>
      <td width="78" align="center" bgcolor="#F2F9FD">訂 購 人：</td>
      <td bgcolor="#FFFFFF"><input name="name" id="name" class="chginput" value="<?php echo $name;?>" disabled /></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">聯絡電話：</td>
      <td width="230" bgcolor="#FFFFFF"><input name="tel" id="tel" class="chginput" value="<?php echo $tel;?>" disabled /></td>
      <td width="78" align="center" bgcolor="#F2F9FD">手機號碼：</td>
      <td bgcolor="#FFFFFF"><input name="mobi" id="mobi" class="chginput" value="<?php echo $mobi;?>" disabled /></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">電子郵箱：</td>
      <td width="230" bgcolor="#FFFFFF" colspan="3"><input name="email" id="email" class="chginput" value="<?php echo $email;?>" disabled /></td>
      <!--<td width="78" align="center" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"><?php echo $qq;?></td>-->
    </tr>
  </table>
  <br />
  <div id="fahuodan">
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF"  id="chgsaddr">
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">收 貨 人：</td>
      <td width="230" bgcolor="#FFFFFF"><input name="s_name" id="s_name" class="chginput" value="<?php echo $s_name;?>" disabled /></td>
      <td width="78" align="center" bgcolor="#F2F9FD">聯絡電話：</td>
      <td bgcolor="#FFFFFF"><input name="s_tel" id="s_tel" class="chginput" value="<?php echo $s_tel;?>" disabled /></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">手機號碼：</td>
      <td width="230" bgcolor="#FFFFFF"><input name="s_mobi" id="s_mobi" class="chginput" value="<?php echo $s_mobi;?>" disabled /></td>
      <td width="78" align="center" bgcolor="#F2F9FD">郵遞區號：</td>
      <td bgcolor="#FFFFFF"><input name="s_postcode" id="s_postcode" class="chginput" value="<?php echo $s_postcode;?>" disabled /></td>
    </tr>
    <tr>
      <td width="78" align="center" bgcolor="#F2F9FD">詳細地址：</td>
      <td width="230" bgcolor="#FFFFFF" colspan="3"><input name="s_addr" id="s_addr" class="chginput" style="width: 499px;" value="<?php echo $country;?> <?php echo $s_addr;?>" disabled /></td>
    </tr>
    <tr id="showchg" style="display:none;">
      <td width="78" align="center" bgcolor="#F2F9FD">修改：</td>
      <td width="230" bgcolor="#FFFFFF" colspan="3"><button class="button" id="chgaddr">更改</button></td>
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
		$itemtui = $msql->f( "itemtui" );
		$ifyun = $msql->f( "ifyun" );
		$msg = $msql->f( "msg" );
		$colorname = $msql->f( "colorname" );
		
		if($iftui || $itemtui){
			$goods = "<del>".$goods."</del> <span style='color:red;'><退></span>";
			$jine = "<del>".number_format($jine,0)."</del>";
		}else{
			$jine = number_format($jine,0);
		}
		
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
    		 <td height=\"25\">".$speccolor.$colorname." ".$specname."</td>
    		 <td height=\"25\">".$specsize."</td>
    <td width=\"80\" height=\"25\">".number_format($price,0)."</td>
    <td width=\"39\" height=\"25\" id=\"nums_".$itemid."\">".$nums."</td>
    <td width=\"39\" height=\"25\">".$danwei."</td>
    <td width=\"80\" height=\"25\">".$jine."</td>
    </tr>";
    	/**/
		$fsql->query( "select * from {P}_member_paycenter order by xuhao" );
		while ( $fsql->next_record( ) )
		{
				$id = $fsql->f( "id" );
				$pcenter = $fsql->f( "pcenter" );
				$ifuse = $fsql->f( "ifuse" )=="0"? "(現場)":"";
				if($pcenter == $paytype){
					$paytypestr .= "<option value='".$id."' selected>".$pcenter.$ifuse."</option>";
				}else{
					$paytypestr .= "<option value='".$id."' >".$pcenter.$ifuse."</option>";
				}
		}
		//$fsql->query( "update {P}_shop_order set totaloof='420',paytotal='420' where orderid='{$orderid}'" );
}
?>
</table>
</div>

<br />
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">商品總價：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo number_format($goodstotal,0);?> 元</td>
    <td width="78" align="center" bgcolor="#F2F9FD">配送費用：</td>
    <td bgcolor="#FFFFFF"><?php echo number_format($yunfei,0);?> 元 </td>
  </tr>
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">折價(餘/券)：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo number_format($disaccount,0);?>/<?php echo number_format($promoprice,0);?> 元</td>
    <td width="78" align="center" bgcolor="#F2F9FD">訂單總額：</td>
    <td bgcolor="#FFFFFF"><?php echo number_format($paytotal,0);?> 元</td>
  </tr>
  <tr>
    <td rowspan="2" width="78" align="center" bgcolor="#F2F9FD">付款方式：</td>
    <td rowspan="2" width="230" bgcolor="#FFFFFF"><select id="chkpaytype"><?php echo $paytypestr;?></select></td>
    <td width="78" align="center" bgcolor="#F2F9FD">退款金額：</td>
    <td bgcolor="#FFFFFF"><?php echo number_format($oripay - $paytotal,0);?></td>
  </tr>
  <tr>
	<td width="78" align="center" bgcolor="#F2F9FD">原始付款：</td>
    <td bgcolor="#FFFFFF"><?php echo $paystat;?> <?php echo number_format($oripay,0);?></td>
  </tr>
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">折扣碼：</td>
    <td width="230" bgcolor="#FFFFFF" colspan="3"><?php echo $promocode;?></td>
  </tr> 
</table>
<br />
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
  <tr>
    <td width="78" align="left" bgcolor="#F2F9FD" colspan="4">發票資訊：</td>
  </tr> 
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">捐贈單位：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo $contribute_title;?></td>
    <td width="78" align="center" bgcolor="#F2F9FD">單位編號：</td>
    <td bgcolor="#FFFFFF"><?php echo $contribute_code;?></td>
  </tr> 
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">發票載具：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo $integrated_title;?></td>
    <td width="78" align="center" bgcolor="#F2F9FD">載具條碼：</td>
    <td bgcolor="#FFFFFF"><?php echo $integrated_code;?></td>
  </tr> 
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">發票抬頭：</td>
    <td width="230" bgcolor="#FFFFFF"><?php echo $invoicename;?></td>
    <td width="78" align="center" bgcolor="#F2F9FD">統一編號：</td>
    <td bgcolor="#FFFFFF"><?php echo $invoicenumber;?></td>
  </tr> 
  <tr>
    <td width="78" align="center" bgcolor="#F2F9FD">發票號碼：</td>
    <td width="230" bgcolor="#FFFFFF" colspan="3"><?php echo $CreateInvoice;?>(電子發票開立)</td>
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
<div id="printout"> <div style="float:right;margin-left:10px;"><a href="order_print_b.php?orderid=<?php echo $orderid;?>">[列印退貨單]</a></div><div style="float:right"><a href="order_print.php?orderid=<?php echo $orderid;?>">[列印發貨單]</a></div>
訂單狀態：[<?php echo $paystat;?>] [<?php echo $yunstat;?>] [<?php echo $okstat;?>]  [付款日期：<?php echo $paytime;?>] [發貨日期：<?php echo $yuntime;?>] [最後更新時間：<?php echo $uptime;?>]</div>
<p>&nbsp;</p>
</body>
</html>