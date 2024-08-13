<?php

/*
	[元件名稱] 腳注資訊
	[適用範圍] 全站統一
*/

function ButtomInfo(){

	global $msql, $lantype;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	//$body=$GLOBALS["PLUSVARS"]["body"];
	$pdv = $GLOBALS["PLUSVARS"]["pdv"];
	
	$Temp=LoadTemp($tempname);

	$getlans = $msql->getone("SELECT * FROM {P}_base_plus_translate WHERE pid='$pdv' AND langcode='$lantype'");
		
	$body=$getlans['body']? $getlans['body']:$GLOBALS["PLUSVARS"]["body"];

	$var=array (
		'coltitle' => $coltitle,
		'body' => $body
	);


	
	$str=ShowTplTemp($Temp,$var);
	return $str;

}

?>