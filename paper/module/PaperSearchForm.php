<?php
function PaperSearchForm( )
{
				global $msql;
				global $fsql;
				$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
				{
								$Arr = explode( ".html", $_SERVER['QUERY_STRING'] );
								$nowcatid = $Arr[0];
				}
				else if ( 0 < $_GET['catid'] )
				{
								$nowcatid = $_GET['catid'];
				}
				else
				{
								$nowcatid = 0;
				}
				$key = $_GET['key'];
				$myord = $_GET['myord'];
				$myshownums = $_GET['myshownums'];
				$fsql->query( "select * from {P}_paper_cat where pid='0'" );
				while ( $fsql->next_record( ) )
				{
								$cat = $fsql->f( "cat" );
								$catid = $fsql->f( "catid" );
								if ( $nowcatid == $catid )
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
								"catlist" => $catlist
				);
				$str = showtpltemp( $Temp, $var );
				return $str;
}

?>