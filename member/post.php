<?php

define("ROOTPATH", "../");

include(ROOTPATH."includes/common.inc.php");

include("language/".$sLan.".php");

include(ROOTPATH."member/includes/member.inc.php");



$act = $_POST['act'];



switch($act){

	

	//忘記密碼

	case "forgotpass":

		

		$username=$_POST["username"];

		$chars = "0123456789ABCDEFGHJKLMNPQRSTUVWXYZ";

		$newpass = "";

		for ($i = 0; $i < 6; $i++) {

    		$newpass .= $chars[mt_rand(0, strlen($chars)-1)];

		}

		

		if(!isset($username) || $username==""){

			echo $strLostpassNtc15;

			exit;

		}else{

			//$msql->query("select memberid,email from {P}_member where email='$username'");
			$msql->query( 
				"SELECT *
				FROM (
					SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
					UNION ALL 
					SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
				) AS U
				where email='$username'" );

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
				$msql->query("UPDATE {P}_member_offline SET chkcode='".$setchkcode."' WHERE memberid='$memberid'");
				

				$message=$username.$strLostpassNtc2."\r\n \r\n".$strLostpassNtc3."\r\n \r\n".$link."\r\n \r\n".$GLOBALS["CONF"]["SiteName"]."\r\n".$GLOBALS["CONF"]["SiteHttp"];

				$mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="100%">';

				$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reset.png" width="800" height="208" alt=""></td></tr>';

				$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';

				$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';

				$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;word-break: break-all;">'.$message.'</td><td width="80">&nbsp;</td>';

				$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png"></td></tr></table>';

				$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';

				include_once(ROOTPATH."includes/ebmail.inc.php");

				ebmail($email,$GLOBALS["CONF"]["SiteEmail"],$strLostpassNtc4,$mailbody);

				

				echo $strLostpassNtc5.$email;

				exit;

				

			}else{

				echo $strLostpassNtc16;

				exit;

			}

		}

		

		echo $newpass;

		exit;

		

	break;

	

	//獲取彈出式登入框

	case "getzonelist":



		$zoneid=$_POST["zoneid"]? $_POST["zoneid"]:"0";

		$pid=$_POST["pid"];

		

		$ZONE=ZoneList($zoneid,$pid);

		$ZoneList=$ZONE["str"];

		$Province=$ZONE["pr"];

		

		echo $ZoneList;

		exit;

		

	break;



case "checkaddr":

	global $msql;

	

	$addr = $_POST['addr'];

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

				echo "OK";

				exit;

			}else{

				echo "NO";

				exit;

			}

		}

	}

	

	echo "NO";

	exit;

break;



	//獲取彈出式登入框

	case "getpoploginform":

		

		if( islogin() ){

			echo "islogin";

			exit();

		}

		



		$RP=$_POST["RP"];

		

		$str=LoadMemberTemp($RP,"tpl_poplogin.htm");

		echo $str;

		exit;

		

	break;

	

	//獲取彈出式註冊框

	case "getpopregform":		

		if( islogin() ){

			echo "islogin";

			exit();

		}

		$RP=$_POST["RP"];		

		$Temp=LoadMemberTemp($RP,"tpl_popreg.htm");

		

		$ZONE=ZoneList($zoneid);

		

		$ZoneList=$ZONE["str"];

		$Province=$ZONE["pr"];

		for($y=(date("Y")-13); $y>(date("Y")-85); $y--){

			$showyear .= "<option value='".$y."'> ".$y."</option>";

		}

		

		$selcountry = "<option value=''> ".$strPleaseSelect."</option>";

		$getlantype = "_".str_replace("zh_","",$lantype);

		$getlantype = str_replace("_tw","",$getlantype);

		$msql->query("select * from {P}".$getlantype."_member_zone where pid='0' and xuhao<>'0' order by xuhao");

		while ( $msql->next_record( ) )

		{

			$postcode = $msql->f("postcode");

			$postcode = str_replace("+886","",$postcode);

			$selcountry .= "<option value='".$msql->f("cat")."_".$msql->f("catid")."_".$postcode."'> ".$msql->f("cat")."</option>";

		}

		

		$str=str_replace("{#ZoneList#}", $ZoneList, $Temp);

		$str=str_replace("{#showyear#}", $showyear, $str);

		$str=str_replace("{#selcountry#}", $selcountry, $str);

		$str=str_replace("{#Province#}", $Province, $str);

		

		echo $str;

		exit;

		

	break;

	

	//獲取彈出式忘記密碼框

	case "getpopresetpassform":		

		if( islogin() ){

			echo "islogin";

			exit();

		}

		$RP=$_POST["RP"];		

		$str=LoadMemberTemp($RP,"tpl_popresetpass.htm");

		echo $str;

		exit;

		

	break;





	

	//註冊時驗證會員名是否重複

	case "checkuser":

		$user=trim($_POST['user']);



		$tsql -> query ("select memberid from {P}_member where user='$user' ");

		if($tsql -> next_record ()) {

			$allowreg="0";

		}else{

			$allowreg="1";

		}



		//UCenter接口---校驗用戶存在

		if($GLOBALS["MEMBERCONF"]["UC_OPEN"]=="1"){

			if(file_exists(ROOTPATH."api/uc_api/uc_client/client.php") && file_exists(ROOTPATH."api/uc_api/api.inc.php")){

				include(ROOTPATH."api/uc_api/api.inc.php");

				include(ROOTPATH."api/uc_api/uc_client/client.php");

				if(uc_get_user($user)){

					$allowreg="0";

				}

			}

		}



		echo $allowreg;

		exit;

	break;





	//會員帳號修改

	case "memberaccount":

		

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		

		//權限

		if(SecureFunc("111")==false){

			echo $strNorights;

			exit;

		}

	

		//$email=htmlspecialchars($_POST["email"]);

		//$resetpass=htmlspecialchars($_POST["resetpass"]);

		$password=htmlspecialchars($_POST["password"]);

		

		$postcode=htmlspecialchars($_POST["postcode"]);

		$addr=htmlspecialchars($_POST["addr"]);

		$mov=htmlspecialchars($_POST["mov"]);

		$tel=htmlspecialchars($_POST["tel"]);

		$order_epaper=htmlspecialchars($_POST["order_epaper"]);

		$country=htmlspecialchars($_POST["country"]);

		

		$newpassword=htmlspecialchars($_POST["newpassword"]);

		$renewpass=htmlspecialchars($_POST["renewpass"]);

		$mdpass=md5($password);

		

		$getpass = $msql->getone("select password,email,name from {P}_member where memberid='$memberid' and password='$mdpass' ");

		

		//舊密碼校驗

		if (!$getpass) { 

			echo $strRegNotice19;

			exit;

		}

		



		/*

		//電子郵件校驗

		if (!preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/i",$email)) { 

			echo $strRegNotice9;

			exit;

		}

		*/



		//$msql->query("update {P}_member set email='$email' where memberid='$memberid'");



		if($newpassword && ($newpassword == $renewpass) ){

			$mnewdpass=md5($newpassword);

			$msql->query("update {P}_member set password='$mnewdpass' where memberid='$memberid'");

		}elseif($newpassword){

			echo $strRegNotice20;

			exit;

		}

		

		/*$msql->query("update {P}_member set 

			postcode='$postcode',

			addr='$addr',

			mov='$mov',

			tel='$tel',

			order_epaper='$order_epaper'

		where memberid='$memberid'");*/



		//UCenter接口---修改密碼

		if($GLOBALS["MEMBERCONF"]["UC_OPEN"]=="1"){

			

			$msql->query("select user from {P}_member where memberid='$memberid'");

			if($msql->next_record()){

				$user=$msql->f('user');

			}



			if(file_exists(ROOTPATH."api/uc_api/uc_client/client.php") && file_exists(ROOTPATH."api/uc_api/api.inc.php")){

				include(ROOTPATH."api/uc_api/api.inc.php");

				include(ROOTPATH."api/uc_api/uc_client/client.php");

				if($resetpass=="yes"){

					$ucresult = uc_user_edit($user, '', $newpassword, $email,'1');

				}else{

					$ucresult = uc_user_edit($user, '', '', $email,'1');

				}

				

			}

		}

		/*$message= $getpass[name]." 先生/小姐 您好<br /><br />非常感謝您到 Rema 銳馬-運動服飾購物網站<br />進行選購，<br />您以電子郵件地址 ".$getpass[email]."<br />變更會員資料內容已成功，在此通知您。<br /><br />再次感謝，並期盼您的再次光臨。";

		

		$mailbody = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>';

		$mailbody .='<title>'.$fromtitle.'</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff">';

		$mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="800">';

		$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_modmem.png" width="800" height="208" alt=""></td></tr>';

		$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';

		$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';

		$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;">'.$message.'</td><td width="80">&nbsp;</td>';

		$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png"></td></tr></table>';

		$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';

		$mailbody .='</body></html>';

				

		include(ROOTPATH."includes/ebmail.inc.php");

		ebmail($getpass[email],$GLOBALS["CONF"]["SiteEmail"],"修改會員資料確認信",$mailbody);*/



		echo "OK";

		exit;

		

	break;

	

	case "memberaddr":

		

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		

		//權限

		if(SecureFunc("111")==false){

			echo $strNorights;

			exit;

		}

		$name = htmlspecialchars( $_POST['name'] );

		$postcode = htmlspecialchars( $_POST['postcode'] );

		$zoneid = htmlspecialchars( $_POST['zoneid'] );

		$addr = htmlspecialchars( $_POST['addr'] ).htmlspecialchars( $_POST['addr2'] );

		$mov = htmlspecialchars( $_POST['mov'] );

		$tel = htmlspecialchars( $_POST['tel'] );

		list($country, $countryid) = explode("_", $_POST['country'] );

		$country = htmlspecialchars( $country );

		

		if($name == ""){

			echo $strRegNotice12;

			exit();

		}

		if($addr == ""){

			echo $strRegNotice22;

			exit();

		}

		$dtime = time();

		$msql->query( "insert into {P}_member_addr set

			name = '$name',

			country = '$country',

			countryid = '$countryid',

			zoneid = '$zoneid',

			addr = '$addr',

			postcode = '$postcode',

			mov = '$mov',

			tel = '$tel',

			memberid = '$memberid',
			
            uptime = '$dtime'
		" );

			

		echo "OKADD";

		exit();

	break;



	case "memberaccountm":

		

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		

		//權限

		if(SecureFunc("111")==false){

			echo $strNorights;

			exit;

		}

		$password=htmlspecialchars($_POST["password"]);

		

		$newemail=htmlspecialchars($_POST["newemail"]);

		$renewemail=htmlspecialchars($_POST["renewemail"]);

		$mdpass=md5($password);

		

		$getpass = $msql->getone("select password,email,name from {P}_member where memberid='$memberid' and password='$mdpass' ");

		

		//舊密碼校驗

		if (!$getpass) { 

			echo $strRegNotice19;

			exit;

		}

		

		if($newemail == $renewemail ){

			$msql->query("update {P}_member set email='$newemail' where memberid='$memberid'");

			

			//更新訂單中的信箱

			$msql->query("update {P}_shop_order set email='$newemail' where memberid='$memberid'");

			//更新電子報中的信箱

			$msql->query("update {P}_paper_order set email='$newemail' where member_id='$memberid'");

			

			echo "OK";

			exit;

		}else{

			echo $strRegNotice21;

			exit;

		}

		

	break;

	

	case "memberaccounte":

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		

		//權限

		if(SecureFunc("111")==false){

			echo $strNorights;

			exit;

		}

		

		$order_epaper=htmlspecialchars($_POST["order_epaper"]);

				

		$msql->query("update {P}_member set order_epaper='$order_epaper' where memberid='$memberid'");

		$msql->query("update {P}_paper_order set is_order='$order_epaper' where member_id='$memberid'");

		

		echo "OK";

		exit;

		

	break;

	

	//讀取頭像

	case "loadface":

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];



		$fsql->query("select nowface from {P}_member where memberid='{$memberid}'");

		if($fsql->next_record()){

			$nowface=$fsql->f('nowface');

		}

		echo $nowface;

		exit;



	break;

	

	//刪除地址

	case "deltaddr":

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		$aid=$_POST["aid"];

		

		$fsql->query("DELETE FROM {P}_member_addr WHERE memberid='{$memberid}' AND id='{$aid}'");

		

		echo "OK";

		exit;



	break;

	//編輯地址

	case "modiaddr":

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		$aid=$_POST["aid"];

		if($aid == "0"){

			$fsql->query("SELECT * FROM {P}_member WHERE memberid='{$memberid}'");

			if($fsql->next_record()){

				$name = $fsql->f( "name" );

				$tel = $fsql->f( "tel" );

				$mov = $fsql->f( "mov" );

				$postcode = $fsql->f( "postcode" );

				$addr = $fsql->f( "addr" );

				$country = $fsql->f( "country" );

				$countryid = $fsql->f( "countryid" );

				$zoneid = $fsql->f( "zoneid" );

			}

		}else{

			$fsql->query("SELECT * FROM {P}_member_addr WHERE memberid='{$memberid}' AND id='{$aid}'");

			if($fsql->next_record()){

				$name = $fsql->f( "name" );

				$tel = $fsql->f( "tel" );

				$mov = $fsql->f( "mov" );

				$postcode = $fsql->f( "postcode" );

				$addr = $fsql->f( "addr" );

				$country = $fsql->f( "country" );

				$countryid = $fsql->f( "countryid" );

				$zoneid = $fsql->f( "zoneid" );

			}

		}

		

		$ZONE=ZoneList($zoneid, $countryid);

		$ZoneList=str_replace("'","\"",$ZONE["str"]);

		$Province=$ZONE["pr"];

		

		$getlantype = "_".str_replace("zh_","",$lantype);

		$getlantype = str_replace("_tw","",$getlantype);

		

		$fsql->query("select * from {P}".$getlantype."_member_zone where pid='0' and xuhao<>'0' order by xuhao");

		while ( $fsql->next_record( ) )

		{

			$ccat = $fsql->f("cat");

			if($country == $ccat){

				$selcountry .= "<option value=\"".$ccat."_".$fsql->f("catid")."\" selected> ".$ccat."</option>";

			}else{

				$selcountry .= "<option value=\"".$ccat."_".$fsql->f("catid")."\"> ".$ccat."</option>";

			}

		}

		

		$str = "var M={H:'".$ZoneList."',N:'".$name."',T:'".$tel."',M:'".$mov."',P:'".$postcode."',A:'".$addr."',C:'".$selcountry."',Z:'".$zoneid."',V:'".$Province."',D:'".$aid."'}";

		

		echo $str;

		exit;



	break;

	

	//修改地址

	case "memberaddrmodi":

		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		$aid=$_POST["aid"];

		

		$sex = htmlspecialchars( $_POST['ssex'] );

		$name = htmlspecialchars( $_POST['sname'] );

		$postcode = htmlspecialchars( $_POST['spostcode'] );

		$zoneid = htmlspecialchars( $_POST['szoneid'] );

		$addr = htmlspecialchars( $_POST['saddr'] ).htmlspecialchars( $_POST['saddr2'] );

		$mov = htmlspecialchars( $_POST['smov'] );

		$tel = htmlspecialchars( $_POST['stel'] );

		list($country, $countryid) = explode("_", $_POST['scountry'] );

		$country = htmlspecialchars( $country );

		$dtime = time();

		if($aid == "0"){

			$fsql->query("UPDATE {P}_member SET 

				name = '$name',

				country = '$country',

				countryid = '$countryid',

				zoneid = '$zoneid',

				addr = '$addr',

				postcode = '$postcode',

				mov = '$mov',

				tel = '$tel' 

			WHERE memberid='{$memberid}'");

		}else{

			$fsql->query("UPDATE {P}_member_addr SET 

				name = '$name',

				sex = '$sex',

				country = '$country',

				countryid = '$countryid',

				zoneid = '$zoneid',

				addr = '$addr',

				postcode = '$postcode',

				mov = '$mov',

				tel = '$tel',
				
				uptime = '$dtime'

			WHERE memberid='{$memberid}' AND id='{$aid}'");

		}

		

		echo "OK";

		exit;



	break;

	

	//頭像簽名設置

	case "memberperson":



		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];



		$Meta="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

		

		//權限

		if(SecureFunc("112")==false){

			echo $Meta.$strNorights;

			exit;

		}



		$pname=htmlspecialchars($_POST["pname"]);

		$signature=htmlspecialchars($_POST["signature"]);

		$nowface=htmlspecialchars($_POST["nowface"]);

		$pic=$_FILES["jpg"];



		



		if($pname==""){

			echo $Meta.$strRegNotice13;

			exit;

		}



		//校驗暱稱是否允許重複

		if($GLOBALS["MEMBERCONF"]["DblPname"]!="1"){

			$fsql->query("select memberid from {P}_member where pname='$pname' and memberid!='$memberid'");

			if($fsql->next_record()){

				echo $Meta.$strRegNotice15;

				exit;

			}

		}



		//頭像上傳

		if($pic["size"]>0){

			if($pic["size"]>102400){

				echo $Meta.$strMemberFaceNtc1;

				exit;

			}

		$type = array("image/gif","image/jpg","image/jpeg","image/pjpeg","image/x-png");

		if ( !in_array( $pic['type'], $type ) )

		{

			echo $Meta.$strMemberFaceNtc2;

			exit( );

		}

			//$ext = pathinfo($pic['name'], PATHINFO_EXTENSION);

			$nowface=$memberid+100000;

			$filepath = ROOTPATH."member/face/".$nowface.".gif";

			copy ($pic["tmp_name"],$filepath);

			chmod ($filepath,0666);

		}





		$msql->query("update {P}_member set 

		pname='$pname',

		signature='$signature',

		nowface='$nowface'

		where memberid='$memberid'");



				$fsql->query("select value from {P}_member_config where variable='MustCheckEmail'");

				if ( $fsql->next_record( ) )

				{

					if($fsql->f("value") == '1'){

							$mustmail = TRUE;

					}

				}

		if($mustmail){

			echo "OK";

		}else{

			echo "OK_NOMAIL";

		}

		exit;



	break;









	//會員資料設置

	case "memberdetail":



		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		

		$Meta="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

		

		//權限

		if(SecureFunc("113")==false){

			echo $Meta.$strNorights;

			exit;

		}



		/*$name=$_POST["sname"]? htmlspecialchars($_POST["sname"]):htmlspecialchars($_POST["name"]);

		$company=htmlspecialchars($_POST["company"]);

		$sex=htmlspecialchars($_POST["sex"]);

		$yy=htmlspecialchars($_POST["yy"]);

		$mm=htmlspecialchars($_POST["mm"]);

		$dd=htmlspecialchars($_POST["dd"]);

		$url=htmlspecialchars($_POST["url"]);

		$zoneid=$_POST["szoneid"]? htmlspecialchars($_POST["szoneid"]):htmlspecialchars($_POST["zoneid"]);

		$Province=$_POST["sProvince"]? htmlspecialchars($_POST["sProvince"]):htmlspecialchars($_POST["Province"]);

		$passtype=htmlspecialchars($_POST["passtype"]);

		$passcode=htmlspecialchars($_POST["passcode"]);

		$bz=htmlspecialchars($_POST["bz"]);

		$postcode=$_POST["spostcode"]? htmlspecialchars($_POST["spostcode"]):htmlspecialchars($_POST["postcode"]);

		$addr=$_POST["saddr"]? htmlspecialchars($_POST["saddr"]):htmlspecialchars($_POST["addr"]);*/

		$mov=$_POST["smov"]? htmlspecialchars($_POST["smov"]):htmlspecialchars($_POST["mov"]);

		/*$tel=$_POST["stel"]? htmlspecialchars($_POST["stel"]):htmlspecialchars($_POST["tel"]);

		$zoneid=$_POST["szoneid"]? htmlspecialchars($_POST["szoneid"]):htmlspecialchars($_POST["zoneid"]);

		//$membertypeid=htmlspecialchars($_POST["membertypeid"]);

		list($country, $countryid) = $_POST['scountry']? explode("_", $_POST['scountry'] ):explode("_", $_POST['country'] );

		$country = htmlspecialchars( $country );*/

		



		/*if($name==""){

			echo $Meta.$strRegNotice12;

			exit();

		}



		if(strlen($mm)<2){

			$mmm="0".$mm;

		}else{

			$mmm=$mm;

		}

		if(strlen($dd)<2){

			$ddd="0".$dd;

		}else{

			$ddd=$dd;

		}

		

		$birthday=$yy.$mmm.$ddd;

		

		$msql->query("update {P}_member set 

		name='$name',

		company='$company',

		sex='$sex',

		birthday='$birthday',

		zoneid='$zoneid',

		url='$url',

		passtype='$passtype',

		passcode='$passcode',

		bz='$bz',

		postcode='$postcode',

		addr='$addr',

		country='$country',

		countryid='$countryid',

		mov='$mov',

		tel='$tel' 

		where memberid='$memberid'");

		

		$fsql->query("select value from {P}_member_config where variable='MustCheckEmail'");

		if ( $fsql->next_record( ) )

		{

			if($fsql->f("value") == '1'){

					$mustmail = TRUE;

			}

		}

				

		if($mustmail){

			echo "OK";

		}else{

			echo "OK_NOMAIL";

		}*/

		

		if($mov==""){

			echo $Meta.$strRegNotice24;

			exit();

		}

		

		$msql->query("update {P}_member set 

			mov='$mov' 

		where memberid='$memberid'");

		

		echo "OK";

		exit;





	break;









	//聯絡資訊設置

	case "membercontact":



		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		

		$Meta="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";



		//權限

		if(SecureFunc("114")==false){

			echo $Meta.$strNorights;

			exit;

		}



		$addr=htmlspecialchars($_POST["addr"]);

		$tel=htmlspecialchars($_POST["tel"]);

		$mov=htmlspecialchars($_POST["mov"]);

		$postcode=htmlspecialchars($_POST["postcode"]);

		$email=htmlspecialchars($_POST["email"]);

		$qq=htmlspecialchars($_POST["qq"]);

		$msn=htmlspecialchars($_POST["msn"]);

		$name=htmlspecialchars($_POST["name"]);

		

		if($name==""){

			echo $Meta.$strRegNotice12;

			exit();

		}



		//電子郵件校驗

		if (!preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/i",$email)) { 

			echo $Meta.$strRegNotice9;

			exit;

		} 



		$msql->query("update {P}_member set 



		name='$name',

		addr='$addr',

		tel='$tel',

		mov='$mov',

		postcode='$postcode',

		email='$email',

		qq='$qq',

		msn='$msn'

		

		where memberid='$memberid'");





				$fsql->query("select value from {P}_member_config where variable='MustCheckEmail'");

				if ( $fsql->next_record( ) )

				{

					if($fsql->f("value") == '1'){

							$mustmail = TRUE;

					}

				}

		if($mustmail){

			echo "OK";

		}else{

			echo "OK_NOMAIL";

		}

		exit;



	break;





	//收藏刪除

	case "delfav":



	SecureMember();

	$memberid=$_COOKIE["MEMBERID"];

	$favid=htmlspecialchars($_POST["favid"]);



	$msql->query("delete from {P}_member_fav where memberid='$memberid' and id='$favid'");

	

	echo "OK";

	exit;



	break;



	

	//好友刪除

	case "delfri":



	SecureMember();

	$memberid=$_COOKIE["MEMBERID"];

	$nowid=htmlspecialchars($_POST["nowid"]);



	$msql->query("delete from {P}_member_friends where memberid='$memberid' and id='$nowid'");

	

	echo "OK";

	exit;



	break;



	

	//加為好友

	case "addfriends" :

	

		$fid=$_POST["fid"];

		

		if(!isLogin()){

			echo "L0";

			exit;

		}

		

		$memberid=$_COOKIE["MEMBERID"];



		if($fid=="" || $fid=="0" || $fid=="-1"){

			echo $strMemberFriNtc1;

			exit;

		}



		if($fid==$memberid){

			echo $strMemberFriNtc2;

			exit;

		}





		$msql->query("select id from {P}_member_friends where fid='$fid' and memberid='$memberid'");

		if($msql->next_record()){

			echo $strMemberFriNtc3;

			exit;

		}



		$msql->query("insert into {P}_member_friends set fid='$fid',memberid='$memberid'");





		//積分計算

		MemberCentUpdate($memberid,"112");



		echo "OK";

		exit;



	break;





	//我的評論刪除

	case "delcomm":



	SecureMember();

	$memberid=$_COOKIE["MEMBERID"];



	$nowid=htmlspecialchars($_POST["nowid"]);



	$msql->query("select id from {P}_comment where id='$nowid' and memberid='$memberid'");

	if($msql->next_record()){

			$fsql->query("delete from {P}_comment where pid='$nowid'");

			$fsql->query("delete from {P}_comment where memberid='$memberid' and id='$nowid'");

			echo "OK";

			exit;



	}else{

		echo $strMemberCommentNtc;

		exit;

	}



	break;









	//獲取站內短信表單

	case "loadmsg":



		$RP=$_POST["RP"];

		$mid=$_POST["mid"];



		if(!isLogin()){

			echo "L0";

			exit;

		}

		

		$msql -> query ("select pname from {P}_member where memberid='$mid' ");

		if($msql -> next_record ()) {

			$pname=$msql->f('pname');

		}

		$str=LoadMemberTemp($RP,"tpl_msnform.htm");

		$str=str_replace("{#pname#}",$pname,$str);

		$str=str_replace("{#tomemberid#}",$mid,$str);



		echo $str;

		exit;

		

	break;





	

	//發送站內短信

	case "sendmsn":

		

		$tomemberid=$_POST["tomemberid"];

		$body=htmlspecialchars($_POST["body"]);



		if($body==""){

			echo $strMemberMsnNtc1;

			exit;

		}



		SecureMember();

		$memberid=$_COOKIE["MEMBERID"];

		$dtime=time();



		$msql->query("insert into {P}_member_msn set

			`body`='$body',

			`tomemberid`='$tomemberid',

			`frommemberid`='$memberid',

			`dtime`='$dtime',

			`iflook`='0'

		");



		//積分計算

		MemberCentUpdate($memberid,"113");

		



		echo "OK";

		exit;



	break;





	//站內短信刪除

	case "delmsn":



	SecureMember();

	$memberid=$_COOKIE["MEMBERID"];



	$nowid=htmlspecialchars($_POST["nowid"]);



	$fsql->query("delete from {P}_member_msn where tomemberid='$memberid' and id='$nowid'");

	

	echo "OK";

	exit;



	break;





	//新到站內短信數量

	case "countmsn":



	$memberid=$_COOKIE["MEMBERID"];



	$fsql->query("select count(id) from {P}_member_msn where tomemberid='$memberid' and iflook='0'");

	if($fsql->next_record()){

		$nums=$fsql->f('count(id)');

	}

	

	echo $nums;

	exit;



	break;

	

	/*註冊即時檢測信箱*/

	case "checkmail" :

				$email = trim( $_POST['email'] );

				// $tsql->query( "select memberid from {P}_member where email='{$email}'" );
				$tsql->query( 
					"SELECT *
					FROM (
						SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
						UNION ALL 
						SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
					) AS U
					where email='$email'" );

				if ( $tsql->next_record( ) )

				{

								$allowreg = "NO";

								echo $allowreg;

								exit();

				}

				else

				{

								$allowreg = "YES";

				}

				echo $allowreg;

				exit( );

				break;



}



/*台灣身份證驗證*/

function check_identity($id) {

$flag = false;

$id=strtoupper($id);

$d0=strlen($id);

$qd="";

if ($d0 <= 0) {$qd=$qd."還沒填呢 !n";}

if ($d0 > 10) {$qd=$qd."超過10個字 !n";}

if ($d0 < 10 && $d0 > 0) {$qd=$qd."不滿10個字 !n";}

$d1=substr($id,0,1);

$ds=ord($d1);

if ($ds > 90 || $ds < 65) {$qd=$qd."第一碼必須是大寫的英文字母 !n";}

$d2=substr($id,1,1);

if($d2!="1" && $d2!="2") {$qd=$qd."第二碼有問題 !n";}

for ($i=1;$i<10;$i++) {

$d3=substr($id,$i,1);

$ds=ord($d3);

if ($ds > 57 || $ds < 48) {$n=$i+1;$qd=$qd."第二到十碼有問題 !n";

break;}

}

$num=array("A" => "10","B" => "11","C" => "12","D" => "13","E" => "14",

"F" => "15","G" => "16","H" => "17","J" => "18","K" => "19","L" => "20",

"M" => "21","N" => "22","P" => "23","Q" => "24","R" => "25","S" => "26",

"T" => "27","U" => "28","V" => "29","X" => "30","Y" => "31","W" => "32",

"Z" => "33","I" => "34","O" => "35");

$n1=substr($num[$d1],0,1)+(substr($num[$d1],1,1)*9);

$n2=0;

for ($j=1;$j<9;$j++) {

$d4=substr($id,$j,1);

$n2=$n2+$d4*(9-$j);

}

$n3=$n1+$n2+substr($id,9,1);

if(($n3 % 10)!=0) {$qd=$qd."不通過 !n";}

if ($qd=="") {$flag = true;}

return $flag;

}

?>