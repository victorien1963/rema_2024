<?php

/*
	[元件名稱] 外框
	[適用範圍] 全站
*/

function PlusBorder(){


		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		
		$Temp=LoadTemp($tempname);

		return $Temp;

}

?>