<?php

/*
	[插件名称] 自定义透明flash效果
	[适用范围] 全站
*/

function HeadTraFlashCyrano(){


		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$pic=$GLOBALS["PLUSVARS"]["pic"];
		$w=$GLOBALS["PLUSVARS"]["w"];
		$h=$GLOBALS["PLUSVARS"]["h"];
		
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$src=ROOTPATH.$pic;

		$var=array(
			'src' => $src,
			'w' => $w,
			'h' => $h
		);
		
		$str=ShowTplTemp($TempArr["start"],$var);
		
		if(substr($pic,-4)==".swf"){
			$str.=ShowTplTemp($TempArr["menu"],$var);
		}else{
			$str.=ShowTplTemp($TempArr["list"],$var);
		}


		return $str;


}

?>