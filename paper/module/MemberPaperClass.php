<?php
function MemberPaperClass( )
{
				global $msql;
				global $fsql;
				$target = $GLOBALS['PLUSVARS']['target'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				if ( isset( $_GET['mid'] ) && $_GET['mid'] != "" && $_GET['mid'] != "0" )
				{
								$mid = $_GET['mid'];
				}
				else
				{
								return "";
				}
				$scl = "  memberid='{$mid}' ";
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$str = $TempArr['start'];
				$msql->query( "select * from {P}_paper_pcat where {$scl} order by xuhao" );
				while ( $msql->next_record( ) )
				{
								$catid = $msql->f( "catid" );
								$cat = $msql->f( "cat" );
								$link = ROOTPATH."paper/memberpaper.php?mid=".$mid."&pcatid=".$catid;
								$var = array(
												"link" => $link,
												"cat" => $cat,
												"target" => $target
								);
								$str .= showtpltemp( $TempArr['list'], $var );
				}
				$str .= $TempArr['end'];
				return $str;
}

?>