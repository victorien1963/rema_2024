<?php

/*
	[元件名稱] 文字廣告位
	[適用範圍] 全站
*/

function AdvsText() { 
	
	global $msql;


	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$link=$GLOBALS["PLUSVARS"]["link"];
	
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];


	$msql->query("select * from {P}_advs_text where id='$groupid'");
	if($msql->next_record()){
		//list($text,$text2)=explode("-",$msql->f('text'));
		$text = $msql->f('text');
		$link=$msql->f('url');
	}

	$Temp=LoadTemp($tempname);


	$var=array (
		'text' => $text,
		'text2' => $text2,
		'link' => $link
	);
	
		$str=ShowTplTemp($Temp,$var);

	return $str;


		
}



?>