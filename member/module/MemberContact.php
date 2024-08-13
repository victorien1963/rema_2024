<?php


function MemberContact(){

	global $msql,$fsql,$strPleaseSelect,$lantype;

	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	
	$memberid=$_COOKIE["MEMBERID"];
	
	$act = $_GET["act"];
	$type = $_GET["type"];
	

	//模版解釋
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	
	
	//獲取會員資料
	$msql->query("select * from {P}_member where memberid='$memberid'");
	if($msql->next_record()){
		$id=$msql->f('id');
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
		
		switch($membergroupid){
			case"1":
				
				$memberchk1 = "checked";
			break;
			case"2":
				$memberchk2 = "checked";
			break;
			default:
				$memberchk1 = "checked";
			break;
		}
		
		$yy=substr($birthday,0,4);
		$mm=substr($birthday,4,2);
		$dd=substr($birthday,6,2);
		
		$BirthYear=BirthYear($yy);
		$BirthMonth=BirthMonth($mm);
		$BirthDay=BirthDay($dd);
		$PassList=PassList($passtype);

	if($act == ""){
		$ZONE=ZoneList(0);
	}elseif($act == "modi"){
		$ZONE=ZoneList($zoneid, $countryid);
	}
		$ZoneList=$ZONE["str"];
		$Province=$ZONE["pr"];
		
		if($sex=="1"){$CHKman=" selected";}
		if($sex=="2"){$CHKwoman=" selected";}
		
		$addr_a=substr($msql->f('addr'),0,9);
		$addr_b=substr($msql->f('addr'),9,9);
		$addr_c=substr($msql->f('addr'),18);
		
		$selcountry = $blankcountry = "<option value=''> ".$strPleaseSelect."</option>";
		
		$getlantype = "_".str_replace("zh_","",$lantype);
		$getlantype = str_replace("_tw","",$getlantype);
		$fsql->query("select * from {P}".$getlantype."_member_zone where pid='0' and xuhao<>'0' order by xuhao");
		while ( $fsql->next_record( ) )
		{
			$ccat = $fsql->f("cat");
			if($country == $ccat){
				if($act == ""){
					$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."'> ".$ccat."</option>";
				}elseif($act == "modi"){
					$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."' selected> ".$ccat."</option>";
				}
				
			}else{
				$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."'> ".$ccat."</option>";
			}
			$blankcountry .= "<option value='".$ccat."_".$fsql->f("catid")."'> ".$ccat."</option>";
		}
		

		$var=array (
			'id' => $id,
			'BirthYear' => $BirthYear, 
			'CHKman' => $CHKman, 
			'CHKwoman' => $CHKwoman, 
			'BirthMonth' => $BirthMonth,
			'BirthDay' => $BirthDay,
			'ZoneList' => $ZoneList, 
			'Province' => $Province, 
			'PassList' => $PassList, 
			'country' => $country,
			'addr_a' => $addr_a, 
			'addr_b' => $addr_b, 
			'addr_c' => $addr_c, 
			'tel' => $tel, 
			'mov' => $mov, 
			'postcode' => $postcode, 
			'name' => $name,
			'memberid' => $memberid,
			'company' => $company, 
			'passcode' => $passcode, 
			'zoneid' => $zoneid, 
			'bz' => $bz,
			'memberchk1' => $memberchk1,
			'memberchk2' => $memberchk2,
			'in1' => $memberchk1!=""? "in active":"",
			'in2' => $memberchk2!=""? "in active":"",
			'addr' => $addr,
			'selcountry' => $selcountry,
			'REFERER' =>  $_SERVER['HTTP_REFERER'],
		);
	}
	
	
	if($act == ""){
		$str=ShowTplTemp($TempArr["start"],$var);
	}elseif($act == "modi"){
			if($type == "mobi"){
				$str=ShowTplTemp($TempArr["m3"],$var);
				$str=str_replace("{#mobiact#}","memberdetail",$str);
			}else{
				$str=ShowTplTemp($TempArr["m0"],$var);
			}
	}
	
	
	if($act == ""){
		//獲取會員其他地址資料
		$msql->query("select * from {P}_member_addr where memberid='$memberid'");
		while($msql->next_record()){
			$id=$msql->f('id');
			$name=$msql->f('name');
			$sex=$msql->f('sex');
			$zoneid=$msql->f('zoneid');
			$addr=$msql->f('addr');
			$country=$msql->f('country');
			$tel=$msql->f('tel');
			$mov=$msql->f('mov');
			$postcode=$msql->f('postcode');
			
			if($sex=="1"){$CHKman=" selected";}
			if($sex=="2"){$CHKwoman=" selected";}
			
			$addr_a=substr($msql->f('addr'),0,9);
			$addr_b=substr($msql->f('addr'),9,9);
			$addr_c=substr($msql->f('addr'),18);

			$var=array (
				'id' => $id, 
				'country' => $country, 
				'zoneid' => $zoneid,
				'addr_a' => $addr_a, 
				'addr_b' => $addr_b, 
				'addr_c' => $addr_c, 
				'tel' => $tel, 
				'mov' => $mov, 
				'postcode' => $postcode, 
				'name' => $name,
				'selcountry' => $selcountry,
				'REFERER' =>  $_SERVER['HTTP_REFERER'],
			);
			
			$str.=ShowTplTemp($TempArr["list"],$var);

		}
		
		
			$ZONE=ZoneList(0);
			$ZoneList=$ZONE["str"];
			$Province=$ZONE["pr"];
			
			$var=array (
				'ZoneList' => $ZoneList, 
				'Province' => $Province, 
				'PassList' => $PassList,
				'selcountry' => $selcountry,
				'REFERER' =>  $_SERVER['HTTP_REFERER'],
			);

		$str.=ShowTplTemp($TempArr["end"],$var);
	
	}elseif($act == "modiaddr"){
		//獲取會員其他地址資料
		$aid = $_GET["aid"];
		$msql->query("select * from {P}_member_addr where id='$aid'");
		if($msql->next_record()){
			$id=$msql->f('id');
			$name=$msql->f('name');
			$sex=$msql->f('sex');
			$zoneid=$msql->f('zoneid');
			$addr=$msql->f('addr');
			$country=$msql->f('country');
			$countryid=$msql->f('countryid');
			$tel=$msql->f('tel');
			$mov=$msql->f('mov');
			$postcode=$msql->f('postcode');
			
			
			$PassList=PassList($passtype);
			$ZONE=ZoneList($zoneid, $countryid);
			$ZoneList=$ZONE["str"];
			$Province=$ZONE["pr"];
			
			if($sex=="1"){$CHKman=" selected";}
			if($sex=="2"){$CHKwoman=" selected";}
			
			$addr_a=substr($msql->f('addr'),0,9);
			$addr_b=substr($msql->f('addr'),9,9);
			$addr_c=substr($msql->f('addr'),18);
		$selcountry = "";
		$getlantype = "_".str_replace("zh_","",$lantype);
		$getlantype = str_replace("_tw","",$getlantype);
		$fsql->query("select * from {P}".$getlantype."_member_zone where pid='0' and xuhao<>'0' order by xuhao");
		while ( $fsql->next_record( ) )
		{
			$ccat = $fsql->f("cat");
			if($country == $ccat){
				$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."' selected> ".$ccat."</option>";
			}else{
				$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."'> ".$ccat."</option>";
			}
		}

			$var=array (
				'id' => $id,
				'CHKman' => $CHKman, 
				'CHKwoman' => $CHKwoman, 
				'ZoneList' => $ZoneList, 
				'Province' => $Province, 
				'PassList' => $PassList, 
				'country' => $country,
				'addr_a' => $addr_a, 
				'addr_b' => $addr_b, 
				'addr_c' => $addr_c, 
				'tel' => $tel, 
				'mov' => $mov, 
				'postcode' => $postcode, 
				'name' => $name,
				'addr' => $addr,
				'zoneid' => $zoneid,
				'aid' => $id,
				'selcountry' => $selcountry,
				'REFERER' =>  $_SERVER['HTTP_REFERER'],
			);
			
			if($type == "mobi"){
				$strs = ShowTplTemp($TempArr["m3"],$var);
				$str.=str_replace("{#mobiact#}","memberaddrmodi",$strs);
			}else{
				$str.=ShowTplTemp($TempArr["m1"],$var);
			}
		}
	}elseif($act=="add"){
			$ZONE=ZoneList(0);
			$ZoneList=$ZONE["str"];
			$Province=$ZONE["pr"];
			
			$var=array (
				'ZoneList' => $ZoneList, 
				'Province' => $Province, 
				'PassList' => $PassList,
				'selcountry' => $blankcountry,
				'REFERER' =>  $_SERVER['HTTP_REFERER'],
			);
			$str.=ShowTplTemp($TempArr["m2"],$var);
	}
	

	return $str;

}



?>