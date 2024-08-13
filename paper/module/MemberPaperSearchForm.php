<?php
function MemberPaperSearchForm( )
{
				global $msql;
				global $fsql;
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				if ( isset( $_GET['mid'] ) && $_GET['mid'] != "" && $_GET['mid'] != "0" )
				{
								$mid = $_GET['mid'];
				}
				else
				{
								return "";
				}
				$key = $_GET['key'];
				$myord = $_GET['myord'];
				$myshownums = $_GET['myshownums'];
				$pcatid = $_GET['pcatid'];
				$fsql->query( "select * from {P}_paper_pcat where memberid='{$mid}'  order by xuhao" );
				while ( $fsql->next_record( ) )
				{
								$cat = $fsql->f( "cat" );
								$catid = $fsql->f( "catid" );
								if ( $pcatid == $catid )
								{
												$catlist .= "<option value='".$catid."' selected>".$cat."</option>";
								}
								else
								{
												$catlist .= "<option value='".$catid."'>".$cat."</option>";
								}
				}
				$Temp = loadtemp( $tempname );
				$var = array(
								"coltitle" => $coltitle,
								"myshownums" => $myshownums,
								"myord" => $myord,
								"key" => $key,
								"mid" => $mid,
								"catlist" => $catlist
				);
				$str = showtpltemp( $Temp, $var );
				return $str;
}

?>