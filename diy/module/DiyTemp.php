<?php

/*
	[元件名稱] 自訂模版
	[適用範圍] 全站
*/

function DiyTemp(){

		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		
		$Temp=LoadTemp($tempname);
		return $Temp;

}

?>