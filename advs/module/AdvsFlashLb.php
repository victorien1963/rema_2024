<?php

/*
	[插件名称] flash广告轮播
	[适用范围] 全站
*/

function AdvsFlashLb () { 

	global $msql;

	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$picw=$GLOBALS["PLUSVARS"]["picw"];
	$pich=$GLOBALS["PLUSVARS"]["pich"];
	//模版解释
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);

	$str=$TempArr["start"];

	$msql->query("select * from {P}_advs_lb  where groupid='$groupid' order by xuhao limit 0,$shownums");
	while($msql->next_record()){
		$src=$msql->f('src');
		$url=$msql->f('url');
		$pics.=ROOTPATH.$src."|";
		$links.=ROOTPATH.$url."|";
	}

	$pics=substr($pics,0,(strlen($pics)-1));
	$links=substr($pics,0,(strlen($links)-1));
	$var=array ( 
		'pics' => $pics, 
		'links' => $links,
		'picw' => $picw,
		'pich' => $pich
		);
	$str.=ShowTplTemp($TempArr["end"],$var);

	return $str;

	
}



?>