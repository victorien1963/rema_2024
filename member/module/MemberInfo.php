<?php



/*

	[元件名稱] 會員登入資訊

	[適用範圍] 會員中心

*/



function MemberInfo(){



	global $msql;

		

	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];

	$tempname=$GLOBALS["PLUSVARS"]["tempname"];



		



		$msql->query("select * from {P}_member where memberid='".$_COOKIE["MEMBERID"]."'");
		// $msql->query( 
		// 	"SELECT *
		// 	FROM (
		// 		SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
		// 		UNION ALL 
		// 		SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
		// 	) AS U
		// 	where memberid='".$_COOKIE["MEMBERID"]."'" );

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

		

			if($exptime=="0"){

				$exptime="---";

			}else{

				$exptime=date("Y-m-d H:i:s",$msql->f('exptime'));

			}

		



		}



		$memberurl=ROOTPATH."member/home.php?mid=".$memberid;







		$Temp=LoadTemp($tempname);



		$var=array(

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

			'postcode' => $postcode,

			'addr' => $addr,

			'mov' => $mov,

			'tel' => $tel,

			'b_year' => $b_year,

			'b_mon' => $b_mon,

			'b_day' => $b_day

		);

		

		$str=ShowTplTemp($Temp,$var);



		return $str;





}



?>