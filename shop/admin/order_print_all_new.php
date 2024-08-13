<?php

define( "ROOTPATH", "../../" );

include( ROOTPATH."includes/admin.inc.php" );

include( "language/".$sLan.".php" );

needauth( 321 );



$csvday = $_GET['csvday'];

$getdate = explode("-",$csvday);



$fromY = $getdate[0];

$fromM = $getdate[1];

$fromD = $getdate[2];

$starttime = mktime (0,0,0,$fromM,$fromD,$fromY);

$endtime = mktime (23,59,59,$fromM,$fromD,$fromY);

//$scl_output .= " yuntime>='{$starttime}' and yuntime<='{$endtime}' and iftui='0' and ifyun='1' AND (source='' || source='0')";



$scl_output .= " looktime>='{$starttime}' and looktime<='{$endtime}' and iftui='0' AND (source='' || source='0')";



?>

<html>

<head>

<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<script type="text/javascript" src="../../base/js/base.js"></script>

<script type="text/javascript" src="js/orderdetail.js"></script>

</head>

<body style="background:#fff;font-family:'微軟正黑體';font-size:12px;">



<?php

$msql->query( "select * from {P}_shop_order where $scl_output order by dtime desc" );

while ( $msql->next_record( ) )

{

		$OrderNo = $msql->f( "OrderNo" );

		$orderid = $msql->f( "orderid" );

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



		$disaccount = $msql->f( "disaccount" )>0? "/餘額".number_format($msql->f( "disaccount" ),0):"";

		$promoprice = $msql->f( "promoprice" );

		

		$invoicename = $msql->f( "invoicename" );

		$invoicenumber = $msql->f( "invoicenumber" );

		

		list($getsendtype,$getsendno) = explode("|",$msql->f( "sendtypeno" ));





$tsql->query( "select * from {P}_shop_yunzone where id='{$yunzoneid}'" );

if ( $tsql->next_record( ) )

{

		$zonepid = $tsql->f( "pid" );

		$zonestr = $tsql->f( "zone" );

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



	if($g>=1){

		echo '<div style="page-break-after: always;"></div>';

	}	

?>



<div id="shoporderdetail" align="center" >

	<table style="width:100%;">

		<tr>

			<td width="100%" style="border-right: 0px #000 solid;">

					<table style="width:100%;">

						<tr>

							<td colspan="4"><img src="images/p_logo.png" style="width:230px;" /></td>

						</tr>

						<tr>

							<td>&nbsp;</td>

							<td colspan="3">&nbsp;</td>

						</tr>

						<tr>

							<td width="5%" style="font-family:'微軟正黑體';font-size:12px;text-align:left;">Oerder：</td>

							<td width="58%" style="font-family:'微軟正黑體';font-size:12px;"><?php echo $OrderNo;?></td>

							<td width="5%" style="font-family:'微軟正黑體';font-size:12px;text-align:left;">Name：</td>

							<td width="32%" style="font-family:'微軟正黑體';font-size:12px;"><?php echo $name;?></td>

						</tr>

						<tr>

							<td style="font-family:'微軟正黑體';font-size:12px;text-align:left;">Tracking：</td>

							<td style="font-family:'微軟正黑體';font-size:12px;"><?php echo $getsendno;?></td>

							<td style="font-family:'微軟正黑體';font-size:12px;text-align:left;">Date：</td>

							<td style="font-family:'微軟正黑體';font-size:12px;"><?php echo date("Y-m-d",time());?></td>

						</tr>

						<tr>

							<td style="font-family:'微軟正黑體';font-size:12px;text-align:left;">Contact：</td>

							<td style="font-family:'微軟正黑體';font-size:12px;"><?php echo $s_mobi;?></td>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

						</tr>

						<tr>

							<td style="font-family:'微軟正黑體';font-size:12px;text-align:left;">Address：</td>

							<td colspan="3" style="font-family:'微軟正黑體';font-size:12px;"><?php echo $s_addr;?></td>

						</tr>

						<tr>

							<td colspan="4" style="border-bottom:1px #000 dotted;">&nbsp;</td>

						</tr>

					</table>

					<table style="width:100%;">

						<tr>

							<td width="12%" style="font-family:'微軟正黑體';font-size:12px;">Type</td>

							<td width="39%" style="font-family:'微軟正黑體';font-size:12px;">Product</td>

							<td width="12%" style="text-align:center;font-family:'微軟正黑體';font-size:12px;">Size</td>

							<td width="12%" style="text-align:center;font-family:'微軟正黑體';font-size:12px;">Color</td>

							<td width="12%" style="text-align:center;font-family:'微軟正黑體';font-size:12px;">QTY</td>

							<td width="12%" style="text-align:center;font-family:'微軟正黑體';font-size:12px;">Amount</td>

							<td width="11%" style="text-align:center;font-family:'微軟正黑體';font-size:12px;">Return</td>

						</tr>

<?php

$tsql->query( "select * from {P}_shop_orderitems where orderid='{$orderid}' and iftui='0'" );

$t=1;

$allnums = 0;

while ( $tsql->next_record( ) )

{

		$itemid = $tsql->f( "id" );

		$memberid = $tsql->f( "memberid" );

		$orderid = $tsql->f( "orderid" );

		$gid = $tsql->f( "gid" );

		$getLans["en"] = $fsql->getone( "select * from {P}_shop_con_translate where pid='{$gid}' and langcode='en'" );

		$getLans["zh_cn"] = $fsql->getone( "select * from {P}_shop_con_translate where pid='{$gid}' and langcode='zh_cn'" );

		$bn = $tsql->f( "bn" );

		$goods = $tsql->f( "goods" );

		$price = $tsql->f( "price" );

			$price = number_format($price,0);

		$weight = $tsql->f( "weight" );

		$nums = $tsql->f( "nums" );

		$danwei = $tsql->f( "danwei" );

		$jine = $tsql->f( "jine" );

			$jine = number_format($jine,0);

		$cent = $tsql->f( "cent" );

		$iftui = $tsql->f( "iftui" );

		$ifyun = $tsql->f( "ifyun" );

		$msg = $tsql->f( "msg" );

		$colorname = $tsql->f( "colorname" );

		$lantype = $tsql->f( "lantype" );

		

		if($lantype == "zh_cn"){

			$goods = $getLans["zh_cn"]["title"];

			$colorname = $getLans["zh_cn"]["colorname"];

		}elseif($lantype == "en"){

			$goods = $getLans["en"]["title"];

			$colorname = $getLans["en"]["colorname"];

		}

		

		list($specsize,$specprice,$specid) = explode("^",$tsql->f( "fz" ));

		$ccode = $wsql->getone("select colorcode from {P}_shop_conspec where id='{$specid}'");

		

		$fsql->query("select * from {P}_shop_conspec where gid='{$gid}' and colorcode='$ccode[colorcode]' order by id");

		while($fsql->next_record()){

			if($fsql->f("iconsrc")){

				$speccolor = "<img src='".ROOTPATH.$fsql->f(iconsrc)."' width='10' height='10' />";

				$specname = $fsql->f(colorname);

			}

		}

?>

						<tr>

							<td style="font-family:'微軟正黑體';font-size:12px;"><?php echo $bn;?></td>

							<td style="font-family:'微軟正黑體';font-size:12px;"><?php echo $goods;?></td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;"><?php echo $specsize;?></td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;"><?php echo $colorname;?></td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;"><?php echo $nums;?></td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;"><?php echo $jine;?></td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;"><?php echo $return;?></td>

						</tr>

<?php

	$allnums += $nums;

	$t++;

}

if($t<=10){

	for($k=0; $k<=(10-$t); $k++){

		echo '

						<tr>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

						</tr>

		';

	}

}

?>



						<tr>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

							<td>&nbsp;</td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;">Total</td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;"><?php echo $allnums;?></td>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;"><?php echo number_format($paytotal);?></td>

							<td>&nbsp;</td>

						</tr>

						<tr>

							<td colspan="7" style="font-family:'微軟正黑體';font-size:12px;border-top:1px #000 dotted;padding-top:5px;">

<b>台灣-退貨流程</b><br>
1. 會員操作：登入後進入會員中心，於訂單記錄中點選欲退貨之訂單右方的雙箭頭退貨按鈕。<br>
2. 退貨條件：商品必須保持全新狀態：未穿、未洗、吊牌完整、未修改、無損壞。<br>
3. 退貨準備：把商品和清單一起放回原包裝袋或紙箱。<br>
4. 退貨運送：確認退貨後，將安排快遞於2至4個工作日內上門取件，或您可自行寄回至：台北市松山區民生東路五段31號。<br>
5. 退款處理：確認退貨無誤後，若是信用卡支付，將進行退刷作業；若是貨到付款，請至會員中心申請退款。<br>
<br>
<b>海外-退貨流程</b><br>
1. 會員操作：同台灣退貨流程。<br>
2. 退貨運送：請將退貨商品通過順豐速運寄回至：台北市松山區民生東路五段31號<br>
3. 退款處理：收到退貨確認後，將在3個工作日內完成信用卡退款。<br>
<br>
<b>退款流程</b><br>
<b>若您的訂單刷卡已完成並取消訂單，或貨到付款退貨完成後，以下為您退款的步驟：</b><br>
1. 會員登入：請登入您的會員帳戶。<br>
2. 訪問會員中心：在會員中心選擇「會員帳戶」。<br>
3. 申請退款：點選帳戶結餘下的「申請退款」按鈕，填寫匯款資訊。<br>
4. 完成退款申請：提交退款申請後，我們將在7-10個工作天內處理並退款至您的銀行帳戶。<br>
<br>
<b>換貨方式</b><br>
如果您希望更換所購買的商品，請在購買後的10天內選擇以下兩種換貨方式之一：<br>
1. 親送換貨：將商品帶至我們的民生店直營門市，我們將即時為您處理換貨。<br>
2. 郵寄換貨：郵寄商品至我們的地址，需自付運費85元。請附上出貨單，並註明新的尺寸要求。您可將運費置於包裹內或同意到付。<br>
<br>
<b>注意事項</b><br>
*無法退換的商品：運動襪、內褲、頸圍等一經拆封，不接受退貨。食品類商品：咖啡豆、能量補給售出後，即不接受退回<br>
*瑕疵商品：若收到瑕疵商品，請聯繫客服，我們將提供退換服務。因使用不當或老化導致損壞不屬於瑕疵範疇。
							</td>

						</tr>

						<!--tr>

							<td colspan="6" style="text-align: center;font-family:'微軟正黑體';font-size:12px;border-top:1px #000 dotted;padding-top:5px;">rema-sports.com</td>

						</tr-->

					</table>

			</td>

			<!--td width="50%">

					<table style="width:100%;">

						<tr>

							<td style="text-align:center;font:bold 20px '微軟正黑體';">退貨申請</td>

						</tr>

						<tr>

							<td style="text-align:center;font-family:'微軟正黑體';font-size:12px;">&nbsp;</td>

						</tr>

						<tr>

							<td style="padding:5px 10px;font-family:'微軟正黑體';font-size:12px;">① 填寫左方 Return 數量或勾選</td>

						</tr>

						<tr>

							<td style="padding:5px 10px;font-family:'微軟正黑體';font-size:12px;">② 登入線上商店，點選會員中心或最下方"我的帳戶"</td>

						</tr>

						<tr>

							<td style="text-align:center;"><img src="images/p_1.png" style="width:485px;" /></td>

						</tr>

						<tr>

							<td style="padding:5px 10px;font-family:'微軟正黑體';font-size:12px;">③ 進入我的帳戶後點選"退貨申請"，點選欲退訂的商品送出即完成申請</td>

						</tr>

						<tr>

							<td style="text-align:center;"><img src="images/p_2.png" style="width:485px;" /></td>

						</tr>

						<tr>

							<td style="padding:5px 10px;font-family:'微軟正黑體';font-size:12px;">④ 將此收據放入原快遞袋或紙箱中，約1-3天會有快遞公司前往取件</td>

						</tr>

					</table>

			</td-->

		</tr>

	</table>

	

</div>

		

<?php

	$g++;

}

?>



</body>

</html>