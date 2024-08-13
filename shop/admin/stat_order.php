<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 330 );
$step = $_REQUEST['step'];
$tp = $_REQUEST['tp'];
$page = $_REQUEST['page'];
$key = $_GET['key'];
$showpay = $_GET['showpay'];
$showyun = $_GET['showyun'];
$showtui = $_GET['showtui'];
$showok = $_GET['showok'];
$showpayid = $_GET['showpayid'];
$showmem = $_GET['showmem'];
$startday = $_GET['startday'];
$endday = $_GET['endday'];
$showsource = $_GET['showsource'];
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
if ( $showpay == "" )
{
		$showpay = "all";
}
if ( $showyun == "" )
{
		$showyun = "all";
}
if ( $showok == "" )
{
		$showok = "1";
}
if ( $showtui == "" )
{
		$showtui = "0";
}
if ( $showpayid == "" )
{
		$showpayid = "all";
}
if ( $showmem == "" )
{
		$showmem = "all";
}
if ( $showsource == "" )
{
		$showsource = "all";
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
            <td> <form name="search" action="stat_order.php" method="get" id="ordersearch">
         
    <input name="startday" type="text"  class="input" id="startday" style="cursor:pointer" onClick="WdatePicker()"  value="<?php echo $startday;?>" size="9"  readonly/>
             -
			 <input name="endday" type="text"  class="input" id="endday" style="cursor:pointer" onClick="WdatePicker()"  value="<?php echo $endday;?>" size="9"  readonly/>
              
			   
<select name="showpay" id="showpay">
      			<option value="all"  <?php echo seld( $showpay, "all" );?>>付款狀態</option>
     			 <option value="0" <?php echo seld( $showpay, "0" );?>>未付款</option>
     			 <option value="1" <?php echo seld( $showpay, "1" );?>>已付款</option>
   			 </select>
   			 
<select name="showyun" id="showyun">
     			 <option value="all"  <?php echo seld( $showyun, "all" );?>>配送狀態</option>
    			  <option value="0"  <?php echo seld( $showyun, "0" );?>>未配送</option>
    			  <option value="1"  <?php echo seld( $showyun, "1" );?>>已配送</option>
   			 </select>
	  		
<select name="showok" id="showok">
    			  <option value="0"  <?php echo seld( $showok, "0" );?>>處理中訂單</option>
      			<option value="1"  <?php echo seld( $showok, "1" );?>>已完成訂單</option>
   			 </select>
			 
<select name="showtui" id="showtui">
    			  <option value="0" <?php echo seld( $showtui, "0" );?>>有效訂單</option>
      			<option value="1" <?php echo seld( $showtui, "1" );?>>退訂訂單</option>
      			<!--option value="2" <?php echo seld( $showtui, "2" );?>>退貨訂單</option-->
   			 </select>
			  
<select name="showpayid" id="showpayid">
      			<option value="all"  <?php echo seld( $showpayid, "all" );?>>付款方式</option>
     			 <option value="0" <?php echo seld( $showpayid, "0" );?>>會員帳戶扣款</option>
     			 
<?php
$fsql->query( "select * from {P}_member_paycenter order by xuhao" );
while ( $fsql->next_record( ) )
{
		$pcenter = $fsql->f( "pcenter" );
		$payid = $fsql->f( "id" );
		if ( $showpayid == $payid )
		{
				echo "<option value=".$payid." selected>".$pcenter."</option>";
		}
		else
		{
				echo "<option value=".$payid." >".$pcenter."</option>";
		}
}
?>
   			 </select>
			 
<select name="showmem" id="showmem">
    			 <option value="all"  <?php echo seld( $showmem, "all" );?>>是否會員</option>
     			 <option value="0" <?php echo seld( $showmem, "0" );?>>非會員訂單</option>
     			 <option value="1" <?php echo seld( $showmem, "1" );?>>會員訂單</option>
   			 </select>
			   <select name="showsource" id="showsource">
      			<option value="all"  <?php echo seld( $showsource, "all" ); ?>>訂單來源</option>
      			<option value="0"  <?php echo seld( $showsource, "0" ); ?>>官網訂單</option>
     			 <option value="1-1" <?php echo seld( $showsource, "1-1" ); ?>>板橋店</option>
     			 <option value="1-2" <?php echo seld( $showsource, "1-2" ); ?>>新莊店</option>
     			 <option value="1-3" <?php echo seld( $showsource, "1-3" ); ?>>內湖店</option>
     			 <option value="1-4" <?php echo seld( $showsource, "1-4" ); ?>>三重店</option>
     			 <option value="1-5" <?php echo seld( $showsource, "1-5" ); ?>>南屯店</option>
     			 <option value="2-1" <?php echo seld( $showsource, "2-1" ); ?>>蝦皮</option>
     			 <option value="2-2" <?php echo seld( $showsource, "2-2" ); ?>>MOMO</option>
     			 <option value="2-3" <?php echo seld( $showsource, "2-3" ); ?>>Yahoo超級商城</option>
   			 </select>
              <input type="text" name="key" value="<?php echo $key;?>"  size="6" class="input" />
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
if ( $tp == "search" )
{
		trylimit( "_shop_order", 50, "orderid" );
		
		if( $showtui == "2"  ){
			$scl = " uptime>{$starttime} and uptime<{$endtime} ";
		}else{
			$scl = " dtime>{$starttime} and dtime<{$endtime} ";
		}
		
		
		if ( $showpay == "1" || $showpay == "0" )
		{
				$scl .= " and ifpay='{$showpay}' ";
		}
		if ( $showyun == "1" || $showyun == "0" )
		{
				$scl .= " and ifyun='{$showyun}' ";
		}
		if ( $showok == "1" || $showok == "0" )
		{
				$scl .= " and ifok='{$showok}' ";
		}
		if ( $showtui == "1" || $showtui == "0" )
		{
				$scl .= " and iftui='{$showtui}'";
		}elseif( $showtui == "2"  ){
				$scl .= " and iftui='1' and itemtui='1' ";
		}
		if ( $showpayid != "all" && $showpayid != "" )
		{
				$scl .= " and payid='{$showpayid}' ";
		}
		if ( $showmem == "0" )
		{
				$scl .= " and memberid='0' ";
		}
		if ( $showmem == "1" )
		{
				$scl .= " and memberid!='0' ";
		}
		if ( $key != "" )
		{
				$scl .= " and (OrderNo='{$key}' or items regexp '{$key}' or name regexp '{$key}' or s_name regexp '{$key}') ";
		}
		if ( $showtui == "1" )
		{
				$dodis = " style='display:none' ";
		}
		else
		{
				$dodis = " ";
		}
		if ( $showsource != "all" )
		{
			if($showsource == "0"){
				$scl .= " and (source='0' or source='')";
			}else{
				$scl .= " and source='{$showsource}'";
			}
		}
?>
		<div class="listzone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
          <tr>
            <td width="32"  class="biaoti" style="padding-left:10px">序號</td>
            <td width="65" height="23"  class="biaoti" >訂單號</td>
            <td width="65" height="23"  class="biaoti" >訂購人</td>
            <td width="65" height="23"  class="biaoti" >銷售員</td>
            <td height="23"  class="biaoti" >訂購商品</td>
			<td width="70"  class="biaoti" >商品總價</td>
            <td width="50"  class="biaoti" >運費</td>
            <td width="50"  class="biaoti" >餘額付費</td>
    		<td width="50"  class="biaoti" >折價金額</td>
            <td width="65" height="23"  class="biaoti" >訂單總額</td>
            <td width="70" height="23"  class="biaoti" >下單時間</td>
		    <td width="33" height="23" align="center"  class="biaoti" <?php echo $dodis;?>>付款</td>
            <td width="33" height="23" align="center"  class="biaoti" <?php echo $dodis;?>>配送</td>
            <td width="33" height="23" align="center"  class="biaoti" <?php echo $dodis;?>>完成</td>
            <td width="33" height="23" align="center"  class="biaoti" >詳情</td>
	      </tr>
<?php
		$p = 1;
		$t_goodstotal = 0;
		$t_yunfei = 0;
		$t_baofei = 0;
		$t_paytotal = 0;
		$msql->query( "select * from {P}_shop_order where {$scl} order by uptime desc" );
		while ( $msql->next_record( ) )
		{
				$orderid = $msql->f( "orderid" );
				$OrderNo = $msql->f( "OrderNo" );
				$memberid = $msql->f( "memberid" );
				$user = $msql->f( "user" );
				$name = $msql->f( "name" );
				$goodstotal = $msql->f( "goodstotal" );
				$yunzoneid = $msql->f( "yunzoneid" );
				$yunid = $msql->f( "yunid" );
				$yuntype = $msql->f( "yuntype" );
				$yunfei = $msql->f( "yunfei" );
				$yunbaofei = $msql->f( "yunbaofei" );
				$paytotal = $msql->f( "paytotal" );
				$iflook = $msql->f( "iflook" );
				$payid = $msql->f( "payid" );
				$paytype = $msql->f( "paytype" );
				$ifpay = $msql->f( "ifpay" );
				$ifyun = $msql->f( "ifyun" );
				$ifok = $msql->f( "ifok" );
				$iftui = $msql->f( "iftui" );
				$dtime = $msql->f( "dtime" );
				$paytime = $msql->f( "paytime" );
				$yuntime = $msql->f( "yuntime" );
				$items = $msql->f( "items" );
				$disaccount = $msql->f( "disaccount" );
				$promoprice = $msql->f( "promoprice" );
				$uptime = $msql->f( "uptime" );
				
				$sales = $msql->f( "sales" );
				
				$countsales[$sales]["paytotal"] += (INT)$paytotal;
				$countsales[$sales]["goodstotal"] += (INT)$goodstotal;
				$countsales[$sales]["disaccount"] += (INT)$disaccount;
				$countsales[$sales]["promoprice"] += round($promoprice);
				
				//$dtime = date( "y-m-d", $dtime );
				$dtime = date( "y-m-d", $uptime );
				switch ( $ifok )
				{
				case "0" :
						$okimg = "toolbar_no.gif";
						break;
				case "1" :
						$okimg = "toolbar_ok.gif";
						break;
				}
				switch ( $ifpay )
				{
				case "0" :
						$payimg = "toolbar_no.gif";
						break;
				case "1" :
						$payimg = "toolbar_ok.gif";
						break;
				}
				switch ( $ifyun )
				{
				case "0" :
						$yunimg = "toolbar_no.gif";
						break;
				case "1" :
						$yunimg = "toolbar_ok.gif";
						break;
				}
				if ( $memberid == "0" )
				{
						$user = "非會員";
				}
				$t_goodstotal += (INT)$goodstotal;
				$t_yunfei += (INT)$yunfei;
				$t_baofei += (INT)$yunbaofei;
				$t_paytotal += (INT)$paytotal;
				$t_disaccount += (INT)$disaccount;
				$t_promoprice += round($promoprice);
				echo " 
          <tr class=\"list\" id=\"tr_".$orderid."\" >
            <td   width=\"32\" valign=\"top\"  style=\"padding-left:10px\">".$p."</td>
            <td   width=\"65\" valign=\"top\"  >".$OrderNo." </td>
			 <td width=\"65\" valign=\"top\">".$name."</td>
			 <td width=\"65\" valign=\"top\">".$sales."</td>
			 <td valign=\"top\">".$items." </td>
			 <td width=\"70\" valign=\"top\" >".(INT)$goodstotal."</td>
			 <td width=\"50\" valign=\"top\">".(INT)$yunfei."</td>
			<td width=\"70\" valign=\"top\" id=\"disaccount_".$orderid."\">".(INT)$disaccount."</td>
			<td width=\"70\" valign=\"top\" id=\"promoprice_".$orderid."\">".round($promoprice)."</td>
			 <td width=\"65\" valign=\"top\" id=\"paytotal_".$orderid."\">".(INT)$paytotal."</td>
            <td   width=\"70\" valign=\"top\">".$dtime." </td>           
            <td   width=\"33\" align=\"center\" valign=\"top\"  ".$dodis."><img id=\"orderpay_".$orderid."\" src=\"images/".$payimg."\"  border=\"0\" class=\"orderpay\" style=\"cursor:pointer\" /></td>
            <td   width=\"33\" align=\"center\" valign=\"top\"  ".$dodis."><img id=\"orderyun_".$orderid."\" src=\"images/".$yunimg."\"  border=\"0\" class=\"orderyun\"  style=\"cursor:pointer\" /></td>
            <td   width=\"33\" align=\"center\" valign=\"top\"  ".$dodis."><img id=\"orderok_".$orderid."\" src=\"images/".$okimg."\"  border=\"0\" class=\"orderok\"  style=\"cursor:pointer\" /></td>
            <td  width=\"33\" align=\"center\" valign=\"top\" ><a href=\"order_detail.php?orderid=".$orderid."\"><img src=\"images/look.png\" width=\"24\" height=\"24\"  border=\"0\" /></a> </td>
          </tr>";
				$p++;
		}
		$t_goodstotal = number_format( $t_goodstotal, 0, ".", "" );
		$t_yunfei = number_format( $t_yunfei, 0, ".", "" );
		$t_baofei = number_format( $t_baofei, 0, ".", "" );
		$t_paytotal = number_format( $t_paytotal, 0, ".", "" );
		$t_disaccount = number_format( $t_disaccount, 0, ".", "" );
		$t_promoprice = number_format( $t_promoprice, 0, ".", "" );
		echo " 
        <tr class=\"list\" >
            <td valign=\"top\"  class=\"biaoti1\" style=\"padding-left:10px\">合計</td>
            <td valign=\"top\" class=\"biaoti1\"  >-</td>
            <td valign=\"top\" class=\"biaoti1\" >-</td>
            <td valign=\"top\" class=\"biaoti1\">-</td>
            <td valign=\"top\" class=\"biaoti1\">-</td>
            <td valign=\"top\" class=\"biaoti1\" >商品總價<br>".$t_goodstotal."</td>
            <td valign=\"top\" class=\"biaoti1\">運費<br>+".$t_yunfei."</td>
            <td valign=\"top\"  class=\"biaoti1\">餘額付費<br>-".$t_disaccount."</td>
            <td valign=\"top\"  class=\"biaoti1\">折價金額<br>-".$t_promoprice."</td>
            <td valign=\"top\"  class=\"biaoti1\">訂單總額<br>=".$t_paytotal."</td>
            <td valign=\"top\"  class=\"biaoti1\">-</td>
            <td align=\"center\" valign=\"top\"  class=\"biaoti1\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\"  class=\"biaoti1\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\"  class=\"biaoti1\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\" class=\"biaoti1\" >-</td>
    </tr> 
        <tr class=\"list\" >
            <td valign=\"top\"  class=\"biaoti1\" style=\"padding-left:10px\">-</td>
            <td valign=\"top\" class=\"biaoti1\"  >-</td>
            <td valign=\"top\" class=\"biaoti1\" >-</td>
            <td valign=\"top\" class=\"biaoti1\">-</td>
            <td valign=\"top\" class=\"biaoti1\">-</td>
            <td valign=\"top\" class=\"biaoti1\" >".$t_goodstotal."</td>
            <td valign=\"top\" class=\"biaoti1\">+".$t_yunfei."</td>
            <td valign=\"top\"  class=\"biaoti1\">(不計算)</td>
            <td valign=\"top\"  class=\"biaoti1\">-".$t_promoprice."</td>
            <td valign=\"top\"  class=\"biaoti1\">=".($t_goodstotal+$t_yunfei-$t_promoprice)."</td>
            <td valign=\"top\"  class=\"biaoti1\">-</td>
            <td align=\"center\" valign=\"top\"  class=\"biaoti1\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\"  class=\"biaoti1\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\"  class=\"biaoti1\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\" class=\"biaoti1\" >-</td>
    </tr>";
foreach($countsales AS $ks=>$vs){
	
				if($ks!=""){
					$getname = $fsql->getone("SELECT name FROM {P}_base_admin WHERE user='$ks'");
					$salesname = $getname["name"];
				}elseif($ks == ""){
					$salesname = "未記錄";
				}
	
	
	echo "<tr class=\"list\" >
            <td valign=\"top\"  class=\"\" style=\"padding-left:10px\">-</td>
            <td valign=\"top\" class=\"\"  >-</td>
            <td valign=\"top\" class=\"\" >-</td>
            <td valign=\"top\" class=\"\">-</td>
            <td valign=\"top\" class=\"\" style=\"text-align:right\">".$salesname."</td>
            <td valign=\"top\" class=\"\" >".$vs['goodstotal']."</td>
            <td valign=\"top\" class=\"\">-</td>
            <td valign=\"top\"  class=\"\">-</td>
            <td valign=\"top\"  class=\"\">-".$vs['promoprice']."</td>
            <td valign=\"top\"  class=\"\">=".($vs['goodstotal']-$vs['promoprice'])."</td>
            <td valign=\"top\"  class=\"\">-</td>
            <td align=\"center\" valign=\"top\"  class=\"\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\"  class=\"\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\"  class=\"\" ".$dodis.">-</td>
            <td align=\"center\" valign=\"top\" class=\"\" >-</td>
    </tr>";
}

echo "
</table>
</div>";
}
else
{
		echo "<div style=\"margin:10px;font:12px/25px Verdana, Arial, Helvetica, sans-serif\">
請選擇查詢條件，或輸入商品名稱、訂購人姓名等關鍵詞，對指定範圍的訂單進行查詢和統計
</div>";
}
?>
</body>
	</html>