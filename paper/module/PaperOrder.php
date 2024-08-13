<?php
function PaperOrder( )
{
				global $fsql;
				global $msql;								$coltitle = $GLOBALS["PLUSVARS"]["coltitle"];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				$memberid = $_COOKIE["MEMBERID"];
				$Temp = loadtemp( $tempname );				$TempArr=SplitTblTemp($Temp);
				$str = $TempArr['start'];
					$var=array (
						'memberid' => $memberid
					);

				$str.=ShowTplTemp($TempArr["end"],$var);
				return $str;
}

?>