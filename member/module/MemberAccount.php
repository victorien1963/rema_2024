<?php


function MemberAccount(){

	global $msql,$fsql;

	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];
	
	$memberid=$_COOKIE["MEMBERID"];
	

	
	//獲取會員資料
	$msql->query("select * from {P}_member where memberid='$memberid'");
	if($msql->next_record()){
		$user=$msql->f('user');
			$memberid=$msql->f('memberid');
			$membertypeid=$msql->f('membertypeid');
			$membergroupid=$msql->f('membergroupid');
			$name=$msql->f('name');
			$pname=$msql->f('pname');
			$sex=$msql->f('sex');
			$gen = $sex == 1 ? "男性":"女性";
			$birthday=$msql->f('birthday');
			
			$b_year = substr($birthday,0,4);
			$b_mon = substr($birthday,4,2);
			$b_day = substr($birthday,6,2);
			
			$zoneid=$msql->f('zoneid');
			$addr=$msql->f('addr');
			$tel=$msql->f('tel');
			$mov=$msql->f('mov');
			$postcode=$msql->f('postcode');
			$email=$msql->f('email');
			$url=$msql->f('url');
			$passtype=$msql->f('passtype');
			$passcode=$msql->f('passcode');
			$qq=$msql->f('qq');
			$msn=$msql->f('msn');
			$maillist=$msql->f('maillist');
			$bz=$msql->f('bz');
			$regtime=date("Y-m-d H:i:s",$msql->f('regtime'));
			$account=$msql->f('account');
			$paytotal=$msql->f('paytotal');
			$buytotal=$msql->f('buytotal');
			$cent1=$msql->f('cent1');
			$cent2=$msql->f('cent2');
			$cent3=$msql->f('cent3');
			$cent4=$msql->f('cent4');
			$cent5=$msql->f('cent5');
			$memberface=$msql->f('memberface');
			$nowface=$msql->f('nowface');
			$ip=$msql->f('ip');
			$logincount=$msql->f('logincount');
			$logintime=date("Y-m-d H:i:s",$msql->f('logintime'));
			$loginip=$msql->f('loginip');

			$exptime=$msql->f('exptime');
			
			$cardtoken = $msql->f('cardtoken');
			
			
			$order_epaper=$msql->f('order_epaper');
			if($order_epaper=="1"){
				$checkedok = "checked";
				$checkedno = "";
			}else{
				$checkedok = "";
				$checkedno = "checked";
			}
		
			if($exptime=="0"){
				$exptime="---";
			}else{
				$exptime=date("Y-m-d H:i:s",$msql->f('exptime'));
			}
	}


	$var=array (
		'password' => $password,
		'user' => $user,
			'name' => $name,
			'pname' => $pname,
			'account' => $account,
			'logincount' => $logincount,
			'memberurl' => $memberurl,
			'ip' => $ip,
			'logintime' => $logintime,
			'loginip' => $loginip,
			'regtime' => $regtime,
			'exptime' => $exptime,
			'email' => $email,
			'gen' => $gen,
			'sex' => $sex,
			'postcode' => $postcode,
			'addr' => $addr,
			'mov' => $mov,
			'tel' => $tel,
			'b_year' => $b_year,
			'b_mon' => $b_mon,
			'b_day' => $b_day,
			'checkedok' => $checkedok,
			'checkedno' => $checkedno,
			'order_paper' => $order_paper,
	);
	
	$ism = substr($pagename,-1)=="m"? true:false;

	if(isset($_GET["chk"]) && $_GET["chk"]=="p"){
		if($ism){
			$tempname= "tpl_member_maccount.htm";
		}else{
			$tempname= "tpl_member_account.htm";
		}
	}elseif(isset($_GET["chk"]) && $_GET["chk"]=="m"){
		if($ism){
			$tempname= "tpl_member_maccount_m.htm";
		}else{
			$tempname= "tpl_member_account_m.htm";
		}
	}elseif(isset($_GET["chk"]) && $_GET["chk"]=="e"){
		if($ism){
			$tempname= "tpl_member_maccount_e.htm";
		}else{
			$tempname= "tpl_member_account_e.htm";
		}
	}elseif(isset($_GET["chk"]) && $_GET["chk"]=="c"){

		//$toURL = "https://wwwtest.einvoice.nat.gov.tw/APMEMBERVAN/membercardlogin";
		$toURL = "https://www.einvoice.nat.gov.tw/APMEMBERVAN/membercardlogin"; //正式環境
		
		$card_ban = "24311840"; //營業人統一編號
			
		$card_no1 = base64_encode($email); //載具明碼並使用Base64加密後填入
		$card_no2 = base64_encode($memberid); //載具隱碼並使用Base64加密後填入

		$card_type = base64_encode("EG0029"); //載具類別編號使用Base64加密後填入
		$back_url = "http://localhost:3003:80membercard.php"; //接收歸戶訊息回傳(小平台)URL

		$token = base64_encode(time()); //小平台自動產生1個token僅使用一次
		
		//將 token寫入會員資料中，以待驗證
		if($cardtoken != "OK"){
			$msql->query("UPDATE {P}_member SET cardtoken='{$token}' where memberid='$memberid' ");
		}
		$var=array (
			'toURL' => $toURL,
			'card_ban' => $card_ban,
			'card_no1' => $card_no1,
			'card_no2' => $card_no2,
			'card_type' => $card_type,
			'back_url' => $back_url,
			'token' => $token,
			'memberid' => $memberid,
			'showok' => $cardtoken!="OK"? "none":"",
			'showbt' => $cardtoken!="OK"? "":"none",
		);

		if($ism){
			$tempname= "tpl_member_maccount_c.htm";
		}else{
			$tempname= "tpl_member_account_c.htm";
		}
	}

	//模版解釋
	$Temp=LoadTemp($tempname);
	$str=ShowTplTemp($Temp,$var);

	return $str;

}



?>