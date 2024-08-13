<?php

define( "ROOTPATH", "../../" );

include( ROOTPATH."includes/admin.inc.php" );

include( "language/".$sLan.".php" );

needauth( 321 );



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



		$disaccount = $msql->f( "disaccount" )>0? "/餘額".number_format($msql->f( "disaccount" ),0):"";

		$promoprice = $msql->f( "promoprice" );

		

		$invoicename = $msql->f( "invoicename" );

		$invoicenumber = $msql->f( "invoicenumber" );

		

		list($getsendtype,$getsendno) = explode("|",$msql->f( "sendtypeno" ));

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

ob_start();

?>



<html>

<head>

<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<script type="text/javascript" src="../../base/js/base.js"></script>

<script type="text/javascript" src="js/orderdetail.js"></script>

</head>

<body style="background:#fff;font-family:'微軟正黑體';font-size:12px;">





<div id="shoporderdetail" align="center" >

	<table style="width:100%;">

		<tr>

			<td width="100%" style="border-right: 0px #000 solid;">

					<table style="width:100%;">

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

$msql->query( "select * from {P}_shop_orderitems where orderid='{$orderid}'" );

$t=1;

$allnums = 0;

while ( $msql->next_record( ) )

{

		$itemid = $msql->f( "id" );

		$memberid = $msql->f( "memberid" );

		$orderid = $msql->f( "orderid" );

		$gid = $msql->f( "gid" );

		$getLans["en"] = $fsql->getone( "select * from {P}_shop_con_translate where pid='{$gid}' and langcode='en'" );

		$getLans["zh_cn"] = $fsql->getone( "select * from {P}_shop_con_translate where pid='{$gid}' and langcode='zh_cn'" );

		$bn = $msql->f( "bn" );

		$goods = $msql->f( "goods" );

		$price = $msql->f( "price" );

			$price = number_format($price,0);

		$weight = $msql->f( "weight" );

		$nums = $msql->f( "nums" );

		$danwei = $msql->f( "danwei" );

		$jine = $msql->f( "jine" );

			$jine = number_format($jine,0);

		$cent = $msql->f( "cent" );

		$iftui = $msql->f( "iftui" );

		$ifyun = $msql->f( "ifyun" );

		$msg = $msql->f( "msg" );

		$colorname = $msql->f( "colorname" );

		$lantype = $msql->f( "lantype" );

		

		if($lantype == "zh_cn"){

			$goods = $getLans["zh_cn"]["title"];

			$colorname = $getLans["zh_cn"]["colorname"];

		}elseif($lantype == "en"){

			$goods = $getLans["en"]["title"];

			$colorname = $getLans["en"]["colorname"];

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

於登入會員後，至我的帳戶中選取「退貨申請」選項，並依照指定步驟操作。<br>

欲退貨的商品需維持未被穿過、清洗過、吊牌未摘除或剪掉、未經修改且完好無破損之全新、原始狀態，請將欲退貨商品及商品清單一併放入原包裝袋或原紙箱內。<br>

<br>

當客服中心確認您的退貨詳情後，將安排黑貓宅急便於二至四個工作日內上門取貨。請您於配送人員到達時，將上述物品一併交予配送人員帶回。 您也可自行將退貨商品寄回，寄送地址為：台北市松山區民生東路五段31號。<br>

<br>

當我們收到退貨商品並確認完成後，將即刻為您處理退款。如使用信用卡付款，退款將直接退回您當時使用的付款帳戶中 ; 若使用貨到付款，請發送欲退款的本人銀行帳號至客服信箱 service@rema-sports.com<br>

<br>

<b>海外-退貨流程</b><br>

於登入會員後，至我的帳戶中選取「退貨申請」選項，並依照指定步驟操作。<br>

欲退貨的商品需維持未被穿過、清洗過、吊牌未摘除或剪掉、未經修改且完好無破損之全新、原始狀態，請將欲退貨商品及商品清單一併放入原包裝袋或原紙箱內，如您未符合以上條件，或逾期寄回退貨商品，銳馬無法授理您的退貨，並將寄回您的退貨商品，寄回運費則需由客戶負擔。<br>

<br>

中國、港澳、馬來西亞、新加坡地區的退貨訂單，需請您將欲退貨商品及商品清單一併放入原包裝袋或原紙箱內並通知順豐速運寄至指定收貨地址: 台灣 台北市松山區民生東路五段31號。<br>

<br>

自收到退回訂單起算10個工作天內，將為您完成信用卡退刷，再請您留意銀行所提供相關資訊。<br>

<br>

<b>退換貨方式</b><br>

目前不提供換貨服務。<br>

若您不滿意所收到的商品或尺寸、顏色不符等原因而需辦理退貨，請您於我的帳戶中選取「退貨申請」後重新訂購其他商品。<br>

<br>

<b>瑕疵商品</b><br>

銳馬的每一項商品皆在高規格的品管把關後才進行出貨程序，若不幸讓您收到瑕疵商品，請與我們聯絡，我們將協助您評估該瑕疵是否為商品生產製程中所產生，並依照您的要求換貨或辦理退貨。特別提醒您，若商品因使用不當或使用過久而產生毀損狀況，並不視為瑕疵。<br>

<br>

<b>注意事項</b><br>

基於個人衛生問題，運動襪屬於貼身衣物產品，請勿試穿，如包裝拆封視同購買不得退貨。<br>

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

							<td style="text-align:center;"><img src="images/p_1.png" style="width:475px;" /></td>

						</tr>

						<tr>

							<td style="padding:5px 10px;font-family:'微軟正黑體';font-size:12px;">③ 進入我的帳戶後點選"退貨申請"，點選欲退訂的商品送出即完成申請</td>

						</tr>

						<tr>

							<td style="text-align:center;"><img src="images/p_2.png" style="width:475px;" /></td>

						</tr>

						<tr>

							<td style="padding:5px 10px;font-family:'微軟正黑體';font-size:12px;">④ 將此收據放入原快遞袋或紙箱中，約1-3天會有快遞公司前往取件</td>

						</tr-->

					</table>

			</td>

		</tr>

	</table>

	

</div>

<p style="page-break-after:always"></p>



<div id="printout" style="margin: 30px 0;text-align: center;">

	<div id="print_button" style="margin-left:10px;cursor: pointer;">[確定列印發貨單]</div>	<div class="goback" style="margin-top:20px;"><a href="javascript:history.go(-1);">[←返回上頁]</a>

</div>





</body>

</html>