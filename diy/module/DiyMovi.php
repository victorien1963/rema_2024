<?php

/*
	[����W��] �ۭqFLASH�v��
	[�A�νd��] ����
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