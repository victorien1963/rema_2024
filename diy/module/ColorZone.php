<?php

/*
	[元件名稱] 顏色區域
	[適用範圍] 全站
*/

function ColorZone(){


		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		
		$Temp=LoadTemp($tempname);

		return $Temp;

}

?>