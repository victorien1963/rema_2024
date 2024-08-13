<?php

/*
	[元件名稱] 自訂圖片+標題
	[適用範圍] 全站
*/

function PicWord(){


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$pic=$GLOBALS["PLUSVARS"]["pic"];
		$piclink=$GLOBALS["PLUSVARS"]["piclink"];
		$word=$GLOBALS["PLUSVARS"]["word"];
		$link=$GLOBALS["PLUSVARS"]["link"];

		$Temp=LoadTemp($tempname);

		$src=ROOTPATH.$pic;

		$var=array(
			'coltitle' => $coltitle,
			'src' => $src,
			'piclink' => $piclink,
			'word' => $word,
			'link' => $link
			);
		
		
		$str=ShowTplTemp($Temp,$var);

		return $str;


}

?>