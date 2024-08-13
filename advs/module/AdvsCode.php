<?php

/*
	[元件名稱] 廣告原始碼
	[適用範圍] 全站
*/

function AdvsCode() { 
	
	global $msql;


	$code=$GLOBALS["PLUSVARS"]["code"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];


	$Temp=LoadTemp($tempname);


	$var=array (
		'code' => $code
	);
	
	$str=ShowTplTemp($Temp,$var);

	return $str;


		
}



?>