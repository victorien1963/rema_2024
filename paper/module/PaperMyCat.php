<?php
function PaperMyCat( )
{
				global $fsql;
				global $tsql;
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				$memberid = $_COOKIE['MEMBERID'];
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$str = $TempArr['start'];
				$fsql->query( "select * from {P}_paper_pcat where memberid='{$memberid}' order by xuhao " );
				while ( $fsql->next_record( ) )
				{
								$catid = $fsql->f( "catid" );
								$cat = $fsql->f( "cat" );
								$xuhao = $fsql->f( "xuhao" );
								$var = array(
												"catid" => $catid,
												"cat" => $cat,
												"xuhao" => $xuhao
								);
								$str .= showtpltemp( $TempArr['list'], $var );
				}
				$str .= $TempArr['end'];
				return $str;
}

?>