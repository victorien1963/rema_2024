<?php

/*
	[元件名稱] 分組標籤切換外框
	[適用範圍] 全站
*/

function GroupLable(){


		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		
		$Temp=LoadTemp($tempname);

		return $Temp;

}

?>