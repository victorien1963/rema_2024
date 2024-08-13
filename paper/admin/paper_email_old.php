<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/ebmail.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
include( "func/paper.inc.php" );
include( ROOTPATH."api/xmlapi.php" );
needauth( 0 );

$paperid = $_REQUEST['paperid'];
$step = $_REQUEST['step'];
$sendtype = $_REQUEST['sendtype'];
$cronitems = $_REQUEST['cronitems'];
$sitename = $GLOBALS['GLOBALS']['CONF'][SiteName];

//CPANEL START
$getUser=$GLOBALS["PAPERCONF"]["CpanelUser"];
$ip = $_SERVER["SERVER_ADDR"];
$root_pass = $GLOBALS["PAPERCONF"]["CpanelPasswd"];
$root_port = $GLOBALS["PAPERCONF"]["CpanelPort"];
$xmlapi = new xmlapi($ip);
$xmlapi->password_auth($getUser,$root_pass);
$xmlapi->set_port($root_port);
$xmlapi->set_output('json');
$xmlapi->set_debug(0);
//執行程式寄信通知的信箱，留空則不通知
$args = array ( 'email' => '' ); 
$xmlapi->api2_query($getUser, 'Cron','set_email', $args);
//CPANEL END
//執行程式的路徑
//$command = 'php '.$_SERVER["DOCUMENT_ROOT"].'/cron-job.php'; 
/*$args = array ( 'command' => $command, 
                'day' => '*', 
                'hour' => '*', 
                'minute' => '*', 
                'month' => '*', 
                'weekday' => '*', 
                );*/
//print $xmlapi->api2_query($getUser, 'Cron','add_line', $args);

//列出CRON
//$value = $xmlapi->api2_query($getUser, 'Cron','listcron');

//刪除CRON
//$linekey = "1";
//$args = array ( 'line' => $linekey );
//print $xmlapi->api2_query($getUser, 'Cron','remove_line', $args);

/*$getSubValue=json_decode($value,TRUE);
var_dump($getSubValue["cpanelresult"]["data"]["0"]);*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
</head>
<body>
<?php
if ( $step == "send" && $sendtype == "all")
{
	$msql->query( "select body from {P}_paper_con where id='{$paperid}' " );
if ( $msql->next_record( ) ){
				$paperbody = $msql->f( "body" );			
				$paperbody = path2url( $paperbody );
				
}
$fromtitle = htmlspecialchars($_POST['fromtitle']);
	$fromemail = $_POST['fromemail'];
	/*$paperbody = mb_eregi_replace("\r\n","",$paperbody);
	$paperbody = mb_eregi_replace("\r","",$paperbody);
	$paperbody = mb_eregi_replace("\n","",$paperbody);*/
	
	$message = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Rema 線上商店</title>
    <!-- Web Font / @font-face : BEGIN -->
    <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->

    <!--[if !mso]><!-->
        <!-- insert web font reference, eg: <link href=\'https://fonts.googleapis.com/css?family=Roboto:400,700\' rel=\'stylesheet\' type=\'text/css\'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset -->
    <style>
		@font-face {
			font-family: \'華康儷黑-W3\';
			src: url(//rema-sports.com/images/DFLiHeiStd-W3.otf);
		}
		@font-face {
			font-family: \'華康儷黑-W5\';
			src: url(//rema-sports.com/images/DFLiHeiStd-W5.otf);
		}
		@font-face {
			font-family: \'華康儷黑-W7\';
			src: url(//rema-sports.com/images/DFLiHeiStd-W5.otf);
		}
		@font-face {
			font-family: \'pro_l\';
			src: url(//rema-sports.com/images/-pro-l.otf)
		}
		@font-face {
			font-family: \'pro_m\';
			src: url(//rema-sports.com/images/-pro-m.otf)
		}
				@font-face {
			font-family: \'pro_b\';
			src: url(//rema-sports.com/images/-pro-b.otf)
		}
		@font-face {
			font-family: \'pro_h\';
			src: url(//rema-sports.com/images/-pro-h.otf)
		}
		@font-face {
			font-family: \'英文用_B\';
			src: url(//rema-sports.com/images/tradegothicltstd-bd2.otf)
		}
		@font-face {
			font-family: \'英文用_M\';
			src: url(//rema-sports.com/images/tradegothicltstd.otf)
		}
		@font-face {
			font-family: \'英文用_L\';
			src: url(//rema-sports.com/images/tradegothicltstd-light.otf)
		}
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }
        img {
            -ms-interpolation-mode:bicubic;
            max-width: 100%;
        }
        *[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
        .x-gmail-data-detectors,
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
        }
        .a6S {
	        display: none !important;
	        opacity: 0.01 !important;
        }
        img.g-img + div {
	        display:none !important;
	   	}
        .button-link {
            text-decoration: none !important;
        }
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { /* iPhone 6 and 6+ */
            .email-container {
                min-width: 375px !important;
            }
        }

    </style>
	<!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->

    <!-- Progressive Enhancements -->
    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 480px) {
            .fluid {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .stack-column-center {
                text-align: center !important;
            }
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
        }

    </style>

</head>
<body width="100%" bgcolor="#ffffff" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background: #ffffff; text-align: left;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
            
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <div style="max-width: 800px; margin: auto;" class="email-container">
            <!--[if mso]>
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="800" align="center">
            <tr>
            <td>
            <![endif]-->

            <!-- Email Header : BEGIN -->
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:800px;background:#000000;" class="ke-zeroborder">
	<tbody>
		<tr>
			<td style="padding:0;text-align:left;">
				<a href="'.$SiteUrl.'" target="_blank"><img src="'.$SiteUrl.'images/epaperlogo.png" aria-hidden="true" width="232" height="99" alt="alt_text" border="0" style="height:auto;background:#dddddd;font-family:sans-serif;font-size:15px;line-height:20px;color:#555555;" /></a> 
			</td>
		</tr>
	</tbody>
</table>
<!-- Email Header : END -->
            <!-- Email Menu : BEGIN -->
<table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:800px;background:#000000;" class="ke-zeroborder">
	<tbody>
		<tr>
			<td style="padding:0px 0px;width:16%;color:#ffffff;">
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;border-right:1px #7e7e7e solid;">
				<a href="'.$SiteUrl.'shop/class/?1.html" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">男子</a> 
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;border-right:1px #7e7e7e solid;">
				<a href="'.$SiteUrl.'shop/class/?2.html" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">女子</a> 
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;border-right:1px #7e7e7e solid;">
				<a href="'.$SiteUrl.'newspost" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">技術</a> 
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;">
				<a href="'.$SiteUrl.'stores" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">商店</a> 
			</td>
			<td style="padding:0px 0px;width:16%;text-align:center;color:#ffffff;">
			</td>
		</tr>
		<tr>
			<td style="display:block;height:9px;">
			</td>
		</tr>
	</tbody>
</table>
            <!-- Email Menu : END -->';

	$message .= '<table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 800px;">

                <tr>
                    <td bgcolor="#ffffff" class="paperbody">'.$paperbody.'</td>
                </tr>
                </table>';

	$message .= '<!-- Email Footer : BEGIN -->
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:800px;border-bottom:1px #7e7e7e solid;background:#000000;" class="ke-zeroborder">
	<tbody>
		<tr>
			<td style="padding:15px 0px 0px 0px;width:100%;text-align:center;color:#ffffff;" class="x-gmail-data-detectors">
				<a href="https://www.facebook.com/rema.tw" target="_blank" style="display:inline-block;"><img src="'.$SiteUrl.'images/facebookicon1.png" aria-hidden="true" width="30px" height="30px" alt="alt_text" border="0" style="height:auto;font-family:sans-serif;font-size:15px;line-height:30px;color:#555555;" /></a>&nbsp; &nbsp;&nbsp; 
				<a href="https://www.instagram.com/rema_sports/" target="_blank" style="display:inline-block;"><img src="'.$SiteUrl.'images/instagramlogo1.png" aria-hidden="true" width="30px" height="30px" alt="alt_text" border="0" style="height:auto;font-family:sans-serif;font-size:15px;line-height:30px;color:#555555;" /></a> 
			</td>
		</tr>
		<tr>
			<td style="padding:10px 10px;width:100%;font-size:14px;font-family:\'微軟正黑體\',sans-serif;line-height:18px;text-align:center;color:#ffffff;" class="x-gmail-data-detectors">
				客服信箱 <a href="mailto:service@rema-sports.com" style="color:#ffffff;text-decoration:none;">service@rema-sports.com</a> / 客服電話 02-27943893<br />
服務時間 週一至週五 10：00-18：00，例假日休息<br />
(如遇例假日，請先以 E-mail方式聯絡，我們將會在上班日儘速處理您的來信) <br />
<br />
<span style="color:#ffffff;font-size:12px;">2017@ REMA INC. ALL RIGHTS RESERVED.</span> 
			</td>
		</tr>
	</tbody>
</table>
            <!-- Email Footer : END -->

            <!--[if mso]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </div>
    </center>
</body>
</html>';


	//處理寄發目標
	list($tomode,$toobj) = explode("_",$_POST['mambertypeid']);
	
	switch($tomode){
		case "all":
				if($toobj == "ok"){
					$scl = "and is_order='1'";
				}elseif($toobj == "no"){
					$scl = "and is_order='0'";
				}else{
					$scl = "";
				}
			break;
		case "ok":
				if($toobj == "mem"){
					$scl = "and is_member='1' and is_order='1'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='1'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='1' and member_type='{$memtype}' and is_order='1'";
				}
			break;
		case "no":
				if($toobj == "mem"){
					$scl = "and is_member='0' and is_order='0'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='0'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='0' and member_type='{$memtype}' and is_order='0'";
				}
			break;
		default:
					$scl = "";	
	}
	
$allmail = array();
$msql->query( "select order_cat,email from {P}_paper_order where email<>'' {$scl} " );
while( $msql->next_record( ) ){
	$email = $msql->f( "email" );
	$ordercat = $msql->f( "order_cat" );
	$cats = explode(",",$ordercat);
	if($ordercat=="all" || in_array($papercat,$cats)){
		if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		}else{
			$allmail[] = $email;
		}
		/*if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", $email)){
			$allmail[] = $email;
		}*/
	}
}


$msg = "無電子報信件發送！";
//剔除不願意接受電子報的信箱
//$allmail = array_diff($allmail,$nomail);

			$allmail = array_unique($allmail);
			$allmailcon = count($allmail);
			$nu = floor($allmailcon/99);
			$nu2 = $nu>0? (100*($nu-1))+($allmailcon%99)-($nu+1):($allmailcon%99)-($nu+1);
			//每100封(1主信箱+99密件副本)一次發送
			if($nu>0){
				for($t=0;$t<$nu;$t++){
					unset($bcc);
					$bcc = array();
					$ts = 100*$t;
					for($m=100*$t;$m<99+$ts;$m++){
						$bcc[] = $allmail[$m];
					}
					$toemail = array_shift($bcc);
					ebmails( $toemail, $fromemail, $fromtitle, $message, $bcc, 0);
					$msg = "共發送：".$allmailcon." 封電子報信件！";
				}
			}
			//剩餘未達99封之發送
			$us = $nu>0? 100*($nu-1):"0";
			if($nu2>=$us){
				unset($bccb);
				$bccb = array();
				for($u=100*$nu;$u<=$nu2;$u++){					
					$bccb[] = $allmail[$u];
				}
				$toemail = array_shift($bccb);
				ebmails( $toemail, $fromemail, $fromtitle, $message, $bccb, 0);
				$msg = "共發送：".$allmailcon." 封電子報信件！";
			}

				//echo "<script>parent.\$.unblockUI();parent.\$.blockUI({message:'".$msg."',css:{width:'320px',top:'100px'}});setTimeout(function(){parent.\$.unblockUI()},1500);parent.\$('.blockOverlay').click(parent.\$.unblockUI); </script>";
				exit( $msg );
				
				
}elseif($step == "send" && $sendtype == "cron"){
	#[分批次發送]＃＃＃＃＃＃
	$msql->query( "select body from {P}_paper_con where id='{$paperid}' " );
if ( $msql->next_record( ) ){
				$paperbody = $msql->f( "body" );			
				$paperbody = path2url( $paperbody );
}
	$fromtitle = htmlspecialchars($_POST['fromtitle']);
	$fromemail = $_POST['fromemail'];
	/*$paperbody = str_replace("\r\n","",$paperbody);
	$paperbody = str_replace("\r","",$paperbody);
	$paperbody = str_replace("\n","",$paperbody);*/
	//$message = $paperbody;
$message = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Rema 線上商店</title>
    <!-- Web Font / @font-face : BEGIN -->
    <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->

    <!--[if !mso]><!-->
        <!-- insert web font reference, eg: <link href=\'https://fonts.googleapis.com/css?family=Roboto:400,700\' rel=\'stylesheet\' type=\'text/css\'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset -->
    <style>
		@font-face {
			font-family: \'華康儷黑-W3\';
			src: url(//rema-sports.com/images/DFLiHeiStd-W3.otf);
		}
		@font-face {
			font-family: \'華康儷黑-W5\';
			src: url(//rema-sports.com/images/DFLiHeiStd-W5.otf);
		}
		@font-face {
			font-family: \'華康儷黑-W7\';
			src: url(//rema-sports.com/images/DFLiHeiStd-W5.otf);
		}
		@font-face {
			font-family: \'pro_l\';
			src: url(//rema-sports.com/images/-pro-l.otf)
		}
		@font-face {
			font-family: \'pro_m\';
			src: url(//rema-sports.com/images/-pro-m.otf)
		}
				@font-face {
			font-family: \'pro_b\';
			src: url(//rema-sports.com/images/-pro-b.otf)
		}
		@font-face {
			font-family: \'pro_h\';
			src: url(//rema-sports.com/images/-pro-h.otf)
		}
		@font-face {
			font-family: \'英文用_B\';
			src: url(//rema-sports.com/images/tradegothicltstd-bd2.otf)
		}
		@font-face {
			font-family: \'英文用_M\';
			src: url(//rema-sports.com/images/tradegothicltstd.otf)
		}
		@font-face {
			font-family: \'英文用_L\';
			src: url(//rema-sports.com/images/tradegothicltstd-light.otf)
		}
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }
        img {
            -ms-interpolation-mode:bicubic;
            max-width: 100%;
        }
        *[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
        .x-gmail-data-detectors,
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
        }
        .a6S {
	        display: none !important;
	        opacity: 0.01 !important;
        }
        img.g-img + div {
	        display:none !important;
	   	}
        .button-link {
            text-decoration: none !important;
        }
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { /* iPhone 6 and 6+ */
            .email-container {
                min-width: 375px !important;
            }
        }

    </style>
	<!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->

    <!-- Progressive Enhancements -->
    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 480px) {
            .fluid {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .stack-column-center {
                text-align: center !important;
            }
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
        }

    </style>

</head>
<body width="100%" bgcolor="#ffffff" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background: #ffffff; text-align: left;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
            
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <div style="max-width: 800px; margin: auto;" class="email-container">
            <!--[if mso]>
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="800" align="center">
            <tr>
            <td>
            <![endif]-->

            <!-- Email Header : BEGIN -->
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:800px;background:#000000;" class="ke-zeroborder">
	<tbody>
		<tr>
			<td style="padding:0;text-align:left;">
				<a href="'.$SiteUrl.'" target="_blank"><img src="'.$SiteUrl.'images/epaperlogo.png" aria-hidden="true" width="232" height="99" alt="alt_text" border="0" style="height:auto;background:#dddddd;font-family:sans-serif;font-size:15px;line-height:20px;color:#555555;" /></a> 
			</td>
		</tr>
	</tbody>
</table>
<!-- Email Header : END -->
            <!-- Email Menu : BEGIN -->
<table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:800px;background:#000000;" class="ke-zeroborder">
	<tbody>
		<tr>
			<td style="padding:0px 0px;width:16%;color:#ffffff;">
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;border-right:1px #7e7e7e solid;">
				<a href="'.$SiteUrl.'shop/class/?1.html" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">男子</a> 
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;border-right:1px #7e7e7e solid;">
				<a href="'.$SiteUrl.'shop/class/?2.html" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">女子</a> 
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;border-right:1px #7e7e7e solid;">
				<a href="'.$SiteUrl.'newspost" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">技術</a> 
			</td>
			<td style="padding:0px 0px;width:17%;font-size:17px;font-family:\'微軟正黑體\',sans-serif;line-height:19px;text-align:center;color:#ffffff;">
				<a href="'.$SiteUrl.'stores" target="_blank" style="color:#ffffff;text-decoration:none;width:100%;display:block;height:19px;">商店</a> 
			</td>
			<td style="padding:0px 0px;width:16%;text-align:center;color:#ffffff;">
			</td>
		</tr>
		<tr>
			<td style="display:block;height:9px;">
			</td>
		</tr>
	</tbody>
</table>
            <!-- Email Menu : END -->';

	$message .= '<table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 800px;">

                <tr>
                    <td bgcolor="#ffffff" class="paperbody">'.$paperbody.'</td>
                </tr>
                </table>';

	$message .= '<!-- Email Footer : BEGIN -->
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:800px;border-bottom:1px #7e7e7e solid;background:#000000;" class="ke-zeroborder">
	<tbody>
		<tr>
			<td style="padding:15px 0px 0px 0px;width:100%;text-align:center;color:#ffffff;" class="x-gmail-data-detectors">
				<a href="https://www.facebook.com/rema.tw" target="_blank" style="display:inline-block;"><img src="'.$SiteUrl.'images/facebookicon1.png" aria-hidden="true" width="30px" height="30px" alt="alt_text" border="0" style="height:auto;font-family:sans-serif;font-size:15px;line-height:30px;color:#555555;" /></a>&nbsp; &nbsp;&nbsp; 
				<a href="https://www.instagram.com/rema_sports/" target="_blank" style="display:inline-block;"><img src="'.$SiteUrl.'images/instagramlogo1.png" aria-hidden="true" width="30px" height="30px" alt="alt_text" border="0" style="height:auto;font-family:sans-serif;font-size:15px;line-height:30px;color:#555555;" /></a> 
			</td>
		</tr>
		<tr>
			<td style="padding:10px 10px;width:100%;font-size:14px;font-family:\'微軟正黑體\',sans-serif;line-height:18px;text-align:center;color:#ffffff;" class="x-gmail-data-detectors">
				客服信箱 <a href="mailto:service@rema-sports.com" style="color:#ffffff;text-decoration:none;">service@rema-sports.com</a> / 客服電話 02-27943893<br />
服務時間 週一至週五 10：00-18：00，例假日休息<br />
(如遇例假日，請先以 E-mail方式聯絡，我們將會在上班日儘速處理您的來信) <br />
<br />
<span style="color:#ffffff;font-size:12px;">2017@ REMA INC. ALL RIGHTS RESERVED.</span> 
			</td>
		</tr>
	</tbody>
</table>
            <!-- Email Footer : END -->

            <!--[if mso]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </div>
    </center>
</body>
</html>';

	//處理寄發目標
	list($tomode,$toobj) = explode("_",$_POST['mambertypeid']);
	
	switch($tomode){
		case "all":
				if($toobj == "ok"){
					$scl = "and is_order='1'";
				}elseif($toobj == "no"){
					$scl = "and is_order='0'";
				}else{
					$scl = "";
				}
			break;
		case "ok":
				if($toobj == "mem"){
					$scl = "and is_member='1' and is_order='1'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='1'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='1' and member_type='{$memtype}' and is_order='1'";
				}
			break;
		case "no":
				if($toobj == "mem"){
					$scl = "and is_member='0' and is_order='0'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='0'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='0' and member_type='{$memtype}' and is_order='0'";
				}
			break;
		default:
					$scl = "";	
	}
	
$allmail = array();
$msql->query( "select order_cat,email from {P}_paper_order where email<>'' {$scl} " );
while( $msql->next_record( ) ){
	$email = $msql->f( "email" );
	$ordercat = $msql->f( "order_cat" );
	$cats = explode(",",$ordercat);
	if($ordercat=="all" || in_array($papercat,$cats)){
		if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		}else{
			$allmail[] = $email;
		}
		/*if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", $email)){
			$allmail[] = $email;
		}*/
	}
}
			$msg = "無電子報信件發送！";

			$allmail = array_unique($allmail);
			$allmailcon = count($allmail);
			$nu = ceil($allmailcon/$cronitems);
			$dtime=time();
			$ifsend = "1";
			//array_slice 取出一段陣列
			//虛擬網站信箱
			//$fromemail = "".$sitename."<system@donot.replay>";
			$fromemail = $GLOBALS['CONF']['owner_m_mail'];
			//虛擬一個收件人
			$toemail = "".$sitename."會員<members@donot.replay>";
			//寫入批次記錄
			if($nu>0){
				$sendnums = $cronitems < $allmailcon? $cronitems:$allmailcon;
				$msql->query( "INSERT INTO {P}_paper_cron SET pid='{$paperid}',cat='{$fromtitle}',items='{$cronitems}',nums='{$allmailcon}',sendnums='{$sendnums}',dtime='{$dtime}'" );
				$getinto = $msql->instid();
				$np = 0;
				$t = 1;
				for($p=1; $p<=$nu; $p++){
						$bccs = "";
						if($p>1){
							$dtime = "0";
							$ifsend = "0";
							$sendnums = "0";
						}
						if($p==$nu){
							$cronitems = $allmailcon-$np;
						}
						$getbcc = array_slice($allmail,$np,$cronitems);
						//前 $cronitems封，第一次發送
						if($p==1){
							ebmails( $toemail, $fromemail, $fromtitle, $message, $getbcc, 0);
						}
						foreach($getbcc AS $mvs){
							$bccs .= $bccs? ",".$mvs:$mvs;
						}
						$msql->query( "INSERT INTO {P}_paper_cronjobs SET pid='{$getinto}',email='{$bccs}',alltimes='{$nu}',nowtimes='{$t}',ifsend='{$ifsend}',dtime='{$dtime}'" );
						$np = $np + $cronitems;
						$t++;
				}
				
				if($nu>1){
					//執行程式的路徑
					$thisminute = date("i")+1;
					//$thisminute = '*/1';
					$command = 'php '.$_SERVER["DOCUMENT_ROOT"].'/paper/cronjobs/cronjobs_'.$getinto.'.php'; 
					$args = array ( 'command' => $command, 
                		'day' => '*', 
                		'hour' => '*/1', 
                		'minute' => $thisminute, 
                		'month' => '*', 
                		'weekday' => '*', 
                	);
					$value = $xmlapi->api2_query($getUser, 'Cron','add_line', $args);
					$getSubValue=json_decode($value,TRUE);
					$linekey = $getSubValue["cpanelresult"]["data"]["0"]["linekey"];
					$msql->query( "UPDATE {P}_paper_cron SET linekey='{$linekey}' WHERE id='$getinto'" );
				
					@mkdir( "../cronjobs", 0755 );
					$fd = fopen( "../cronjobs/temp.php", "r" );
					$str = fread( $fd, "500000" );
					$str_html = str_replace( "DefaultPID", $getinto, $str );
					$str_html = str_replace( "DefaultSITENAME", $sitename, $str_html );
					fclose( $fd );
					$filename = '../cronjobs/cronjobs_'.$getinto.'.php';
					$fp = fopen( $filename, "w" );
					fwrite( $fp, $str_html );
					fclose( $fp );
					@chmod( $filename, 0664 );
				}else{
					$msql->query( "UPDATE {P}_paper_cron SET ifclose='2' WHERE id='$getinto'" );
				}
				$msg = "已經將 ".$allmailcon." 封電子報信件，分成 ".$nu." 批次，每小時發送！";
			}
			
	
	
	/*echo "<script>parent.\$.unblockUI();parent.\$.blockUI({message:'".$msg."',css:{width:'320px',top:'100px'}});setTimeout(function(){parent.\$.unblockUI()},1500);parent.\$('.blockOverlay').click(parent.\$.unblockUI); </script>";
				exit( );*/
				exit( $msg );

}

$msql->query( "select * from {P}_paper_con where id='{$paperid}' " );
if ( $msql->next_record( ) )
{
				$papertitle = $msql->f( "title" );
				$papercat= $msql->f( "catid" );
				$papermemo= $msql->f( "memo" );
				$papersrc = $msql->f( "src" );
				$paperauthor = $msql->f( "author" );
				$paperuptime = $msql->f( "uptime" );
}
?>
<div class="formzone">
<form method="post" action="paper_email.php">
<div class="namezone" >發送電子報</div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6">   
    <tr> 
      <td width="125"  align="right">電子報標題 : </td>
      <td  > 
        <input type="text" name="fromtitle" size="66"  class="input" value="<?php echo $papertitle;?>" />
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right">發送目標 : </td>
      <td  ><select name="mambertypeid" >
	<option value='all_ok'>全部訂閱名單(會員/非會員)</option>
	<option value='ok_mem'>---全部訂閱會員</option>	
	<option value='ok_notmem'>---全部訂閱非會員</option>
<?php
$fsql->query( "select * from {P}_member_type" );
while ( $fsql->next_record( ) )
{
				$membertypeid = $fsql->f( "membertypeid" );
				$membertype = $fsql->f( "membertype" );
				if($membertypeid == 2){
					echo "<option value='ok_".$membertypeid."' selected>---訂閱會員類型：".$membertype."</option>";
				}else{
					echo "<option value='ok_".$membertypeid."'>---訂閱會員類型：".$membertype."</option>";
				}
				$nonetype .= "<option value='no_".$membertypeid."]'>---未訂閱會員類型：".$membertype."</option>";
}
?>
	<option value='all_no'>全部未訂閱名單(會員/非會員)</option>
	<option value='no_mem'>---全部未訂閱會員</option>
	<option value='no_notmem'>---全部未訂閱非會員</option>
	<?php echo $nonetype;?>
		
	<option value='all_all'>全部名單(會員/非會員，不管有無訂閱)</option>
      	</select></td></tr>
<?php
$fsql->query( "select * from {P}_paper_cron where ifclose='0'" );
if ( $fsql->next_record( ) )
{
	echo '<tr> 
      <td width="125"  align="right">寄發方式 : </td>
      <td  ><label><input type="radio" name="sendtype" value="cron" disabled>排程批次寄發</label> <label><input type="radio" name="sendtype" value="all">一次全部寄發</label>  </td></tr>';
    echo '<tr> 
      <td width="125"  align="right">批次參數 : </td>
      <td  >目前仍有排程進行中，無法新增新的寄信排程！</td></tr>';
}else{
	echo '<tr> 
      <td width="125"  align="right">寄發方式 : </td>
      <td  ><label><input type="radio" name="sendtype" value="cron" checked>排程批次寄發</label> <label><input type="radio" name="sendtype" value="all">一次全部寄發</label> </td></tr>';
	echo '<tr> 
      <td width="125"  align="right">批次參數 : </td>
      <td  >系統每小時寄發 <input class="input" name="cronitems" value="200" /> 封信件</td></tr>';
}
?>

</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="發送電子報"  class="button" />
        <input type="hidden" name="paperid" value="<?php echo $paperid;?>" />
		<input type="hidden" name="papercat" value="<?php echo $papercat;?>" />
		<input type="hidden" name="fromemail" value="<?php echo $GLOBALS['CONF']['owner_m_mail'];?>" />
        <input type="hidden" name="step" value="send" />
</div>
</form>
</div>
</body>
</html>