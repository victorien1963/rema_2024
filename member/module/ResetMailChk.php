<?php
function ResetMailChk( )
{
				global $msql;
				global $fsql;
				global $tsql;
				global $SiteUrl;
				global $strLostpassNtc11;
				global $strMailChk1;
				global $strMailChk2;
				global $strMailChk3;

				global $strLostpassNtc2;
				global $strLostpassNtc14;
				global $strLostpassNtc13;
				global $strLostpassNtc12;
				global $strLostpassNtc6;
				global $strLostpassNtc7;
				global $strLostpassNtc8;
				global $strLostpassNtc9;
				global $strLostpassNtc10;
				global $strLoginNotice3;
				global $strRegNotice16;
				global $strRegNotice9;
				global $strRegNotice18;
				global $strLoginNotice4;
				global $strBack;
				
				$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				
	
	//模版解釋
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	
				$step = $_REQUEST['step'];
				$mailchk=$_REQUEST["mail"];
				
				if ( $step == "chkcode" )
				{
				
								$codestr = $_GET['codestr'];
								$muser = $_GET['username'];
								$tm = $_GET['tm'];
								$msql->query( "select * from {P}_member where user='{$muser}' and chkcode='{$codestr}' " );
								if( $msql->next_record( ) ){
									
									$email= $msql->f("email");
									$memberid = $msql->f("memberid");
									
										$fsql->query( "update {P}_member set rz='1' where user='{$muser}'" );
										
										//$PageMain = sayok( $strLostpassNtc10, "index.php", "" );
										$PageMain = saytemp( $strLostpassNtc10,$strBack,ROOTPATH."member/index.php", $TempArr["m1"]);
										return $PageMain;
																				
								}else{
										//$PageMain = err( $strLostpassNtc9, "lostpass.php", "" );
										$PageMain = saytemp( $strLostpassNtc9,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m0"]);
										return $PageMain;
								}
								

				}
				else if ( $step == "resetcode" )
				{
								$username = htmlspecialchars( trim( $_POST['username'] ) );
								$userpass = htmlspecialchars( trim( $_POST['userpass'] ) );
								$newmail = htmlspecialchars( trim( $_POST['newmail'] ) );
								$mdpass = md5( $userpass );
								
								
								if($newmail){
									/*if ( !preg_match( "/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}\$/i", $newmail ) )
									{
										$str = err( $strRegNotice9, "", "" );
										return $str;
									}*/
											$tsql->query( "select memberid from {P}_member where email='{$email}' and password='{$mdpass}'" );
											$fsql->query( "select memberid from {P}_member where user='{$username}' and password='{$mdpass}'" );
								}else{
									//$str = err( $strRegNotice18, "", "" );
									$str = saytemp( $strRegNotice18,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m0"]);
									return $str;
								}

								if ( !isset( $username ) || $username == "" )
								{
												//$str = err( $strLostpassNtc11, "", "" );
												$str = saytemp( $strLostpassNtc11,$strBack,ROOTPATH."member/index.php", $TempArr["m0"]);
												return $str;
								}
								elseif ( $newmail && $tsql->next_record( ) )
								{
												//$str = err( $strRegNotice16, "", "" );
												$str = saytemp( $strRegNotice16,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m0"]);
												return $str;
								}
								elseif ( !$fsql->next_record( ) )
								{
												//$str = err( $strLoginNotice4, "", "" );
												$str = saytemp( $strLoginNotice4,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m0"]);
												return $str;
								}
								else
								{
												$msql->query( "select memberid,email from {P}_member where user='{$username}' and rz='0' " );
												if ( $msql->next_record( ) )
												{													
																$email = $msql->f( "email" );
																$memberid = $msql->f( "memberid" );
																$chkcode = md5($_SERVER['HTTP_USER_AGENT'].time()."qYW%e^88W5");
																$link = $SiteUrl."member/lostpass.php?mail=check&step=chkcode&username=".$username."&codestr=".$chkcode;
																$message = $username.$strLostpassNtc2."\r\n \r\n".$strMailChk3."\r\n \r\n<a href=\"".$link."\" target=\"_blank\">".$link."</a>\r\n \r\n".$GLOBALS['CONF']['SiteName']."\r\n".$GLOBALS['CONF']['SiteHttp'];
																
				
				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_mem.png" style="width: 800px; max-width: 100%;"></div>';
				$mailbody .='<div style="width: 648px; max-width: 100%; padding:0 75px 50px 77px; "><div style="font-family: 微軟正黑體; font-size:17px; word-break:break-all; display: table;">'.$message.'</div></div>';
				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" style="width: 800px; max-width: 100%;"></div>';

																include( ROOTPATH."includes/ebmail.inc.php" );

													if(!$newmail || $newmail==$email){
																$fsql->query( "update {P}_member set rz='0',chkcode='{$chkcode}' where user='{$username}' " );
																ebmail( $email, $GLOBALS['CONF']['SiteEmail'], $strMailChk1.$GLOBALS['CONF']['SiteName'].$strMailChk2, $mailbody );
																//$str = sayok( $strLostpassNtc12."<br><br>".$email, "", "" );
																$str = saytemp( $strLostpassNtc12."<br><br>".$email,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m1"]);
																return $str;
													}elseif($newmail!=$email){
																//檢測是否有相同的帳號
																$tsql->query( "select memberid from {P}_member where user='{$newmail}'" );
																if($tsql->next_record()){
																	//已經有相同的帳號
																	$str = saytemp( $strRegNotice16,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m0"]);
																	return $str;
																}
																				
																$fsql->query( "update {P}_member set user='{$newmail}',rz='0',chkcode='{$chkcode}' where user='{$username}' " );
																ebmail( $newmail, $GLOBALS['CONF']['SiteEmail'], $strMailChk1.$GLOBALS['CONF']['SiteName'].$strMailChk2, $mailbody );
																//$str = sayok( $strLostpassNtc13."<br><br>".$newmail, "", "" );
																$str = saytemp( $strLostpassNtc13."<br><br>".$newemail,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m1"]);
																return $str;
													}
												}
												else
												{
													//$str = err( $strLostpassNtc14, "", "" );
													$str = saytemp( $strLostpassNtc14,$strBack,ROOTPATH."member/lostpass.php?mail=check", $TempArr["m0"]);
													return $str;
												}
								}
				}
				else
				{
					$var=array(
						'coltitle' => $coltitle,
						'showchk' => $mailchk? "block":"none",
					);
					
					$str=ShowTplTemp($TempArr["start"],$var);
					
					return $str;
				}
}
?>