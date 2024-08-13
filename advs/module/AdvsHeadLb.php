<?php

/*
	[元件名稱] 頭部輪播(可共享設置) 
	[適用範圍] 全站
*/

function AdvsHeadLb () { 

	global $msql;

	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	
	//模版解釋
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);

	$var=array(
		'coltitle' => $coltitle
	);

	$str=ShowTplTemp($TempArr["start"],$var);

	$n=0;
	$msql->query("select * from {P}_advs_lb  where groupid='$groupid' order by xuhao limit 0,$shownums");
	while($msql->next_record()){
		$id=$msql->f('id');
		$src=$msql->f('src');
		$url=$msql->f('url');
		$title=$msql->f('title');
		$text=$msql->f('text');

		$src=ROOTPATH.$src;
		$var=array (
		'n' => $n, 
		'src' => $src, 
		'url' => $url
		);
		if($url=="http://" || $url==""){
			$str.=ShowTplTemp($TempArr["text"],$var);
		}else{
			$str.=ShowTplTemp($TempArr["list"],$var);
		}
		
		$n++;
	}

	$str.=$TempArr["end"];

	return $str;

	
}



?>