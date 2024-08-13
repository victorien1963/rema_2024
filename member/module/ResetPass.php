<?php





function ResetPass(){



	global $msql,$SiteUrl;

	global $strLostpassNtc1,$strLostpassNtc2,$strLostpassNtc3,$strLostpassNtc4,$strLostpassNtc5;

	global $strLostpassNtc6,$strLostpassNtc7,$strLostpassNtc8,$strLostpassNtc9;

	global $strLostpassNtc15,$strLostpassNtc16;





	

	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];

	$tempname=$GLOBALS["PLUSVARS"]["tempname"];

	

	

	$Temp=LoadTemp($tempname);

	$TempArr=SplitTblTemp($Temp);



	$step=$_REQUEST["step"];

	$mailchk=$_REQUEST["mail"];

	



	if($step=="checkmail"){



			$codestr=$_GET["codestr"];

			$username=$_GET["username"];

			$tm=$_GET["tm"];

			

			// $msql->query("SELECT chkcode FROM {P}_member WHERE email='$username'");
			$msql->query( 
				"SELECT *
				FROM (
					SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
					UNION ALL 
					SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
				) AS U
				WHERE email='$username'" );

			if($msql->next_record()){

				list($code,$npass)=explode("^",$msql->f('chkcode'));

			}



			/*if(!isset($_COOKIE["NEWPASSWD"]) || $_COOKIE["NEWPASSWD"]==""){

				//$PageMain=err($strLostpassNtc7,"lostpass.php","");

				//return $PageMain;

				$var=array(

					'err' => "<div class='alert alert-danger'>".$strLostpassNtc7."</div>",

				);

		

				$str=ShowTplTemp($TempArr["m0"],$var);

				return $str;

			}*/

			

			if($code==""){

				//$PageMain=err($strLostpassNtc7,"lostpass.php","");

				//return $PageMain;

				$var=array(

					'err' => "<div class='alert alert-danger'>".$strLostpassNtc7."</div>",

				);

		

				$str=ShowTplTemp($TempArr["m0"],$var);

				return $str;

			}



			//$md5=md5($username."Z(o)C~LoSbZ8Tj7MvBAs(8)!nn^Lp^12345^Pm".$_COOKIE["NEWPASSWD"].$tm);

			

			if($code==$codestr){



				//$mdpass=md5($_COOKIE["NEWPASSWD"]);

				$mdpass=md5($npass);				

				$msql->query("update {P}_member set password='$mdpass',chkcode='' where email='$username'");
				$msql->query("update {P}_member_offline set password='$mdpass',chkcode='' where email='$username'");
				

				//$PageMain=SayOk($strLostpassNtc8,"login.php","");

				//return $PageMain;

				$var=array(

				'email' => $strLostpassNtc8."<br />新密碼：<span style=\"color: red;font-size:1.5em;line-height:2;\">".$npass."</span>"

				);

		

				$str=ShowTplTemp($TempArr["m0"],$var);

				return $str;



			}else{



				//$PageMain=err($strLostpassNtc9,"lostpass.php","");

				//return $PageMain;

				$var=array(

				'err' => "<div class='alert alert-danger'>".$strLostpassNtc15."</div>",

				);

		

				$str=ShowTplTemp($TempArr["m0"],$var);

				return $str;

			}





	}elseif($step=="2"){



		$username=$_POST["username"];

		//$newpass=$_POST["newpass"];

		$chars = "0123456789ABCDEFGHJKLMNPQRSTUVWXYZ";

		$newpass = "";

		for ($i = 0; $i < 6; $i++) {

    		$newpass .= $chars[mt_rand(0, strlen($chars)-1)];

		}

	



		if(!isset($username) || $username==""){

			//$err=err($strLostpassNtc15,"","");

			$var=array(

			'err' => "<div class='alert alert-danger' style='clear:both;'>".$strLostpassNtc15."</div>",

			);

			$str=ShowTplTemp($TempArr["start"],$var);

		

			return $str;

			

		}else{



			$msql->query("select memberid,email from {P}_member where email='$username'");

			if($msql->next_record()){

				

				$memberid=$msql->f('memberid');

				

				$email=$msql->f('email');



				$tm=time();



				setCookie("NEWPASSWD",$newpass,time()+86400);



				$md5=md5($username."Z(o)C~LoSbZ8Tj7MvBAs(8)!nn^Lp^12345^Pm".$newpass.$tm);



				$link="<a href='".$SiteUrl."member/lostpass.php?step=checkmail&username=".$username."&codestr=".$md5."&tm=".$tm."' target='_blank'>點我連結</a><br /><br />若無法點選，請複製以下連結重新貼入瀏覽器瀏覽：<br />".$SiteUrl."member/lostpass.php?step=checkmail&username=".$username."&codestr=".$md5."&tm=".$tm;

				

				//存入codestr

				$setchkcode = $md5."^".$newpass;

				$msql->query("UPDATE {P}_member SET chkcode='".$setchkcode."' WHERE memberid='$memberid'");



				$message=$username.$strLostpassNtc2."\r\n \r\n".$strLostpassNtc3."\r\n \r\n".$link."\r\n \r\n".$GLOBALS["CONF"]["SiteName"]."\r\n".$GLOBALS["CONF"]["SiteHttp"];



				

				//$mailbody = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>';

				//$mailbody .='<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff">';

				$mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="100%">';

				$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reset.png" width="800" height="208" alt=""></td></tr>';

				$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';

				$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';

				$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;word-break: break-all;">'.$message.'</td><td width="80">&nbsp;</td>';

				$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png"></td></tr></table>';

				$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';

				//$mailbody .='</body></html>';

				

				/*$mailbody .='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff"><div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reset.png" style="width: 800px; max-width: 100%;"></div>';

				$mailbody .= '<div style="width: 800px; max-width: 100%;"><div style="width: 56%; max-width: 56%; min-height:303px; float:left;font-family:微軟正黑體; font-size:17px; padding-left:10%;">'.$message.'</div><div style="width: 240px; max-width: 30%; float:left;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png" style="width: 240px; max-width: 100%; float:left;"></div></div>';

				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" style="width: 800px; max-width: 100%;"></div></body></html>';*/



				include(ROOTPATH."includes/ebmail.inc.php");

				ebmail($email,$GLOBALS["CONF"]["SiteEmail"],$strLostpassNtc4,$mailbody);



				//$str=SayOk($strLostpassNtc5."<br><br>".$email,"","");

				$var=array(

					'email' => $email

				);

		

				$str=ShowTplTemp($TempArr["end"],$var);

				return $str;



			}else{

				//$err=err($strLostpassNtc16,"","");

				$var=array(

				'err' => "<div class='alert alert-danger'>".$strLostpassNtc16."</div>",

				);

				$str=ShowTplTemp($TempArr["start"],$var);

		

				return $str;



			}

		}

		

	}else{

		

		$var=array(

			'coltitle' => $coltitle,

			'showpass' => $mailchk? "none":"block",

		);

		

		$str=ShowTplTemp($TempArr["start"],$var);

		return $str;

	}



}



?>