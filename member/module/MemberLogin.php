<?php
function MemberLogin(){

	global $msql,$fsql,$SiteUrl;
	global $strLoginNotice1,$strLoginNotice2,$strLoginNotice3,$strLoginNotice4;

		
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];

		$Temp=LoadTemp($tempname);
		
		$var=array (
			'coltitle' => $coltitle,
			'REFERER' =>  $_GET["ref"]!=""? $_GET["ref"]:$_SERVER['HTTP_REFERER'],
		);

		$str=ShowTplTemp($Temp,$var);
				
		return $Temp;

}

?>