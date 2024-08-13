<?php

/*
	[元件名稱] 模組導航條
	[適用範圍] 模組
*/


function LinkNavPath(){

	global $msql;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];

	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);


	$var=array (
		'coltitle' => $coltitle,
		'sitename' => $GLOBALS["CONF"]["SiteName"],
	);

	$str=ShowTplTemp($TempArr["start"],$var);


	//頁頭標題
	$GLOBALS["pagetitle"]=$GLOBALS["PSET"]["name"];


	$str.=$TempArr["end"];
	return $str;
}

?>