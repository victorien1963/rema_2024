<?php

/*
	[元件名稱] 會員首頁-會員資訊
	[適用範圍] 會員中心
*/

function MemberHomeInfo(){

	global $msql;
		
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		
		
		//網址攔參數
		if(isset($_GET["mid"]) && $_GET["mid"]!="" && $_GET["mid"]!="0"){
			$mid=$_GET["mid"];
		}else{
			return "";
		}


		$msql->query("select * from {P}_member where memberid='$mid'");
		if($msql->next_record()){
			$memberid=$msql->f('memberid');
			$membertypeid=$msql->f('membertypeid');
			$membergroupid=$msql->f('membergroupid');
			$pname=$msql->f('pname');
			$regtime=date("Y-m-d",$msql->f('regtime'));
			$cent1=$msql->f('cent1');
			$cent2=$msql->f('cent2');
			$cent3=$msql->f('cent3');
			$memberface=$msql->f('memberface');
			$nowface=$msql->f('nowface');

		}

		//獲取積分名稱
		$msql->query("select * from {P}_member_centset");
		if($msql->next_record()){
			$centname1=$msql->f('centname1');
			$centname2=$msql->f('centname2');
			$centname3=$msql->f('centname3');
		}

		$cw1=MemberCentWidth($cent1);
		$cw2=MemberCentWidth($cent2);
		$cw3=MemberCentWidth($cent3);


		$face=ROOTPATH."member/face/".$nowface.".gif";

		$Temp=LoadTemp($tempname);

		$var=array(
			'pname' => $pname,
			'face' => $face, 
			'centname1' => $centname1,
			'centname2' => $centname2,
			'centname3' => $centname3,
			'cw1' => $cw1,
			'cw2' => $cw2,
			'cw3' => $cw3,
			'cent1' => $cent1,
			'cent2' => $cent2,
			'cent3' => $cent3,
			'regtime' => $regtime,
		);
		
		$str=ShowTplTemp($Temp,$var);

		return $str;


}

?>