<?php

/*
	[元件名稱] 輪播廣告xml
	[適用範圍] 全站
*/

function AdvsLbXml () { 

	global $msql;

	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$w=$GLOBALS["PLUSVARS"]["w"];
	$h=$GLOBALS["PLUSVARS"]["h"];
	
	//模版解釋
	$Temp=LoadTemp($tempname);

	$var=array (
	'groupid' => $groupid, 
	'w' => $w, 
	'h' => $h
	);
	
	$str=ShowTplTemp($Temp,$var);

	return $str;

	
}



?>