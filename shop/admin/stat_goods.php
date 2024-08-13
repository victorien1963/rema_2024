<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 331 );
$tp = $_REQUEST['tp'];
$key = $_GET['key'];
$showtime = $_GET['showtime'];
$showtype = $_GET['showtype'];
$startday = $_GET['startday'];
$endday = $_GET['endday'];
if ( $startday == "" || $endday == "" )
{
		$endday = date( "Y-m-d" );
		$enddayArr = explode( "-", $endday );
		$endtime = mktime( 23, 59, 59, $enddayArr[1], $enddayArr[2], $enddayArr[0] );
		$starttime = $endtime - 691199;
		$startday = date( "Y-m-d", $starttime );
}
else
{
		$enddayArr = explode( "-", $endday );
		$endtime = mktime( 23, 59, 59, $enddayArr[1], $enddayArr[2], $enddayArr[0] );
		$startdayArr = explode( "-", $startday );
		$starttime = mktime( 0, 0, 0, $startdayArr[1], $startdayArr[2], $startdayArr[0] );
}
if ( $showtime == "" )
{
		$showtime = "dtime";
}
if ( $showtype == "" )
{
		$showtype = "goods";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/Date/WdatePicker.js"></script>
</head>
<body>
<div class="searchzone">
<table width="100%" border="0" cellspacing="0" cellpadding="3"> 
  <tr> 
      <td height="28"  > 
        <table border="0" cellspacing="1" cellpadding="0" width="100%">
           <tr> 
            <td> <form name="search" action="stat_goods.php" method="get" id="ordersearch">
<select name="showtime" id="showtime">
     			 <option value="dtime" <?php echo seld( $showtime, "dtime" );?>>按訂單送出時間</option>
     			 <option value="yuntime" <?php echo seld( $showtime, "yuntime" );?>>按商品配送時間</option>
   			 </select>
			 <input name="startday" type="text"  class="input" id="startday" style="cursor:pointer" onClick="WdatePicker()"  value="<?php echo $startday;?>" size="9"  readonly/>             -
			 <input name="endday" type="text"  class="input" id="endday" style="cursor:pointer" onClick="WdatePicker()"  value="<?php echo $endday;?>" size="9"  readonly/>              &nbsp; &nbsp;			 
<select name="showtype" id="showtype">
     			 <option value="goods" <?php echo seld( $showtype, "goods" );?>>按商品名稱查詢</option>
     			 <option value="bn" <?php echo seld( $showtype, "bn" );?>>按商品編號查詢</option>
   			 </select>
              <input type="text" name="key" value="<?php echo $key;?>"  size="18" class="input" />
              <input type="submit" name="Submit" value="查詢" class="button" />
              <input name="tp" type="hidden" id="tp" value="search" />
            </form></td>
          </tr>
        </table>
    </td>
  </tr> 
</table>

</div>

<?php
if ( $tp == "search" && $key != "" )
{
		trylimit( "_shop_order", 50, "orderid" );
		$scl = " iftui!='1' ";
		if ( $showtime == "yuntime" )
		{
				$scl .= " and yuntime>{$starttime} and yuntime<{$endtime} ";
		}
		else
		{
				$scl .= " and dtime>{$starttime} and dtime<{$endtime} ";
		}
		if ( $showtype == "bn" )
		{
				$scl .= " and bn='{$key}' ";
		}
		else
		{
				$scl .= " and goods='{$key}' ";
		}
?>
		<div class="listzone">
		<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
          <tr>
            <td width="32"  class="biaoti" style="padding-left:10px">序號</td>
            <td width="75" height="23"  class="biaoti" >商品編號</td>
            <td height="23"  class="biaoti" >商品名稱</td>
            <td width="70"  class="biaoti" >商品價格</td>
    		<td width="50"  class="biaoti" >數量</td>
            <td width="50" height="23"  class="biaoti" >單位</td>
            <td width="70"  class="biaoti" >金額</td>
            <td width="70"  class="biaoti" >訂購人</td>
            <td width="70" height="23"  class="biaoti" >下單時間</td>
		    <td width="70"  class="biaoti" >配送時間</td>
		    <td width="33" height="23" align="center" class="biaoti" >訂單</td>
	      </tr>
<?php
		$p = 1;
		$tnums = 0;
		$tjine = 0;
		$msql->query( "select * from {P}_shop_orderitems where {$scl} order by dtime desc" );
		while ( $msql->next_record( ) )
		{
				$orderid = $msql->f( "orderid" );
				$memberid = $msql->f( "memberid" );
				$gid = $msql->f( "gid" );
				$goods = $msql->f( "goods" );
				$bn = $msql->f( "bn" );
				$price = $msql->f( "price" );
				$nums = $msql->f( "nums" );
				$weight = $msql->f( "weight" );
				$danwei = $msql->f( "danwei" );
				$jine = $msql->f( "jine" );
				$cent = $msql->f( "cent" );
				$ifyun = $msql->f( "ifyun" );
				$iftui = $msql->f( "iftui" );
				$dtime = $msql->f( "dtime" );
				$yuntime = $msql->f( "yuntime" );
				$dtime = date( "y-m-d", $dtime );
				if ( $ifyun == "1" )
				{
						$yuntime = date( "y-m-d", $yuntime );
				}
				else
				{
						$yuntime = "未配送";
				}
				$fsql->query( "select * from {P}_shop_order where orderid='{$orderid}'" );
				if ( $fsql->next_record( ) )
				{
						$name = $fsql->f( "name" );
						$ifpay = $fsql->f( "ifpay" );
				}
				if ( $ifpay == "1" )
				{
						$tnums += $nums;
						$tjine += $jine;
						echo " 
          <tr class=\"list\" id=\"tr_".$orderid."\" >
            <td   width=\"32\" valign=\"top\"  style=\"padding-left:10px\">".$p."</td>
            <td   width=\"75\" valign=\"top\"  >".$bn." </td>
			 <td valign=\"top\">".$goods." </td>
			 <td width=\"70\" valign=\"top\" >
			 ".$price."			 </td>
			 <td width=\"50\" valign=\"top\">
			 ".$nums."			 </td>
			 <td width=\"50\" valign=\"top\" id=\"paytotal_".$orderid."\">".$danwei."</td>
            <td width=\"70\" valign=\"top\" >".$jine."             </td>
            <td   width=\"70\" valign=\"top\">".$name." </td>
            <td   width=\"70\" valign=\"top\">".$dtime." </td>
            <td   width=\"70\" valign=\"top\">".$yuntime." </td>
            <td  width=\"33\" align=\"center\" valign=\"top\" ><a href=\"order_detail.php?orderid=".$orderid."\"><img src=\"images/look.png\" width=\"24\" height=\"24\"  border=\"0\" /></a> </td>
          </tr>";
						$p++;
				}
		}
		$tjine = number_format( $tjine, 2, ".", "" );
		echo " 
        <tr class=\"list\" >
            <td valign=\"top\"  class=\"biaoti1\" style=\"padding-left:10px\">合計</td>
            <td width=\"75\" valign=\"top\" class=\"biaoti1\"  >-</td>
            <td valign=\"top\" class=\"biaoti1\">-</td>
            <td valign=\"top\" class=\"biaoti1\" >-</td>
            <td width=\"50\" valign=\"top\" class=\"biaoti1\">".$tnums."</td>
            <td width=\"50\" valign=\"top\"  class=\"biaoti1\">-</td>
            <td valign=\"top\" class=\"biaoti1\" >".$tjine."</td>
            <td valign=\"top\"  class=\"biaoti1\">-</td>
            <td valign=\"top\"  class=\"biaoti1\">-</td>
            <td valign=\"top\"  class=\"biaoti1\">-</td>
            <td align=\"center\" valign=\"top\" class=\"biaoti1\" >-</td>
    </tr>
</table>
</div>";
}
else
{
		echo "<div style=\"margin:10px;font:12px/25px Verdana, Arial, Helvetica, sans-serif\">
請輸入商品名稱或商品編號，對指定商品進行銷售統計
</div>";
}
?>
</body>
</html>