<?php


function MemberAccountFins(){

	global $msql,$fsql;
	
				$tempname=$GLOBALS["PLUSVARS"]["tempname"];
				$Temp=LoadTemp($tempname);
				$TempArr=SplitTblTemp($Temp);
				
				$str=ShowTplTemp($Temp,$var);
				return $str;

}
?>