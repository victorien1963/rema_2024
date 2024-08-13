<?php

/*
	[元件名稱] 自訂FLASH影片
	[適用範圍] 全站
*/

function DiyMovi(){


		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$movi=$GLOBALS["PLUSVARS"]["movi"];
		
		$Temp=LoadTemp($tempname);


		$var=array(
			'movi' => $movi
			);
		
		$str=ShowTplTemp($Temp,$var);
		
		return $str;


}

?>