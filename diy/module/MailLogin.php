<?php

/*
	[插件名称] 企业邮箱登录
	[适用范围] 全站
*/

function MailLogin(){

		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$link=$GLOBALS["PLUSVARS"]["link"];
		$domain=$GLOBALS["PLUSVARS"]["word"];
		$formname=$GLOBALS["PLUSVARS"]["word1"];
		$formpass=$GLOBALS["PLUSVARS"]["word2"];
		$formdomain=$GLOBALS["PLUSVARS"]["word3"];

		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$var=array(
			'link' => $link,
			'domain' => $domain,
			'formname' => $formname,
			'formpass' => $formpass,
			'formdomain' => $formdomain
		);
		
		$str=ShowTplTemp($TempArr["start"],$var);

		return $str;


}

?>