<?php

/*
	[元件名稱] 會員首頁-會員簡介
	[適用範圍] 會員中心
*/

function MemberIntro(){

	global $msql;
		
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];

		
		//網址攔參數
		if(isset($_GET["mid"]) && $_GET["mid"]!="" && $_GET["mid"]!="0"){
			$mid=$_GET["mid"];
		}else{
			return "";
		}


		$msql->query("select bz from {P}_member where memberid='$mid'");
		if($msql->next_record()){
			$bz=$msql->f('bz');
		}

		$intro=nl2br($bz);

		$Temp=LoadTemp($tempname);

		$var=array(
			'intro' => $intro
		);
		
		$str=ShowTplTemp($Temp,$var);

		return $str;


}

?>