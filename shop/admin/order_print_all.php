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

$scl_output .= " yuntime>='{$starttime}' and yuntime<='{$endtime}'";

?>

<html xmlns:v="urn:schemas-microsoft-com:vml"

xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">



<head>

<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<meta name=ProgId content=Excel.Sheet>

<meta name=Generator content="Microsoft Excel 12">

</head>

<body>



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



<div id="shoporderdetail" align=center >

<style id="shoporderdetail_Styles">

<!--table

	{mso-displayed-decimal-separator:"\.";

	mso-displayed-thousand-separator:"\,";}

.font52371

	{color:windowtext;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:新細明體, serif;

	mso-font-charset:136;}

.font62371

	{color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:"Wingdings 2", serif;

	mso-font-charset:2;}

.font72371

	{color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;}

.font82371

	{color:black;

	font-size:8.0pt;

	font-weight:700;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;}

.xl152371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:12.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:新細明體, serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl632371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:15.0pt;

	font-weight:700;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl642371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl652371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl662371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:新細明體, serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl672371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:1px #000 solid;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl682371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:1px #000 solid;

	border-bottom:none;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl692371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:1px #000 solid;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl702371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:1px #000 solid;

	border-bottom:none;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl712371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:1px #000 solid;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl722371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:1px #000 solid;

	border-bottom:2px #000 double;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl732371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:1px #000 solid;

	border-bottom:2px #000 double;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl742371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:none;

	border-bottom:none;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl752371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:bottom;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:normal;}

.xl762371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:12.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:新細明體, serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:bottom;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl772371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:12.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:新細明體, serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:bottom;

	border-top:none;

	border-right:none;

	border-bottom:2px #000 double;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl782371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:top;

	border-top:none;

	border-right:none;

	border-bottom:2px #000 double;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:normal;

	mso-text-control:shrinktofit;}

.xl792371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:12.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:top;

	border-top:none;

	border-right:none;

	border-bottom:2px #000 double;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl802371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:none;

	border-bottom:2px #000 double;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl812371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:top;

	border-top:2px #000 double;

	border-right:none;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:normal;

	mso-text-control:shrinktofit;}

.xl822371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:top;

	border-top:2px #000 double;

	border-right:none;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl832371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:top;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl842371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl852371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	border-top:2px #000 double;

	border-right:none;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl862371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl872371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:top;

	border-top:none;

	border-right:none;

	border-bottom:2px #000 double;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl882371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:8.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:general;

	vertical-align:middle;

	border-top:none;

	border-right:none;

	border-bottom:2px #000 double;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl892371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:middle;

	border-top:2px #000 double;

	border-right:none;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl902371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;

	mso-text-control:shrinktofit;}

.xl912371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:none;

	border-bottom:2px #000 double;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl922371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:none;

	border-bottom:none;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl932371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:none;

	border-right:1px #000 solid;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl942371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl952371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl962371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:none;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl972371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl982371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:none;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl992371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:1px #000 solid;

	border-bottom:none;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1002371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:"\[ENG\]\[$-F800\]dddd\\\,\\ mmmm\\ dd\\\,\\ yyyy";

	text-align:left;

	vertical-align:middle;

	border-top:none;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1012371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1022371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:left;

	vertical-align:middle;

	border-top:none;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1032371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:"_-\0022$\0022* \#\,\#\#0\.00_-\;\\-\0022$\0022* \#\,\#\#0\.00_-\;_-\0022$\0022* \0022-\0022??_-\;_-\@_-";

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1042371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:"_-\0022$\0022* \#\,\#\#0\.00_-\;\\-\0022$\0022* \#\,\#\#0\.00_-\;_-\0022$\0022* \0022-\0022??_-\;_-\@_-";

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1052371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:"_-\0022$\0022* \#\,\#\#0\.00_-\;\\-\0022$\0022* \#\,\#\#0\.00_-\;_-\0022$\0022* \0022-\0022??_-\;_-\@_-";

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:1px #000 solid;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1062371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:"_-\0022$\0022* \#\,\#\#0\.00_-\;\\-\0022$\0022* \#\,\#\#0\.00_-\;_-\0022$\0022* \0022-\0022??_-\;_-\@_-";

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:1px #000 solid;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1072371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:"_-\0022$\0022* \#\,\#\#0\.00_-\;\\-\0022$\0022* \#\,\#\#0\.00_-\;_-\0022$\0022* \0022-\0022??_-\;_-\@_-";

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:1px #000 solid;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

.xl1082371

	{padding:0px;

	mso-ignore:padding;

	color:black;

	font-size:11.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:微軟正黑體, sans-serif;

	mso-font-charset:136;

	mso-number-format:General;

	text-align:center;

	vertical-align:middle;

	border-top:1px #000 solid;

	border-right:none;

	border-bottom:1px #000 solid;

	border-left:none;

	mso-background-source:auto;

	mso-pattern:auto;

	white-space:nowrap;}

ruby

	{ruby-align:left;}

rt

	{color:windowtext;

	font-size:9.0pt;

	font-weight:400;

	font-style:normal;

	text-decoration:none;

	font-family:新細明體, serif;

	mso-font-charset:136;

	mso-char-type:none;}

-->

</style>

<table border=0 cellpadding=0 cellspacing=0 width=1008 style='border-collapse:

 collapse;table-layout:fixed;width:756pt'>

 <col width=72 span=14 style='width:54pt'>

 <tr height=22 style='height:16.5pt'>

  <td height=22 width=72 style='height:16.5pt;width:54pt' align=left

  valign=top><span style='mso-ignore:vglayout;

  position:absolute;z-index:1;margin-left:4px;margin-top:0px;width:190px;

  height:77px'><img width=190 height=77  src="images/yun_logo.png" ></span><span

  style='mso-ignore:vglayout2'>

  <table cellpadding=0 cellspacing=0>

   <tr>

    <td height=22 class=xl152371 width=72 style='height:16.5pt;width:54pt'><a

    name="RANGE!A1:N30"></a></td>

   </tr>

  </table>

  </span></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt' align=left valign=top><span style='mso-ignore:vglayout;

  position:absolute;z-index:2;margin-left:20px;margin-top:13px;width:101px;

  height:64px'><img width=101 height=64 src="images/yun_code.png" ></span><span

  style='mso-ignore:vglayout2'>

  <table cellpadding=0 cellspacing=0>

   <tr>

    <td height=22 class=xl152371 width=72 style='height:16.5pt;width:54pt'></td>

   </tr>

  </table>

  </span></td>

  <td class=xl152371 width=72 style='width:54pt'></td>

 </tr>

 <tr height=26 style='height:19.5pt'>

  <td height=26 class=xl152371 style='height:19.5pt'></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl632371 colspan=4>發貨通知單 DELIVERY NOTE</td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl152371 style='height:16.5pt'></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl152371 style='height:16.5pt'></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl642371 style='height:16.5pt'>訂單編號:</td>

  <td colspan=4 class=xl1022371><?php echo $OrderNo;?></td>

  <td class=xl642371 colspan=2>宅配單編號:</td>

  <td colspan=3 class=xl1022371><?php echo $getsendno;?></td>

  <td class=xl642371>發貨日期:</td>

  <td colspan=3 class=xl1002371><?php echo $csvday?></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl642371 style='height:16.5pt'>會員名:</td>

  <td colspan=4 class=xl1012371><?php echo $user;?></td>

  <td class=xl642371>收件人:</td>

  <td class=xl642371></td>

  <td colspan=3 class=xl1012371><?php echo $name;?></td>

  <td class=xl642371>宅配公司:</td>

  <td colspan=3 class=xl1012371><?php echo $strSend[$getsendtype]?></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl642371 style='height:16.5pt'>配送地址:</td>

  <td colspan=13 class=xl1022371><?php echo $s_addr;?></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl642371 style='height:16.5pt'>電話號碼:</td>

  <td colspan=4 class=xl1012371><?php echo $s_mobi;?></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

  <td class=xl642371></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl152371 style='height:16.5pt'></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

  <td class=xl152371></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td colspan=2 height=22 class=xl952371 style='border-right:1px #000 solid;

  height:16.5pt'>商品金額小計</td>

  <td colspan=2 class=xl1062371 style='border-right:1px #000 solid;

  border-left:none'><span style='mso-spacerun:yes'>&nbsp;</span>$<span

  style='mso-spacerun:yes'><?php echo number_format($goodstotal,0);?>

  </span>-<span style='mso-spacerun:yes'>&nbsp;&nbsp; </span></td>

  <td class=xl652371 style='border-left:none'>運費</td>

  <td colspan=2 class=xl952371 style='border-right:1px #000 solid;border-left:

  none'><?php echo number_format($yunfei,0);?></td>

  <td class=xl652371 style='border-left:none'>折價&#21173;</td>

  <td colspan=2 class=xl952371 style='border-right:1px #000 solid;border-left:

  none'><?php echo number_format($promoprice,0).$disaccount;?></td>

  <td class=xl652371 style='border-left:none'>總計金額</td>

  <td colspan=3 class=xl1032371 style='border-right:1px #000 solid;

  border-left:none'><span style='mso-spacerun:yes'>&nbsp;</span>$<span

  style='mso-spacerun:yes'><?php echo number_format($paytotal,0);?>

  </span>-<span style='mso-spacerun:yes'>&nbsp;&nbsp; </span></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl662371 style='height:16.5pt'></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

  <td class=xl662371></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td height=22 class=xl652371 style='height:16.5pt'>NO.</td>

  <td colspan=2 class=xl952371 style='border-right:1px #000 solid;border-left:

  none'>商品編號</td>

  <td colspan=5 class=xl952371 style='border-right:1px #000 solid;border-left:

  none'>商品名稱，顏色，尺寸</td>

  <td class=xl652371 style='border-left:none'>商品單價</td>

  <td class=xl652371 style='border-left:none'>數量</td>

  <td class=xl652371 style='border-left:none'>總計</td>

  <td colspan=2 class=xl952371 style='border-right:1px #000 solid;border-left:

  none'>退貨原因</td>

  <td class=xl672371>退貨數量</td>

 </tr>

 

 <?php

$fsql->query( "select * from {P}_shop_orderitems where orderid='{$orderid}'" );

 $t=1;

while ( $fsql->next_record( ) )

{

		$itemid = $fsql->f( "id" );

		$memberid = $fsql->f( "memberid" );

		$orderid = $fsql->f( "orderid" );

		$gid = $fsql->f( "gid" );

		$bn = $fsql->f( "bn" );

		$goods = $fsql->f( "goods" );

		$price = $fsql->f( "price" );

			$price = number_format($price,0);

		$weight = $fsql->f( "weight" );

		$nums = $fsql->f( "nums" );

		$danwei = $fsql->f( "danwei" );

		$jine = $fsql->f( "jine" );

			$jine = number_format($jine,0);

		$cent = $fsql->f( "cent" );

		$iftui = $fsql->f( "iftui" );

		$ifyun = $fsql->f( "ifyun" );

		$msg = $fsql->f( "msg" );

		$colorname = $fsql->f( "colorname" );

		

		list($specsize,$specprice,$specid) = explode("^",$fsql->f( "fz" ));

		$ccode = $tsql->getone("select colorcode from {P}_shop_conspec where id='{$specid}'");

		

	$tsql->query("select * from {P}_shop_conspec where gid='{$gid}' and colorcode='$ccode[colorcode]' order by id");

	while($tsql->next_record()){

		if($tsql->f("iconsrc")){

			$speccolor = "<img src='".ROOTPATH.$tsql->f(iconsrc)."' width='10' height='10' />";

			$specname = $tsql->f(colorname);

		}

	}

		echo "<tr height=22 style='height:16.5pt'>

  <td height=22 class=xl682371 style='height:16.5pt;border-top:none'>".$t."</td>

  <td colspan=2 class=xl962371 style='border-right:1px #000 solid;border-left:

  none'>".$bn."</td>

  <td colspan=5 class=xl962371 style='border-right:1px #000 solid;border-left:

  none'>".$goods."，".$colorname." ".$specname."，".$specsize."</td>

  <td class=xl682371 style='border-top:none;border-left:none'>".$price."</td>

  <td class=xl682371 style='border-top:none;border-left:none'>".$nums."</td>

  <td class=xl682371 style='border-top:none;border-left:none'>".$jine."</td>

  <td colspan=2 class=xl982371 style='border-right:1px #000 solid;border-left:

  none'>A/B/C/D/E/F/G_________</td>

  <td class=xl692371 style='border-top:none'>　</td>

 </tr>";

 		$t++;

}

if($t<7){

	for(;$t<=7;$t++){

		echo "<tr height=22 style='height:16.5pt'>

  <td height=22 class=xl682371 style='height:16.5pt;border-top:none'>&nbsp;</td>

  <td colspan=2 class=xl962371 style='border-right:1px #000 solid;border-left:

  none'>&nbsp;</td>

  <td colspan=5 class=xl962371 style='border-right:1px #000 solid;border-left:

  none'>&nbsp;</td>

  <td class=xl682371 style='border-top:none;border-left:none'>&nbsp;</td>

  <td class=xl682371 style='border-top:none;border-left:none'>&nbsp;</td>

  <td class=xl682371 style='border-top:none;border-left:none'>&nbsp;</td>

  <td colspan=2 class=xl982371 style='border-right:1px #000 solid;border-left:

  none'>&nbsp;</td>

  <td class=xl692371 style='border-top:none'>&nbsp;</td>

 </tr>";

	}

}

?>

 

 <tr height=22 style='mso-height-source:userset;height:16.5pt'>

  <td colspan=5 rowspan=5 height=110 class=xl812371 width=360 style='height:

  82.5pt;width:270pt'><font class="font62371">&auml;</font><font class="font82371">注意事項:</font><font

  class="font72371"><br>

   

  1.在Rema網路商店所購買的商品，無法在實體經銷店鋪進行退換貨，另外在實體經銷店鋪所購買的商品也無法在網路商店進行退換貨，如有造成不便之處，敬請見諒。<br>

    2.除了有和商品清單上所記載的商品不同，數量不一，或是商品品質及配送延遲的問題外，運費概不退還，敬請見諒。<br>

    </font></td>

  <td colspan=6 rowspan=6 class=xl812371 width=432 style='border-bottom:2.0pt double black;

  width:324pt'><font class="font62371">&auml;</font><font class="font82371">退貨須知:</font><font

  class="font72371"><br>

    欲退貨的商品請在商品送達後7天內辦理退貨手續，並請在發貨通知單上<br>

    填寫退貨數量，送達後超過7天才辦理退貨的商品，將無法進行退貨。<br>

    <br>

    ○甚麼情況下可申請退貨?<br>

    1.未被穿過、清洗過或被弄髒的商品。<br>

    2.未被修改過的商品。<br>

    3.吊牌未被摘除或剪掉的商品。<br>

    4.包裝完整無毀損的商品。<br>

    5.有購買證明的商品、非大量的惡意退貨。<br>

    </font></td>

  <td colspan=3 rowspan=3 class=xl812371 width=216 style='width:162pt'><font

  class="font82371">辦理退貨聯絡地址: <br>

    </font><font class="font72371"><br>

    台北市松山區民生東路五段31號<br>

    銳鎷國際有限公司<span style='mso-spacerun:yes'>&nbsp; </span>退貨組收<br>

    </font></td>

 </tr>

 <tr height=22 style='height:16.5pt'>

 </tr>

 <tr height=22 style='height:16.5pt'>

 </tr>

 <tr height=22 style='height:16.5pt'>

  <td colspan=3 rowspan=3 height=99 class=xl752371 width=216 style='border-bottom:

  2.0pt double black;height:74.25pt;width:162pt'>如有其他任何問題，請聯絡客服中心。<br>

    <span style='mso-spacerun:yes'></span>02-26975722<br>

    周一~五10:30~18:30<br>

    service@rema-sports.com</td>

 </tr>

 <tr height=22 style='height:16.5pt'>

 </tr>

 <tr height=55 style='mso-height-source:userset;height:41.25pt'>

  <td colspan=5 height=55 class=xl782371 width=360 style='height:41.25pt;

  width:270pt'><font class="font62371">&auml;</font><font class="font82371">退貨原因:</font><font

  class="font72371"><br>

    </font><font class="font82371">A</font><font class="font72371">.尺寸不合 </font><font

  class="font82371">B</font><font class="font72371">.商品不如預期</font><font

  class="font82371"> C</font><font class="font72371">.訂購錯誤 </font><font

  class="font82371">D</font><font class="font72371">.收到錯誤的商品 </font><font

  class="font82371">E</font><font class="font72371">.商品的數量寄送錯誤 </font><font

  class="font82371">F</font><font class="font72371">.商品有瑕疵</font><font

  class="font82371"> G</font><font class="font72371">.其他(請自行填寫)</font></td>

 </tr>

 <![if supportMisalignedColumns]>

 <tr height=0 style='display:none'>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

  <td width=72 style='width:54pt'></td>

 </tr>

 <![endif]>

</table>



</div>

		

	

		

<?php

	$g++;

}

?>



</body>



</html>