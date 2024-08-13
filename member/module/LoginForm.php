<?php

/*
	[元件名稱] 會員登入表單
	[適用範圍] 全站

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