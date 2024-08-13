<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/common.inc.php" );
include( ROOTPATH."includes/ebmail.inc.php" );
include( ROOTPATH."api/xmlapi.php" );

#[擷取參數]
$pid = "1462";
$sitename = "Rema 線上商店";
$filename = "cronjobs_1462.php";

//虛擬網站信箱
//$fromemail = "".$sitename."<system@donot.replay>";
$fromemail = $GLOBALS['CONF']['owner_m_mail'];

//php /home/bulanini//public_html/paper/cronjobs/cronjobs_'$pid'.php
		
	$msql->query( "SELECT b.*,b.id as bid,p.pid as ppid FROM {P}_paper_cronjobs b LEFT JOIN {P}_paper_cron p ON b.pid=p.id WHERE b.pid='$pid' and b.ifsend='0' LIMIT 0,1" );
	if ( $msql->next_record( ) ){
				$bid = $msql->f( "bid" );
				$ppid = $msql->f( "ppid" );
				$totalemail = $msql->f( "email" );
				//擷取信件內容
				$fsql->query( "SELECT title,body FROM {P}_paper_con WHERE id='{$ppid}'" );
				if ( $fsql->next_record( ) ){
					$papertitle = $fsql->f( "title" );
					$paperbody = $fsql->f( "body" );
					$paperbody = path2url( $paperbody );
				}
				
				$alltimes = $msql->f( "alltimes" );
				$nowtimes = $msql->f( "nowtimes" );
				
				$fromtitle = $papertitle;
				
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
<style type="text/css">
@media screen {
 @import url(//fonts.googleapis.com/earlyaccess/notosanstc.css);
}
body {
	margin: 0 !important;
	padding: 0;
	background-color: #FFFFFF;
}
table {
	border-spacing: 0;
	color: #333333;
}
td {
	padding: 0;
}
img {
	border: 0;
}
div[style*="margin: 0"] {
	margin: 0 !important;
}
.wrapper {
	width: 100%;
	table-layout: fixed;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
	background-color: #FFFFFF;
}
.webkit {
	max-width: 800px;
	margin: 0 auto;
}
.outer {
	Margin: 0 auto;
	width: 100%;
	max-width: 800px;
	padding-bottom: 0px;
}
.full-width-image img {
	width: 100% !important;
	max-width: 800px;
	height: auto !important;
	display: block;
}
.logo {
	Margin: 0 auto;
	width: 35px;
	text-align: center;
}
.inner {
	padding: 0px;
}
p {
	Margin: 0 auto;
	font-family: \'Noto Sans TC\', \'微軟正黑體\', sans-serif;
	-webkit-font-smoothing: antialiased;
}
a {
	color: #333333;
	text-decoration: none;
}
p.pro a {
	max-width: 100%;
	color: #333333;
	text-decoration: none;
}
p.buy a {
	font-family: \'Noto Sans TC\', \'微軟正黑體\', sans-serif;
	font-size: 14px;
	font-style: none;
	line-height: 20px;
	text-decoration: none;
}
.contents {
	width: 100%;
}
.one-column .contents {
	text-align: center;
	background-color: #FFFFFF;
}
.one-column-text {
	Margin: 0 auto;
}
.one-column p {
	font-size: 17px;
	line-height: 25px;
	padding-top: 0px;
	Margin-bottom: 30px;
}
.one-column p.h1 {
	font-family: \'Noto Sans TC\', \'微軟正黑體\', sans-serif;
!important;
	text-transform: uppercase;
	font-size: 30px !important;
	line-height: 32px;
	font-weight: normal;
	letter-spacing: .02em;
	Margin-bottom: 25px;
}
.browser .contents {
	background-color: #FFFFFF;
}
.browser .contents p {
	line-height: 14px;
	color: #666666;
}
.browser .contents p a {
	color: #666666;
}
.two-column {
	text-align: center;
	font-size: 0;
	background-color: #FFFFFF;
}
.two-column .column {
	width: 100%;
	max-width: 400px;
	display: inline-block;
	vertical-align: middle;
}
.two-column .contents {
	text-align: center;
}
.two-column img {
	width: 100%;
	max-width: 380px;
	height: auto;
}
.two-column .text {
	font-size: 12px;
	line-height: 22px;
	padding-top: 10px;
	padding-bottom: 10px;
}
.three-column {
	text-align: center;
	font-size: 0;
	padding-top: 10px;
	padding-bottom: 10px;
	background-color: #FFFFFF;
}
.three-column .column {
	width: 100%;
	max-width: 266px;
	display: inline-block;
	vertical-align: top;
}
.three-column .contents {
	text-align: center;
}
.three-column img {
	width: 100%;
	max-width: 246px;
	height: auto;
}
.three-column .text {
	font-size: 14px;
	line-height: 22px;
	padding-top: 10px;
}
.contents {
	width: 100%;
}
.innerlr {
	padding: 40px 10px 40px 10px;
}
.left-sidebar {
	text-align: center;
	font-size: 0;
}
.left-sidebar .text {
	font-size: 16px;
	line-height: 22px;
	padding-top: 10px;
	padding-bottom: 10px;
}
.left-sidebar .column {
	width: 100%;
	display: inline-block;
	vertical-align: middle;
}
.left-sidebar .left {
	max-width: 400px;
}
.left-sidebar .right {
	max-width: 400px;
}
.left-sidebar .img {
	width: 100%;
	max-width: 400px;
	height: auto;
}
.right-sidebar {
	text-align: center;
	font-size: 0;
}
.right-sidebar .text {
	font-size: 16px;
	line-height: 22px;
	padding-top: 10px;
	padding-bottom: 10px;
}
.right-sidebar .column {
	width: 100%;
	display: inline-block;
	vertical-align: middle;
}
.right-sidebar .left {
	max-width: 200px;
}
.right-sidebar .right {
	max-width: 600px;
}
.right-sidebar .img {
	width: 100%;
	max-width: 180px;
	height: auto;
}
.footer .contents {
	background-color: #FFFFFF;
}
.browser p, .footer p {
	width: 100% !important;
	Margin: 0 auto !important;
	font-family: \'Noto Sans TC\', \'微軟正黑體\', sans-serif;
!important;
	font-size: 10px !important;
}
.social {
	background-color: #FFFFFF;
	padding-top: 30px;
	padding-bottom: 20px;
}
.rema-nav {
	max-width: 780px !important;
	width: 95% !important;
}

@media screen {
.pro {
	font-family: \'Noto Sans TC\', \'微軟正黑體\', sans-serif;
!important;
	text-transform: uppercase !important;
}
.two-column .contents .pro, .three-column .contents .pro {
	font-size: 14px !important;
	letter-spacing: .05em !important;
	padding-top: 10px !important;
}
}

@media screen and (max-width: 500px) {
td.product {
	padding: 12px !important;
}
.column-first table {
	border-right: none !important;
	padding-bottom: 10px;
}
.column-first {
	border-bottom: 0px solid #DDDDDD;
	Margin-bottom: 10px;
}
.two-column .column {
	max-width: 49% !important;
}
.three-column .column {
	max-width: 49% !important;
}
.two-column img {
	max-width: 90% !important;
}
.three-column .column-first {
	max-width: 100% !important;
}
.three-column .column-first img {
	max-width: 80% !important;
}
.three-column img {
	max-width: 90% !important;
}
.left-sidebar .column, .right-sidebar .column {
	max-width: 100% !important
}
.left-sidebar img, .right-sidebar img {
	max-width: 100% !important
}
.left-sidebar .text {
	font-size: 16px !important;
}
.mbl_swap1{content:url(\'https://rema-sports.com/paper/pics/store.jpg?'.$storetime.'\') !important; max-width:500px !important;}

.logo	{ max-width:30px !important; max-height:30px !important;
	}
	
.hide {
	DISPLAY: none !important; MAX-HEIGHT: 0px !important; VISIBILITY: hidden !important
}
.mobil-he{
	height: 300px !important;
}
.nav-women{
	width: 92px !important;
}
.footer1,
.footer2,
.footer3,
.footer4 {
padding: 20px;
}
.footer1 {
border-right: 1px solid #e0e0e0;
padding-bottom: 20px;
}
.footer2 {
padding-bottom: 20px;
}
.footer3 {
border-right: 1px solid #e0e0e0;
}
.ql-mobile {
width: 100% !important;
}
.nav-header{
  font-size:11px !important;
}


.footer1,
.footer2,
.footer3,
.footer4 {
width: 25% !important;
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
<table align="center" class="w100 ke-zeroborder" style="width:100%;max-width:800px;" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td align="center" valign="top" style="text-align:center;padding-top:25px;padding-bottom:17px;font-size:0px;"><!--[if (gte mso 9)|(IE)]>
															<table style="width:800px;" align="center" cellpadding="0" cellspacing="0" border="0" class="ke-zeroborder">
																<tr>
																	<td valign="top" style="width:800px;">
																		<![endif]-->
        
        <div class="rema-nav" style="width:100%;vertical-align:top;display:inline-block;max-width:780px;"> 
          <!--[if (gte mso 9)|(IE)]>
																			<table border="0" cellspacing="0" cellpadding="0" style="width:780px;" align="center" class="ke-zeroborder">
																				<tr>
																					<td>
																						<![endif]-->
          <table class="ke-zeroborder" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td align="center" valign="top"><table width="100%" class="ke-zeroborder" border="0" cellspacing="0" cellpadding="5">
                    <tbody>
                      <tr>
                        <td align="left" valign="top"><a href="https://rema-sports.com/"><img width="35" height="35" class="logo" style="text-align:center;color:#333333;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:14px;text-decoration:none;" alt="rema-sports" src="https://rema-sports.com/paper/pics/e_logo.png" border="0" /> </a></td>
                        <td align="right" style="width:100px;text-align:right;padding-right:12px;"><a class="nav-header" style="color:#DFDFDF !important;letter-spacing:0.1em;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:13px;text-decoration:none;" href="https://rema-sports.com/shopclass1"><span style="color:#333333;">SHOP MEN</span></a></td>
                        <td align="center" class="nav-header" style="width:20px;text-align:center;color:#DFDFDF !important;letter-spacing:0.1em;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:13px;text-decoration:none;"><span style="color:#333333;">|</span></td>
                        <td align="right" class="nav-women" style="width:115px;text-align:right;"><a class="nav-header" style="color:#DFDFDF !important;letter-spacing:0.1em;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:13px;text-decoration:none;" href="https://rema-sports.com/shopclass2"><span style="color:#333333;">SHOP WOMEN</span></a></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table>
          <!--[if (gte mso 9)|(IE)]>
																					</td>
																				</tr>
																			</table>
<![endif]--> 
        </div>
        
        <!--[if (gte mso 9)|(IE)]>
																	</td>
																</tr>
															</table>
<![endif]--></td>
    </tr>
  </tbody>
</table>
<!-- Email Header : END -->';

	$message .= '<table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 800px;">

                <tr>
                    <td bgcolor="#ffffff" class="paperbody">'.$paperbody.'</td>
                </tr>
                </table>';
	$storetime = date('YmdH');
	$message .= '<!-- Email Footer : BEGIN -->
					<table width="width:100%;" align="center" class="ke-zeroborder" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td width="width:100%;" height="12" style="width:100%;max-width:800px;" bgcolor="#ffffff">
								</td>
							</tr>
							<tr>
								<td>
									<table width="width:100%;" align="center" class="ke-zeroborder" style="width:100%;max-width:800px;" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td align="center" class="full-width-image" style="padding:0px;display:inline-block;">
													<a style="text-decoration:none;" href="https://rema-sports.com/stores5"> <img width="780" class="mbl_swap1" style="border-width:0px;width:100%;height:auto;text-align:center;color:#333333 !important;line-height:40px;letter-spacing:1px;font-family:&quot;font-size:30px;font-weight:100;text-decoration:none !important;max-width:780px;" alt="remastore" src="https://rema-sports.com/paper/pics/store.jpg?'.$storetime.'" /> </a> 
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100%" height="1" bgcolor="#ffffff">
								</td>
							</tr>
						</tbody>
					</table>
					<table align="center" class="w100 ke-zeroborder" style="width:100%;max-width:800px;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td align="center" valign="top" style="font-size:0px;vertical-align:top;">
									<!--[if (gte mso 9)|(IE)]>
									<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:780px;" class="ke-zeroborder">
										<tr>
											<td align="center" valign="top" style="width:390px;">
												<![endif]-->
												<div class="w100 ql-mobile" style="width:50%;vertical-align:top;display:inline-block;max-width:390px;">
													<table class="ke-zeroborder" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td align="center" valign="top" style="padding-top:20px;">
																	<table class="ke-zeroborder" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td align="center" valign="top">
																					<!--content-->
																					<table class="columnOne ke-zeroborder" style="width:100%;max-width:390px;" border="0" cellspacing="0" cellpadding="0">
																						<tbody>
																							<tr>
																								<td width="195" align="center" class="footer1" valign="top" style="color:#333333;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;">
																									<a style="color:#333333;letter-spacing:0.1em;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;text-decoration:none;" href="https://rema-sports.com/stores5"><img width="65" title="" style="outline:0px;border:0px currentColor;border-image:none;width:65px;height:auto;color:#333333;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;display:block;min-width:65px;" src="https://rema-sports.com/paper/pics/e_store.png" border="0" /> 
																									<p style="text-align:center;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;">
																										尋找門市
																									</p>
</a>
																								</td>
																								<td width="195" align="center" class="footer2" valign="top" style="color:#333333;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;">
																									<a style="color:#333333;letter-spacing:0.1em;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;text-decoration:none;" href="mailto:service@rema-sports.com"><img width="65" title="" style="outline:0px;border:0px currentColor;border-image:none;width:65px;height:auto;color:#333333;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;display:block;min-width:65px;" src="https://rema-sports.com/paper/pics/e_contact.png" border="0" /> 
																									<p style="text-align:center;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;">
																										聯絡我們
																									</p>
</a>
																								</td>
																							</tr>
																						</tbody>
																					</table>
<!--content-->
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
<!--[if (gte mso 9)|(IE)]>
											</td>
											<td align="center" valign="top" style="width:400px;">
												<![endif]-->
												<div class="w100 ql-mobile" style="width:50%;vertical-align:top;display:inline-block;max-width:400px;">
													<table class="ke-zeroborder" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td align="center" valign="top" style="padding-top:20px;">
																	<table class="ke-zeroborder" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
																		<tbody>
																			<tr>
																				<td align="center" valign="top">
																					<!--content-->
																					<table class="columnOne ke-zeroborder" style="width:100%;max-width:390px;" border="0" cellspacing="0" cellpadding="0">
																						<tbody>
																							<tr>
																								<td width="195" height="60" align="center" class="footer3" valign="top" style="color:#AFA276;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;">
																									<a style="color:#333333;letter-spacing:0.1em;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;text-decoration:none;" href="https://rema-sports.com/page/faq/#FAQ-4"><img width="65" title="" style="outline:0px;border:0px currentColor;border-image:none;width:65px;height:auto;color:#333333;font-family:&quot;font-size:12px;display:block;min-width:65px;" src="https://rema-sports.com/paper/pics/e_ship.png" border="0" /> 
																									<p  style="text-align:center;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;">
																										快速到貨
																									</p>
</a>
																								</td>
																								<td width="195" align="center" class="footer4" valign="top">
																									<a style="color:#333333;letter-spacing:0.1em;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;text-decoration:none;" href="https://rema-sports.com/page/faq/#FAQ-4"><img width="65" title="" style="outline:0px;border:0px currentColor;border-image:none;width:65px;height:auto;color:#333333;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;display:block;min-width:65px;" src="https://rema-sports.com/paper/pics/e_service.png" border="0" /> 
																									<p  style="text-align:center;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;">
																										終身保修
																									</p>
</a>
																								</td>
																							</tr>
																						</tbody>
																					</table>
<!--content-->
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
<!--[if (gte mso 9)|(IE)]>
											</td>
										</tr>
									</table>
<![endif]-->
								</td>
							</tr>
						</tbody>
					</table>
					<table align="center" class="ke-zeroborder" style="width:100%;max-width:800px;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td width="100%" valign="top">
									<table width="100%" align="center" class="contentTable fixTable ke-zeroborder" style="border-collapse:collapse !important;background-color:#FFFFFF;" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr style="border-collapse:collapse !important;">
												<td class="articleTdTitleFooter colTd" valign="top" style="padding-top:10px;padding-bottom:10px;border-collapse:collapse !important;">
													<table width="100%" class="ke-zeroborder" style="border-collapse:collapse !important;" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td class="one-column" style="padding:15px 0px 25px;">
																	<table width="100%" style="color:#333333;border-spacing:0;">
																		<tbody>
																			<tr>
																				<td class="border" style="padding:0px;border-top-color:#333333;border-top-width:1px;border-top-style:solid;background-color:#FFFFFF;">
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr style="border-collapse:collapse !important;">
																<td class="articleTitleFooter" valign="top" style="text-align:center;color:#333333;text-transform:uppercase;line-height:18px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:11px;font-weight:normal;text-decoration:none;border-collapse:collapse !important;">
																	<a style="text-align:center;text-transform:uppercase;line-height:18px;letter-spacing:1px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:16px;font-weight:normal;text-decoration:none;" href="https://rema-sports.com" target="_blank"><b>REMA-SPORTS.COM</b></a>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table align="center" class="ke-zeroborder" style="width:100%;max-width:800px;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="contentTable" style="border-collapse:collapse !important;max-width:800px;background-color:#FFFFFF;" cellspacing="0" cellpadding="0">
										<tbody>
											<tr style="border-collapse:collapse !important;">
												<td class="colTd460" style="text-align:center;font-size:0px;vertical-align:top;border-collapse:collapse !important;">
													<table align="center" class="ke-zeroborder" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="160" valign="middle">
																	<div class="socialMobileBlock1" style="width:160px;vertical-align:middle;display:inline-block;">
																		<table width="100%" class="ke-zeroborder" style="border-collapse:collapse !important;" border="0" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr style="border-collapse:collapse !important;">
																					<td class="contentTd articleTd colTdLeft3" valign="middle" style="padding:12px 4px 15px;text-align:center;line-height:40px;font-family:&quot;font-size:14px;border-collapse:collapse !important;">
																						<table width="100%" align="center" class="articleTable ke-zeroborder" style="margin:0px auto;text-align:center;float:none;border-collapse:collapse !important;" border="0" cellspacing="0" cellpadding="0">
																							<tbody>
																								<tr style="border-collapse:collapse !important;">
																									<td class="articleFooterLeft" valign="middle" style="text-align:center;line-height:45px;padding-right:12px;padding-left:12px;font-family:&quot;font-size:14px;border-collapse:collapse !important;">
																										<a title="Instagram" style="font-family:&quot;font-size:13px;font-weight:normal;text-decoration:none;" href="https://www.facebook.com/rema.tw/" target="_blank"><img width="35" title="Instagram" style="border-width:0px;line-height:100%;text-decoration:none;max-width:35px;outline-style:none;" alt="Instagram" src="https://rema-sports.com/paper/pics/FB.png" border="0" /> </a>
																									</td>
																									<td class="articleFooterLeft" valign="middle" style="text-align:center;line-height:45px;padding-right:12px;padding-left:12px;font-family:&quot;font-size:14px;border-collapse:collapse !important;">
																										<a title="Facebook" style="font-family:&quot;font-size:13px;font-weight:normal;text-decoration:none;" href="https://www.instagram.com/rema_sports/" target="_blank"><img width="35" title="Facebook" style="border-width:0px;line-height:100%;text-decoration:none;max-width:35px;outline-style:none;" alt="Facebook" src="https://rema-sports.com/paper/pics/IG.png" border="0" /> </a>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table align="center" class="ke-zeroborder" style="width:100%;max-width:800px;" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="contentTable fixTable ke-zeroborder" style="border-collapse:collapse !important;background-color:#FFFFFF;" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr style="border-collapse:collapse !important;">
												<td class="articleTdTitleFooter colTd linkfooter" valign="top" style="padding:2px 20px 10px 30px;border-collapse:collapse !important;">
													<table width="100%" class="ke-zeroborder" style="border-collapse:collapse !important;" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr style="border-collapse:collapse !important;">
																<td class="articleFooter3" valign="top" style="padding:0px 20px 20px;width:100%;text-align:center;line-height:19px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:13px;font-weight:normal;text-decoration:none;border-collapse:collapse !important;max-width:800px;">
																	<p  style="text-align:center;line-height:19px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:13px;font-weight:normal;text-decoration:none;">客服信箱 service@rema-sports.com / 客服電話 02-26975722</p>
																	<p  style="text-align:center;line-height:19px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:13px;font-weight:normal;text-decoration:none;">服務時間 週一至週五 10：00-18：00，例假日休息</p>
																	<p  style="text-align:center;line-height:19px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:13px;font-weight:normal;text-decoration:none;">(如遇例假日，請先以 E-mail方式聯絡，我們將會在上班日儘速處理您的來信)</p>
																</td>
															</tr>
															<tr style="border-collapse:collapse !important;">
																<td class="articleFooter2" valign="top" style="text-align:center;line-height:20px;padding-top:3px;padding-bottom:0px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:9px;font-weight:bold;text-decoration:underline;border-collapse:collapse !important;">
																	<a title="Privacy policy" style="text-align:center;line-height:14px;padding-top:3px;padding-bottom:0px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:12px;font-weight:bold;text-decoration:underline;" href="https://rema-sports.com/page/html/" target="_blank"><p   style="font-size:12px;font-weight:bold;line-height:14px;text-align:center;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;"><b>隱私政策</b></p></a>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
									<table width="100%" class="contentTable fixTable ke-zeroborder" style="border-collapse:collapse !important;background-color:#FFFFFF;" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr style="border-collapse:collapse !important;">
												<td class="articleTdTitleFooter colTd" valign="top" style="padding:10px 70px;border-collapse:collapse !important;">
													<table width="100%" class="ke-zeroborder" style="border-collapse:collapse !important;" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr style="border-collapse:collapse !important;">
																<td class="articleFooter" valign="top" style="width:100%;text-align:center;line-height:12px;padding-top:10px;padding-bottom:10px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:10px;font-weight:normal;text-decoration:none;border-collapse:collapse !important;max-width:800px;">
																	<p style="text-align:center;line-height:16px;font-family:\'Noto Sans TC\', \'微軟正黑體\',sans-serif;font-size:10px;font-weight:normal;text-decoration:none;">'.date("Y").'&copy; REMA INC. ALL RIGHTS RESERVED.</p>
																	
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
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
				
				/*$paperbody = str_replace("\r\n","",$paperbody);
				$paperbody = str_replace("\r","",$paperbody);
				$paperbody = str_replace("\n","",$paperbody);
				$message = $paperbody;*/

		$allmail = array();
		$chkemail = explode(",",$totalemail);
		foreach( $chkemail AS $kk=>$email){
			if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			}else{
				$allmail[] = $email;
			}
			/*if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", $email)){
				$allmail[] = $email;
			}*/
		}
		
		$allmail = array_unique($allmail);
		$allmailcon = count($allmail);
		
		$dtime=time();
		//發送信件
		//把第一個當成總收件人
		//$toemail = array_shift($allmail);
		//虛擬一個收件人
		$toemail = "".$sitename."會員<members@donot.replay>";
		ebmails( $toemail, $fromemail, $fromtitle, $message, $allmail, 0);
		
		//更新 CRON資料
		$msql->query( "UPDATE {P}_paper_cron SET sendnums=sendnums+{$allmailcon},dtime='$dtime' WHERE id='$pid'" );		
		$msql->query( "UPDATE {P}_paper_cronjobs SET ifsend='1',dtime='$dtime' WHERE id='$bid'" );
		
		//最後一次寄發則刪除CRON JOB
		if($alltimes == $nowtimes){
			//CPANEL START
			$getUser=PaperConfig("CpanelUser");
			$ip = "127.0.0.1";
			$root_pass = PaperConfig("CpanelPasswd");
			$root_port = PaperConfig("CpanelPort");
			$xmlapi = new xmlapi($ip);
			$xmlapi->password_auth($getUser,$root_pass);
			$xmlapi->set_port($root_port);
			$xmlapi->set_output('json');
			$xmlapi->set_debug(0);
			//執行程式寄信通知的信箱，留空則不通知
			$args = array ( 'email' => '' ); 
			$xmlapi->api2_query($getUser, 'Cron','set_email', $args);
			//CPANEL END
			//列出排程表
			$value = $xmlapi->api2_query($getUser, 'Cron','listcron');
			$getSubValue=json_decode($value,TRUE);
			$takevalue = $getSubValue["cpanelresult"]["data"];
			//尋找排程命令中的檔案名稱與本排程相符，則刪除
			foreach($takevalue AS $key=>$cronvalue){
				if( strpos($cronvalue["command"],$filename) !== FALSE){
					//刪除排程
					$linekey = $cronvalue["count"];
					$args = array ( 'line' => $linekey );
					$xmlapi->api2_query($getUser, 'Cron','remove_line', $args);
					$msql->query( "UPDATE {P}_paper_cron SET ifclose='2' WHERE id='$pid'" );
		 			exit("Cron (ID:".$pid.") is SEND & CLOSE.");
				}
			}
		}
		
		exit("Cron Jobs (ID:".$bid.") is SEND.");
	}else{
			//CPANEL START
			$getUser=PaperConfig("CpanelUser");
			$ip = "127.0.0.1";
			$root_pass = PaperConfig("CpanelPasswd");
			$root_port = PaperConfig("CpanelPort");
			$xmlapi = new xmlapi($ip);
			$xmlapi->password_auth($getUser,$root_pass);
			$xmlapi->set_port($root_port);
			$xmlapi->set_output('json');
			$xmlapi->set_debug(0);
			//執行程式寄信通知的信箱，留空則不通知
			$args = array ( 'email' => '' ); 
			$xmlapi->api2_query($getUser, 'Cron','set_email', $args);
			//CPANEL END
			//列出排程表
			$value = $xmlapi->api2_query($getUser, 'Cron','listcron');
			$getSubValue=json_decode($value,TRUE);
			$takevalue = $getSubValue["cpanelresult"]["data"];
			//尋找排程命令中的檔案名稱與本排程相符，則刪除
			foreach($takevalue AS $key=>$cronvalue){
				if( strpos($cronvalue["command"],$filename) !== FALSE){
					//刪除排程
					$linekey = $cronvalue["count"];
					$args = array ( 'line' => $linekey );
					$xmlapi->api2_query($getUser, 'Cron','remove_line', $args);
					$msql->query( "UPDATE {P}_paper_cron SET ifclose='2' WHERE id='$pid'" );
		 			exit("Cron (ID:".$pid.") is SEND & CLOSE.");
				}
			}
	}

	
function PaperConfig($variable){
	global $fsql;
	$fsql->query("select * from {P}_paper_config where variable='$variable'");
	if($fsql->next_record()){
		$value=$fsql->f('value');
	}
	return $value;
}
	
?>