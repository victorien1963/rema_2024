<?php

/*
	[元件名稱] 背景音樂
	[適用範圍] 全站
*/

function BgSound(){


		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$attach=$GLOBALS["PLUSVARS"]["attach"];
		
		$Temp=LoadTemp($tempname);

		$attach=ROOTPATH.$attach;

		$var=array(
			'attach' => $attach
			);
		
		$str=ShowTplTemp($Temp,$var);
		

		return $str;


}

?>