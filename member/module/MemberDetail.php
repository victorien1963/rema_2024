<?php





function MemberDetail(){



	global $msql,$fsql,$lantype;



	$pagename=$GLOBALS["PLUSVARS"]["pagename"];

	$memberid=$_COOKIE["MEMBERID"];



	

	//獲取會員資料

	// $msql->query("select * from {P}_member where memberid='$memberid'");
	$msql->query( 
		"SELECT *
		FROM (
			SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
			UNION ALL 
			SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
		) AS U
		where memberid='$memberid'" );

	if($msql->next_record()){

		$name=$msql->f('name');

		$company=$msql->f('company');

		$sex=$msql->f('sex');

		$birthday=$msql->f('birthday');

		$zoneid=$msql->f('zoneid');

		$url=$msql->f('url');

		$passtype=$msql->f('passtype');

		$passcode=$msql->f('passcode');

		$bz=$msql->f('bz');

		$membergroupid=$msql->f('membergroupid');

		$addr=$msql->f('addr');

		$postcode=$msql->f('postcode');

		$mov=$msql->f('mov');

		$tel=$msql->f('tel');

		$country=$msql->f('country');

		$countryid=$msql->f('countryid');

	}



	$ism = substr($pagename,-1)=="m"? true:false;

	//不同會員分組不同模板

	switch($membergroupid){

		case"1":

			if($ism){

				$tempname="tpl_p_102.htm";

			}else{

				$tempname="tpl_member_detail.htm";

			}

			

			$memberchk1 = "checked";

		break;

		case"2":

			if($ism){

				$tempname="tpl_p_102.htm";

			}else{

				$tempname="tpl_member_detail.htm";

			}

			$memberchk2 = "checked";

		break;

		default:

			if($ism){

				$tempname="tpl_p_102.htm";

			}else{

				$tempname="tpl_member_detail.htm";

			}

			$memberchk1 = "checked";

		break;

	}



	

	

	//表單資料處理		

	$yy=substr($birthday,0,4);

	$mm=substr($birthday,4,2);

	$dd=substr($birthday,6,2);

	

	$BirthYear=BirthYear($yy);

	$BirthMonth=BirthMonth($mm);

	$BirthDay=BirthDay($dd);

	$PassList=PassList($passtype);

	$ZONE=ZoneList($zoneid, $countryid);

	$ZoneList=$ZONE["str"];

	$Province=$ZONE["pr"];



	if($url==""){$url="http://";}

	if($sex=="1"){$CHKman=" selected";}

	if($sex=="2"){$CHKwoman=" selected";}

	

	$getlantype = "_".str_replace("zh_","",$lantype);

		$getlantype = str_replace("_tw","",$getlantype);

	$msql->query("select * from {P}".$getlantype."_member_zone where pid='0' and xuhao<>'0' order by xuhao");

	while ( $msql->next_record( ) )

	{

		$ccat = $msql->f("cat");

		if($country == $ccat){

			$selcountry .= "<option value='".$ccat."_".$msql->f("catid")."' selected> ".$ccat."</option>";

		}else{

			$selcountry .= "<option value='".$ccat."_".$msql->f("catid")."'> ".$ccat."</option>";

		}

	}



	$var=array (

		'BirthYear' => $BirthYear, 

		'CHKman' => $CHKman, 

		'CHKwoman' => $CHKwoman, 

		'BirthMonth' => $BirthMonth,

		'BirthDay' => $BirthDay,

		'ZoneList' => $ZoneList, 

		'Province' => $Province, 

		'PassList' => $PassList, 

		'name' => $name, 

		'company' => $company, 

		'zoneid' => $zoneid, 

		'url' => $url, 

		'passcode' => $passcode, 

		'bz' => $bz,

		'memberchk1' => $memberchk1,

		'memberchk2' => $memberchk2,

		'in1' => $memberchk1!=""? "in active":"",

		'in2' => $memberchk2!=""? "in active":"",

		'addr' => $addr,

		'mov' => $mov,

		'tel' => $tel,

		'postcode' => $postcode,

		'selcountry' => $selcountry,

		'yy' => $yy,

		'mm' => $mm,

		'dd' => $dd,

		'gender' => $sex==1? "男":"女",

	);





	//模版解釋

	$Temp=LoadTemp($tempname);

	$str=ShowTplTemp($Temp,$var);



	return $str;



}







?>