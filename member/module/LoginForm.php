<?php

/*
	[����W��] �|���n�J���
	[�A�νd��] ����

*/

function LoginForm(){


global $fsql;



	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];


	$Temp=LoadTemp($tempname);


	$var=array (
		'coltitle' => $coltitle,
		'REFERER' =>  $_SERVER['HTTP_REFERER']
	);

	$str=ShowTplTemp($Temp,$var);
	

	return $str;

}

?>