<?php

/*
	[����W��] �����s�ixml
	[�A�νd��] ����
*/

function AdvsLbXml () { 

	global $msql;

	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$w=$GLOBALS["PLUSVARS"]["w"];
	$h=$GLOBALS["PLUSVARS"]["h"];
	
	//�Ҫ�����
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