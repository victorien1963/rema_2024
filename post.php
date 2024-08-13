<?php
define( "ROOTPATH", "" );
include( ROOTPATH."includes/common.inc.php" );
include( ROOTPATH."member/language/".$sLan.".php" );
include (ROOTPATH."member/includes/member.inc.php" );
$act = $_POST['act'];

switch ( $act )
{
case "adminlogin" :
				$user = htmlspecialchars(strtolower($_POST['user']));
				$password = htmlspecialchars($_POST['password']);
				$ImgCode = $_POST['ImgCode'];
				if ( $user == "" || $password == "" )
				{
								echo $strAdminLoginErr1;
								exit( );
				}
				
				$frm = $_POST['frm'];
				if ( $frm != "MC" )
				{
								$ImgCode = $_POST['ImgCode'];
								$Ic = $_COOKIE['CODEIMG'];
								$Ic = strrev( $Ic ) + 5 * 2 - 9;
								$Ic = substr( $Ic, 0, 4 );
								if ( $ImgCode == "" || $Ic != $ImgCode )
								{
												echo $strAdminLoginErr3;
												exit( );
								}
				}
				
				
				$md5pass = md5( $password );
				$msql->query( "select * from {P}_base_admin where user='{$user}' and password='{$md5pass}'" );
				if ( $msql->next_record( ) )
				{
								$sysuserid = $msql->f( "id" );
								$psd = $msql->f( "password" );
								$name = $msql->f( "name" );
								$tm = time( );
								$md5 = md5( $user."l0aZXUYJ876Mn5rQoL55B".$psd.$tm );
								$src = $msql->f( "src" );
								setcookie( "SYSZC", $md5 );
								setcookie( "SYSUSER", $user );
								setcookie( "SYSNAME", $name );
								setcookie( "SYSUSERID", $sysuserid );
								setcookie( "SYSTM", $tm );
								setcookie( "SYSPIC", $src );
								echo "OK";
								exit( );
				}
				else
				{
								echo $strAdminLoginErr2;
								exit( );
				}
				break;
case "adminlogout" :
				setcookie( "SYSUSER" );
				setcookie( "SYSZC" );
				setcookie( "SYSTM" );
				setcookie( "SYSNAME" );
				setcookie( "PLUSADMIN", "" );
				echo "OK";
				exit( );
				break;
case "memberlogin" :
				$muser = htmlspecialchars(strtolower($_POST['muser']));
				$mpass = htmlspecialchars($_POST['mpass']);
				$from = $_POST['from']? $_POST['from']:$_SERVER['HTTP_REFERER'];
				
				
				//$ImgCode = $_POST['ImgCode'];
				if ( $muser == "" || $mpass == "" )
				{
								echo $strLoginNotice1;
								exit( );
				}
				else
				{
								/*$Ic = $_COOKIE['CODEIMG'];
								$Ic = strrev( $Ic ) + 5 * 2 - 9;
								$Ic = substr( $Ic, 0, 4 );
								if ( $ImgCode == "" || $Ic != $ImgCode )
								{
												echo $strIcErr;
												exit( );
								}*/
								if ( $GLOBALS['MEMBERCONF']['UC_OPEN'] == "1" )
								{
												if ( file_exists( ROOTPATH."api/uc_api/uc_client/client.php" ) && file_exists( ROOTPATH."api/uc_api/api.inc.php" ) )
												{
																include( ROOTPATH."api/uc_api/api.inc.php" );
																include( ROOTPATH."api/uc_api/uc_client/client.php" );
																list( $uid, $username, $password, $email ) = uc_get_user( $muser );
																if ( 0 < $uid )
																{
																				$msql->query( "select * from {P}_member where user='{$muser}'" );
																				if ( $msql->next_record( ) )
																				{
																				}
																				else
																				{
																								$membertypeid = $GLOBALS['MEMBERCONF']['UC_MEMBERTYPEID'];
																								$fsql->query( "select * from {P}_member_type where membertypeid='{$membertypeid}'" );
																								if ( $fsql->next_record( ) )
																								{
																												$membergroupid = $fsql->f( "membergroupid" );
																												$membertype = $fsql->f( "membertype" );
																												$ifchecked = $fsql->f( "ifchecked" );
																												$expday = $fsql->f( "expday" );
																												$regmail = $fsql->f( "regmail" );
																								}
																								$regtime = time( );
																								if ( $expday != 0 )
																								{
																												$tm = $expday * 24 * 60 * 60;
																												$exptime = $regtime + $tm;
																								}
																								else
																								{
																												$exptime = 0;
																								}
																								$ip = $_SERVER['REMOTE_ADDR'];
																								$passwd = md5( $mpass );
																								$fsql->query( "insert into {P}_member set

									   membertypeid='{$membertypeid}',
									   membergroupid='{$membergroupid}',
									   user='{$muser}',
									   password='{$passwd}',
									   email='{$email}',
									   pname='{$muser}',
									   signature='',
									   nowface='1',
									   checked='{$ifchecked}',
									   regtime='{$regtime}',
									   exptime='{$exptime}',
									   ip='{$ip}'
									" );
																								$memberid = $fsql->instid( );
																								$fsql->query( "delete from {P}_member_rights where memberid='{$memberid}'" );
																								$fsql->query( "select * from {P}_member_defaultrights where membertypeid='{$membertypeid}'" );
																								while ( $fsql->next_record( ) )
																								{
																												$secureid = $fsql->f( "secureid" );
																												$securetype = $fsql->f( "securetype" );
																												$secureset = $fsql->f( "secureset" );
																												$tsql->query( "insert into {P}_member_rights values(
										0,
									   '{$memberid}',
									   '{$secureid}',
									   '{$securetype}',
									   '{$secureset}'
										)" );
																								}
																								$regmail = str_replace( "{#user#}", $muser, $regmail );
																								$regmail = str_replace( "{#password#}", $mpass, $regmail );
																								$fsql->query( "insert into {P}_member_msn set
										`body`='{$regmail}',
										`tomemberid`='{$memberid}',
										`frommemberid`='0',
										`dtime`='{$regtime}',
										`iflook`='0'
									" );
																				}
																}
																else if ( $uid == 0 - 1 )
																{
																				$uc_addmember = "YES";
																}
																else
																{
																				$uc_addmember = "";
																}
												}
												else
												{
																echo $strUCNTC1;
																exit( );
												}
								}
								$mdpass = md5( $mpass );
								// $msql->query( "select * from {P}_member where user='{$muser}' and password='{$mdpass}'" );
								$msql->query( 
									"SELECT *
									FROM (
										SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
										UNION ALL 
										SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
									) AS U
									where user='{$muser}' and password='{$mdpass}'" );
								if ( $msql->next_record( ) )
								{
									if( $msql->f( "rz" ) == "0" )
									{
										echo $strLoginNotice5;
										exit( );
									}
												$checked = $msql->f( "checked" );
												$exptime = $msql->f( "exptime" );
												$memberid = $msql->f( "memberid" );
												$membertypeid = $msql->f( "membertypeid" );
												$pname = $msql->f( "pname" );
												$name = $msql->f( "name" );
												$email = $msql->f( "email" );
												$nowtime = time( );
												/*黑名單*/
												if($memberid != "" && $memberid !="0"){
													$fsql->query( "SELECT * FROM {P}_member_black where memberid='{$memberid}' and memberid!='0'" );
													if($fsql->next_record()){
														echo "OK_".$from;
														exit();
													}
												}
												/**/
												if ( $exptime != 0 && $exptime < $nowtime )
												{
																echo $strLoginNotice3;
																exit( );
												}
												$ip = $_SERVER['REMOTE_ADDR'];
												$fsql->query( "update {P}_member set logincount=logincount+1,logintime='{$nowtime}',loginip='{$ip}' where memberid='{$memberid}'" );
												$fsql->query( "select membertype from {P}_member_type where membertypeid='{$membertypeid}'" );
												if ( $fsql->next_record( ) )
												{
																$membertype = $fsql->f( "membertype" );
												}
												$fsql->query( "select * from {P}_member_rights where memberid='{$memberid}' and securetype='con'" );
												if ( $fsql->next_record( ) )
												{
																$consecure = $fsql->f( "secureset" );
												}
												$md5 = md5( $muser."76|01|14".$memberid.$membertype.$consecure );
												setcookie( "MUSER", $muser );
												setcookie( "MEMBERPNAME", $name );
												setcookie( "MEMBERID", $memberid );
												setcookie( "MEMBERTYPE", $membertype );
												setcookie( "MEMBERTYPEID", $membertypeid );
												setcookie( "ZC", $md5 );
												setcookie( "SE", $consecure );
												membercentupdate( $memberid, "114" );
												
												if( strpos($from,"logout") ){$from="";}
												
												if(!$from){
													echo "OK";
												}else{
													echo "OK_".$from;
												}
												
												if ( $GLOBALS['MEMBERCONF']['UC_OPEN'] == "1" )
												{
																if ( $uc_addmember == "YES" )
																{
																				uc_user_register( $muser, $mpass, $email );
																}
																if ( 0 < $uid )
																{
																				echo uc_user_synlogin( $uid );
																}
												}
												exit( );
								}
								else
								{
												echo $strLoginNotice4;
												exit( );
								}
				}
				exit( );
				break;
	
	//會員退出
	case "memberlogout":
		setCookie("MUSER");
		setCookie("MEMBERID");
		setCookie("MEMBERPNAME");
		setCookie("MEMBERTYPE");
		setCookie("MEMBERTYPEID");
		setCookie("SE");
		setCookie("ZC");

		echo "OK";
		exit;
	break;

case "memberreg" :
				//$membertypeid = $_REQUEST['membertypeid'];
				$membertypeid = 1;

				//$user = htmlspecialchars( $_POST['user'] );
				$user = htmlspecialchars( strtolower( trim($_POST['email'])) );
				$password = htmlspecialchars( $_POST['password'] );
				$repass = htmlspecialchars( $_POST['repass'] );
				$email = htmlspecialchars( strtolower($_POST['email']) );
				$reqcode = htmlspecialchars( $_POST['reqcode'] );
				$ImgCode = $_POST['ImgCode'];
				/**/
				$LastName = $_POST['LastName'];
				$FirstN = $_POST['FirstN'];
				$name = $_POST['name']? $_POST['name']:$_POST['LastName'].$_POST['FirstN'];
				$postcode = $_POST['postcode'];
				$sex = $_POST['sex'];
				$Year_ID = $_POST['Year_ID'];
				$Month_ID = $_POST['Month_ID'];
				$Day_ID = $_POST['Day_ID'];
				$birthday = $_POST['birthday']? $_POST['birthday']:$Year_ID.$Month_ID.$Day_ID;
				$addr = htmlspecialchars( $_POST['addr'] ).htmlspecialchars( $_POST['addr2'] );
				
				$mov = htmlspecialchars( $_POST['mov'] );
				$tel = htmlspecialchars( $_POST['tel'] );
				$orderpaper = $_POST['orderpaper'];
				
				$passcode = htmlspecialchars( $_POST['passcode'] );
				$company = htmlspecialchars( $_POST['company'] );
				$zoneid = htmlspecialchars( $_POST['zoneid'] );
				$country = htmlspecialchars( $_POST['country'] );
				//$countryid = htmlspecialchars( $_POST['countryid'] );
				//2020-10-23 解析國家
				list($country, $countryid) = explode("_",$country);
				
				
				/*2016-04-06*/
				/*if(!checkaddr($addr)){
					echo "請填寫包含縣市區域的詳細地址";
					exit();
				}*/
				
				if($name == ""){
					echo $strRegNotice12;
					exit();
				}
				if(mb_strlen($addr,'utf-8')<=6){
					echo $strRegNotice23;
					exit();
				}
				
				//if($mov == ""){
				if ( !preg_match( "/^([\d+-]+)$/", $mov ) ){
					echo $strRegNotice24;
					exit();
				}
				/**/
				$fsql->query( "select * from {P}_member_type where membertypeid='{$membertypeid}'" );
				if ( $fsql->next_record( ) )
				{
								$membergroupid = $fsql->f( "membergroupid" );
								$membertype = $fsql->f( "membertype" );
								$ifcanreg = $fsql->f( "ifcanreg" );
								$ifchecked = $fsql->f( "ifchecked" );
								$regmail = $fsql->f( "regmail" );
								$expday = $fsql->f( "expday" );
				}
				
				/*if ( $ifcanreg != "1" )
				{
								echo $strRegNotice10;
								exit( );
				}*/
				/*if ( strlen( $user ) < 5 || 20 < strlen( $user ) )
				{
								echo $strRegNotice4;
								exit( );
				}*/
				//if ( !preg_match( "/^[0-9a-z]{1,20}\$/i", $user ) )
				if(!empty($user) && !filter_var($user, FILTER_VALIDATE_EMAIL)) {
								echo $strRegNotice5;
								exit( );
				}
				/*if ( !eregi( "^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}\$", $user ) )
				{
								echo $strRegNotice5;
								exit( );
				}*/
				if ( !preg_match( "/^[0-9a-z]{1,20}\$/i", $password ) )
				{
								echo $strRegNotice6;
								exit( );
				}
				if ( strlen( $password ) < 5 || 20 < strlen( $password ) )
				{
								echo $strRegNotice7;
								exit( );
				}
				if ( $password != $repass )
				{
								echo $strRegNotice8;
								exit( );
				}
				//if ( !preg_match( "/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}\$/i", $email ) )
				//if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				if($email == "")
				{
								echo $strRegNotice9;
								exit( );
				}
				$fsql->query( "select memberid from {P}_member where user='{$user}'" );
				if ( $fsql->next_record( ) )
				{
								echo $strRegNotice2;
								exit( );
				}
				$fsql->query( "select memberid from {P}_member where email='{$email}'" );
				if ( $fsql->next_record( ) )
				{
								echo $strRegNotice16;
								exit( );
				}
				$fsql->query("select value from {P}_member_config where variable='MustRequestCode'");
				if ( $fsql->next_record( ) )
				{
					if($fsql->f("value") == '1'){
						$fsql->query("select value from {P}_member_config where variable='RequestCode'");
						$fsql->next_record();
						$codes = explode(",",$fsql->f("value"));
						if(!in_array($reqcode,$codes)){
								echo $strRegNotice17;
								exit( );
						}
					}
				}
				$fsql->query("select value from {P}_member_config where variable='MustCheckEmail'");
				if ( $fsql->next_record( ) )
				{
					if($fsql->f("value") == '1'){
							$mustmail = TRUE;
					}
				}
				if ( $GLOBALS['MEMBERCONF']['UC_OPEN'] == "1" )
				{
								if ( file_exists( ROOTPATH."api/uc_api/uc_client/client.php" ) && file_exists( ROOTPATH."api/uc_api/api.inc.php" ) )
								{
												include( ROOTPATH."api/uc_api/api.inc.php" );
												include( ROOTPATH."api/uc_api/uc_client/client.php" );
												if ( uc_get_user( $user ) )
												{
																echo $strUCNTC2;
																exit( );
												}
								}
								else
								{
												echo $strUCNTC1;
												exit( );
								}
				}
				/*$Ic = $_COOKIE['CODEIMG'];
				$Ic = strrev( $Ic ) + 5 * 2 - 9;
				$Ic = substr( $Ic, 0, 4 );
				if ( $ImgCode == "" || $Ic != $ImgCode )
				{
								echo $strIcErr;
								exit( );
				}*/
				$regtime = time( );
				if ( $expday != 0 )
				{
								$tm = $expday * 24 * 60 * 60;
								$exptime = $regtime + $tm;
				}
				else
				{
								$exptime = 0;
				}
				/*增加郵件驗證碼*/
				if($mustmail){
					$chkcode = md5($_SERVER['HTTP_USER_AGENT'].time()."qYW%e^88W5");
					$rz = "0";
				}else{
					$chkcode = "";
					$rz = "1";
				}
				
				$ip = $_SERVER['REMOTE_ADDR'];
				$passwd = md5( $password );
				$msql->query( "insert into {P}_member set

		   membertypeid='{$membertypeid}',
		   membergroupid='{$membergroupid}',
		   user='{$user}',
		   password='{$passwd}',
		   email='{$email}',
		   pname='{$user}',
		   signature='{$signature}',
		   nowface='1',
		   checked='{$ifchecked}',
		   regtime='{$regtime}',
		   exptime='{$exptime}',
		   ip='{$ip}',
		   logincount='1',
		   logintime='{$regtime}',
		   loginip='{$ip}',
		   rz='{$rz}',
		   chkcode='{$chkcode}',
		   name='{$name}',
		   postcode='{$postcode}',
		   sex='{$sex}',
		   birthday='{$birthday}',
		   addr='{$addr}',
		   mov='{$mov}',
		   tel='{$tel}',
		   order_epaper = '{$orderpaper}',
		   passcode = '{$passcode}',
		   company = '{$company}',
		   zoneid = '{$zoneid}',
		   country = '{$country}' ,
		   countryid = '{$countryid}'
		" );
		
				$memberid = $msql->instid( );
				include( ROOTPATH."costomer.php");
																
				cre_member(http_build_query($_POST));
				
		//寫入電子報信箱
		$msql->query("insert into {P}_paper_order set is_member='1',member_id='{$memberid}',member_type='{$membertypeid}',is_order='{$orderpaper}',email='{$email}',dtime='{$regtime}'");
		
				$msql->query( "delete from {P}_member_rights where memberid='{$memberid}'" );
				$msql->query( "select * from {P}_member_defaultrights where membertypeid='{$membertypeid}'" );
				while ( $msql->next_record( ) )
				{
								$secureid = $msql->f( "secureid" );
								$securetype = $msql->f( "securetype" );
								$secureset = $msql->f( "secureset" );
								$fsql->query( "insert into {P}_member_rights values(
			0,
		   '{$memberid}',
		   '{$secureid}',
		   '{$securetype}',
		   '{$secureset}'
			)" );
				}
				membercentupdate( $memberid, "111" );
				
				$passworden = substr($password,0,2)."****".substr($password,-2);
				
				$regmail = str_replace( "{#user#}", $name, $regmail );
				$regmail = str_replace( "{#email#}", $user, $regmail );
				$regmail = str_replace( "{#password#}", $passworden, $regmail );
				$msql->query( "insert into {P}_member_msn set
					`body`='{$regmail}',
					`tomemberid`='{$memberid}',
					`frommemberid`='0',
					`dtime`='{$regtime}',
					`iflook`='0'
				" );
				
				//寄發歡迎信件
				if(!$mustmail){
				include( ROOTPATH."includes/ebmail.inc.php" );
				
				$message = $regmail;
				
				//$mailbody = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>';
				//$mailbody .='<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff">';
				$mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="100%">';
				$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reg.png" width="800" height="208" alt=""></td></tr>';
				$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';
				$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';
				$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;word-break: break-all;">'.$message.'</td><td width="80">&nbsp;</td>';
				$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png"></td></tr></table>';
				$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';
				$mailbody .='</body></html>';
				
				/*$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reg.png" style="width: 800px; max-width: 100%;"></div>';
				$mailbody .= '<div><div style="width: 560px; max-width: 70%; min-height:303px; float:left;">'.$message.'</div><div style="width: 240px; max-width: 30%; float:left;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png" style="width: 240px; max-width: 100%; float:left;"></div></div>';
				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" style="width: 800px; max-width: 100%;"></div>';*/
				
				ebmail( $email, $GLOBALS['CONF']['SiteEmail'], $membertype.$strRegNotice11, $mailbody );
				/*寄發電子優惠券*/
				$msql->query( "select code,mail_temp,starttime,endtime from {P}_shop_promocode where memberreg='1'" );
				if ( $msql->next_record( ) ){
					$code = $msql->f( "code" );
					$mail_temp = $msql->f("mail_temp");
					$starttime = $msql->f( "starttime" );
					$endtime = $msql->f( "endtime" );

				/*$mail_temp = str_replace("\r\n","",$mail_temp);
				$mail_temp = str_replace("\r","",$mail_temp);
				$mail_temp = str_replace("\n","",$mail_temp);*/
				/*$chktemp = $mail_temp;
				if($mail_temp != strip_tags($chktemp)){
					//$mail_temp = str_replace(array("\r", "\n", "\r\n", "\n\r"), '', $mail_temp);
					//$mail_temp = preg_replace('/\s+/', '', $mail_temp);
				}*/
				$message = $mail_temp;
	
				/*$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_discount.png" style="width: 800px; max-width: 100%;"></div>';
				$mailbody .= '<div><div style="width: 560px; max-width: 70%; min-height:303px; float:left;">'.$message.'</div><div style="width: 240px; max-width: 30%; float:left;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_order.png" style="width: 240px; max-width: 100%; float:left;"></div></div>';
				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" style="width: 800px; max-width: 100%;"></div>';*/
				
				//$mailbody = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>';
				//$mailbody .='<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff">';
				$mailbody ='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="100%">';
				$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_discount.png" width="800" height="208" alt=""></td></tr>';
				$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';
				$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';
				$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;word-break: break-all;">'.$message.'</td><td width="80">&nbsp;</td>';
				$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_order.png"></td></tr></table>';
				$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';
				//$mailbody .='</body></html>';
	
	
					if($endtime=="0" || ($starttime < time() && $endtime > time()) ){
						ebmail( $email, $GLOBALS['CONF']['SiteEmail'], $GLOBALS['CONF'][SiteName]."-電子折價券", $mailbody );
					}
				}
				/**/
				}
				$fsql->query( "select * from {P}_member_rights where memberid='{$memberid}' and securetype='con'" );
				if ( $fsql->next_record( ) )
				{
								$consecure = $fsql->f( "secureset" );
				}
				$md5 = md5( $user."76|01|14".$memberid.$membertype.$consecure );
				setcookie( "MUSER", $user );
				setcookie( "MEMBERPNAME", $name );
				setcookie( "MEMBERID", $memberid );
				setcookie( "MEMBERTYPE", $membertype );
				setcookie( "MEMBERTYPEID", $membertypeid );
				setcookie( "ZC", $md5 );
				setcookie( "SE", $consecure );
				/*寄發郵件驗證碼*/
				include_once( ROOTPATH."includes/ebmail.inc.php" );
				if($mustmail){
				$link = $SiteUrl."member/lostpass.php?step=chkcode&username=".$user."&codestr=".$chkcode;
				$message = $user.$strLostpassNtc2."\r\n \r\n".$strMailChk3."\r\n \r\n<a href=\"".$link."\" target=\"_blank\">".$link."</a>\r\n \r\n".$GLOBALS['CONF']['SiteName']."\r\n".$GLOBALS['CONF']['SiteHttp'];
				
				/*$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reg.png" style="width: 800px; max-width: 100%;"></div>';
				$mailbody .= '<div style="width: 800px; max-width: 100%;"><div style="width: 56%; max-width: 56%; min-height:303px; float:left;font-family:微軟正黑體; font-size:1.3em; padding-left:10%">'.$message.'</div><div style="width: 240px; max-width: 30%; float:left;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png" style="width: 240px; max-width: 100%; float:left;"></div></div>';
				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" style="width: 800px; max-width: 100%;"></div>';*/

				//$mailbody = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>';
				//$mailbody .='<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff">';
				$mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="100%">';
				$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reg.png" width="800" height="208" alt=""></td></tr>';
				$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';
				$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';
				$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;word-break: break-all;">'.$message.'</td><td width="80">&nbsp;</td>';
				$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png"></td></tr></table>';
				$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';
				//$mailbody .='</body></html>';
				
				ebmail( $email, $GLOBALS['CONF']['SiteEmail'], $strMailChk1.$GLOBALS['CONF']['SiteName'].$strMailChk2, $mailbody );
				}
				if ( $GLOBALS['MEMBERCONF']['UC_OPEN'] == "1" )
				{
								$uid = uc_user_register( $user, $password, $email );
								if ( $uid <= 0 )
								{
												if ( $uid == 0 - 1 )
												{
																echo $strUCREGNTC1;
																exit( );
												}
												else if ( $uid == 0 - 2 )
												{
																echo $strUCREGNTC2;
																exit( );
												}
												else if ( $uid == 0 - 3 )
												{
																echo $strUCREGNTC3;
																exit( );
												}
												else if ( $uid == 0 - 4 )
												{
																echo $strUCREGNTC4;
																exit( );
												}
												else if ( $uid == 0 - 5 )
												{
																echo $strUCREGNTC5;
																exit( );
												}
												else if ( $uid == 0 - 6 )
												{
																echo $strUCREGNTC6;
																exit( );
												}
												else
												{
																echo $strUCREGNTC7;
																exit( );
												}
								}
								else
								{
												uc_user_login( $user, $password );
								}
				}
				if($mustmail){
					echo "OK";
				}else{
					echo "OK_NOMAIL";
				}
				exit( );
				break;

	//判斷會員是否登陸
	case "isLogin":
		
		if(isset($_COOKIE["MUSER"])  && isset($_COOKIE["MEMBERID"]) && isset($_COOKIE["ZC"]) && $_COOKIE["MEMBERID"]!="" && $_COOKIE["MUSER"]!="" && $_COOKIE["ZC"]!=""){
			$md5=md5($_COOKIE["MUSER"]."76|01|14".$_COOKIE["MEMBERID"].$_COOKIE["MEMBERTYPE"].$_COOKIE["SE"]);
			if($_COOKIE["ZC"]==$md5){ 
				echo "1";
				exit;
			}else{
				echo "0";
				exit;
			}

		}else{
			echo "0";
			exit;
		}
		
	break;


	//取出會員註冊協議
	case "xieyi":
		
		$membertypeid=htmlspecialchars($_POST["membertypeid"]);

		$msql->query("select regxy from {P}_member_type where membertypeid='$membertypeid'");
		if($msql->next_record()){
			$regxy=nl2br($msql->f('regxy'));
		}
		echo $regxy;
		exit;

	break;

	//獲得會員註冊步驟
	case "getstep":
		$membertypeid=htmlspecialchars($_POST["membertypeid"]);
	    $nowstep=htmlspecialchars($_POST["nowstep"]);

		$str="";
		$i=0;
		$msql->query("select * from {P}_member_regstep where membertypeid='$membertypeid' order by xuhao");
		while($msql->next_record()){
			$regstep=$msql->f('regstep');
			$stepname=$msql->f('stepname');
			if($nowstep==$regstep){
				$str.="<li class='stepnow'>".$stepname."</li>";
			}else{
				$str.="<li class='step'>".$stepname."</li>";
			}
			$arr[$i]=$regstep;
		$i++;
		}
		
		if($nowstep=="account"){
			$nextstep=$arr[0];
		}else{
			for($p=0;$p<sizeof($arr);$p++){
				if($arr[$p]==$nowstep){
					$nextstep=$arr[$p+1];
				}
			}
		}
		if($nextstep=="" || $nextstep==null){
			$nextstep="enter";
		}
		
		$str.="<input type='hidden' id='nextst' value='".$nextstep."' />";
		echo $str;
		exit;

	break;
case "imgcode" :
				$ImgCode = trim( $_POST['codenum'] );
				$Ic = $_COOKIE['CODEIMG'];
				$Ic = strrev( $Ic ) + 5 * 2 - 9;
				$Ic = substr( $Ic, 0, 4 );
				if ( $ImgCode == "" || $Ic != $ImgCode )
				{
								echo "0";
				}
				else
				{
								echo "1";
				}
				exit( );
				break;
case "plusexit" :
				setcookie( "PLUSADMIN", "READY" );
				echo "OK";
				exit( );
				break;
case "plusclose" :
				setcookie( "PLUSADMIN", "" );
				echo "OK";
				exit( );
				break;
case "plusenter" :
				if ( admincheckauth( ) )
				{
								setcookie( "PLUSADMIN", "SET" );
								echo "OK";
				}
				else
				{
								echo "NORIGHTS";
				}
				exit( );
				break;
case "plusready" :
				if ( admincheckauth( ) )
				{
								setcookie( "PLUSADMIN", "READY" );
								echo "OK";
				}
				else
				{
								echo "NORIGHTS";
				}
				exit( );
				break;
case "setcookie" :
				$cookietype = $_POST['cookietype'];
				$cookiename = $_POST['cookiename'];
				$getnums = $_POST['getnums'];
				switch ( $cookietype )
				{
				case "addnew" :
								setcookie( $cookiename, $getnums );
								break;
				case "new" :
								$gid = $_POST['gid'];
								$nums = $_POST['nums'];
								$fz = $_POST['fz'];
								$disc = $_POST['disc'];
								if ( $nums == "" || intval( $nums ) < 1 || ceil( $nums ) != $nums )
								{
												echo "1000";
												exit( );
								}
								$CART = $gid."|".$nums."|".$fz."|".$disc."#";
								setcookie( $cookiename, $CART, time( ) + 3600, "/" );
								break;
				case "add" :
								$gid = $_POST['gid'];
								$nums = $_POST['nums'];
								$fz = $_POST['fz'];
								$disc = $_POST['disc'];
								if ( $nums == "" || intval( $nums ) < 1 || ceil( $nums ) != $nums )
								{
												echo "1000";
												exit( );
								}
								$NEWCART = $gid."|".$nums."|".$fz."|".$disc."#";
								$OLDCOOKIE = $_COOKIE[$cookiename];

								if ( $OLDCOOKIE == "" )
								{
												setcookie( $cookiename, $NEWCART );
								}
								else
								{
												$array = explode( "#", $OLDCOOKIE );
												$tnums = sizeof( $array ) - 1;
												$CART = "";
												$ifex = "0";
												
												for ( $t = 0;	$t < $tnums;	$t++	)
												{
																$fff = explode( "|", $array[$t] );
																$oldgid = $fff[0];
																$oldacc = $fff[1];
																$oldfz = $fff[2];
																$olddisc = $fff[3];
																if ( $gid == $oldgid && $fz == $oldfz )
																{
																				$newacc = $oldacc + $nums;
																				$CART .= $oldgid."|".$newacc."|".$oldfz."|".$olddisc."#";
																				$ifex = "1";
																}
																else
																{
																				$CART .= $oldgid."|".$oldacc."|".$oldfz."|".$olddisc."#";
																}
												}
												if ( $ifex != "1" )
												{
																$CART .= $NEWCART;
												}
												setcookie( $cookiename, $CART, time( ) + 3600, "/" );
								}
								break;
				case "del" :
								$gid = $_POST['gid'];
								$fz = $_POST['fz'];
								$picgid = (INT)$_POST['picgid'];
								if($picgid !=""){
									$gid .= "-".$picgid;
								}
								$OLDCOOKIE = $_COOKIE[$cookiename];
								$array = explode( "#", $OLDCOOKIE );
								$tnums = sizeof( $array ) - 1;
								$CART = "";
								for ( $t = 0;	$t < $tnums;	$t++	)
								{
									$fff = explode( "|", $array[$t] );
									$oldgid = $fff[0];
									$oldacc = $fff[1];
									$oldfz = $fff[2];
									$olddisc = $fff[3];
									
									//if ( $gid != $oldgid || $fz != $oldfz )
									if ( stripos($oldgid,$gid)===false || $fz != $oldfz )
									{
													$CART .= $oldgid."|".$oldacc."|".$oldfz."|".$olddisc."#";
									}
								}
								setcookie( $cookiename, $CART, time( ) + 3600, "/" );
								break;
				case "modi" :
								$gid = $_POST['gid'];
								$fz = $_POST['fz'];
								$nums = $_POST['nums'];
								$picgid = (INT)$_POST['picgid'];
								if($picgid !=""){
									$gid .= "-".$picgid;
								}
								
								if ( $nums == "" || intval( $nums ) < 1 || ceil( $nums ) != $nums )
								{
												echo "1000";
												exit( );
								}
								$OLDCOOKIE = $_COOKIE[$cookiename];
								$array = explode( "#", $OLDCOOKIE );
								$tnums = sizeof( $array ) - 1;
								$CART = "";
								
								for ($t = 0;	$t < $tnums;	$t++	)
								{
												$fff = explode( "|", $array[$t] );
												$oldgid = $fff[0];
												$oldacc = $fff[1];
												$oldfz = $fff[2];
												$olddisc = $fff[3];
												if ( $gid == $oldgid && $fz == $oldfz )
												{
																$CART .= $oldgid."|".$nums."|".$oldfz."|".$olddisc."#";
												}
												else
												{
																$CART .= $oldgid."|".$oldacc."|".$oldfz."|".$olddisc."#";
												}
								}
								setcookie( $cookiename, $CART, time( ) + 3600, "/" );
								break;
				case "empty" :
								setcookie( $cookiename );
								break;
				}
				if($getnums){ $tnums = $tnums+1; $shownums = "_".$tnums; }
				echo "OK".$shownums;
				exit( );
				break;
}

function checkaddr($addr){
	global $msql;
		
	$addr = str_replace("臺","台",$addr);
	
	$msql->query("SELECT * FROM {P}_member_zone");
	while ( $msql->next_record( ) )
	{
		$catid = $msql->f( "catid" );
		$pid = $msql->f( "pid" );
		
		$getcat = str_replace("　","",$msql->f( "cat" ));
		
		if($pid==0){
			$cat[$catid] = $getcat;
		}else{
			$pcat[$pid][] = $getcat;
		}
	}
	$isthat = false;
	foreach($cat as $keys=>$vasa){
		if( strpos($addr, $vasa) !== false ){
			foreach($pcat[$keys] as $vasb){
				if( strpos($addr, $vasb) !== false ){
					$isthat = true;
				}
			}
			if($isthat){
				return true;
			}else{
				return false;
			}
		}
	}
	
	return false;
	
}


?>